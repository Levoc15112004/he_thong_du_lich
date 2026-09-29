<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MomoController extends Controller
{
    private $endpoint = 'https://test-payment.momo.vn/v2/gateway/api/create';

    private $partnerCode = 'MOMO';

    private $accessKey = 'F8BBA842ECF85';

    private $secretKey = 'K951B6PE1waDMi640xX08PD3vg6EkVlz';

    // ================= LOG TRANSACTION =================
    private function logTransaction($paymentId, $type, $amount, $code = null, $response = null, $status = 'pending')
    {
        return Transaction::create([
            'payment_id' => $paymentId,
            'transaction_type' => $type,
            'amount' => $amount,
            'transaction_code' => $code,
            'response_data' => $response ? json_encode($response) : null,
            'status' => $status,
        ]);
    }

    // ================= CREATE MOMO =================
    private function createMomo($order, $amount, $typeText, $type)
    {
        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $amount,
            'payment_type' => $type,
            'payment_method' => 'MoMo',
            'status' => 0,
        ]);

        $orderId = strtoupper($type).'_'.$order->id.'_'.time();
        $requestId = $orderId;

        $redirectUrl = route('momo.return');
        $ipnUrl = route('momo.ipn');

        $rawHash =
            "accessKey={$this->accessKey}".
            "&amount={$amount}".
            '&extraData='.
            "&ipnUrl={$ipnUrl}".
            "&orderId={$orderId}".
            "&orderInfo={$typeText}".
            "&partnerCode={$this->partnerCode}".
            "&redirectUrl={$redirectUrl}".
            "&requestId={$requestId}".
            '&requestType=captureWallet';

        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);

        $response = Http::post($this->endpoint, [
            'partnerCode' => $this->partnerCode,
            'accessKey' => $this->accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $typeText,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'extraData' => '',
            'requestType' => 'captureWallet',
            'signature' => $signature,
        ]);

        $result = $response->json();

        Log::info('MoMo Response', $result);

        if (! isset($result['payUrl'])) {
            return back()->with('error', 'MoMo Error');
        }

        // INIT TRANSACTION
        $this->logTransaction($payment->id, 'init', $amount, $orderId, $result, 'pending');

        return redirect($result['payUrl']);
    }

    public function createDeposit(Order $order)
    {
        $amount = (int) round($order->total_price * 0.3);

        return $this->createMomo($order, $amount, 'Thanh toán cọc 30%', 'deposit');
    }

    public function createFinal(Order $order)
    {
        $amount = (int) round($order->total_price * 0.7);

        return $this->createMomo($order, $amount, 'Thanh toán 70%', 'final');
    }

    // ================= IPN =================
    public function ipn(Request $request)
    {
        Log::info('===== MOMO IPN =====', $request->all());

        $data = $request->all();
        $extraData = $data['extraData'] ?? '';

        $rawHash =
            "accessKey={$this->accessKey}".
            "&amount={$data['amount']}".
            "&extraData={$extraData}".
            "&message={$data['message']}".
            "&orderId={$data['orderId']}".
            "&orderInfo={$data['orderInfo']}".
            "&orderType={$data['orderType']}".
            "&partnerCode={$data['partnerCode']}".
            "&payType={$data['payType']}".
            "&requestId={$data['requestId']}".
            "&responseTime={$data['responseTime']}".
            "&resultCode={$data['resultCode']}".
            "&transId={$data['transId']}";

        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);

        if ($signature !== $data['signature']) {
            Log::error('SIGNATURE INVALID');

            return response()->json(['message' => 'invalid signature']);
        }

        $transaction = Transaction::where('transaction_code', $data['orderId'])->first();

        if (! $transaction) {
            return response()->json(['message' => 'not found']);
        }

        $payment = $transaction->payment;

        if ($data['resultCode'] == 0 && $payment->status != 1) {

            // UPDATE PAYMENT
            $payment->update([
                'status' => 1,
                'payment_date' => now(),
            ]);

            // UPDATE ORDER + NOTIFICATION
            if ($payment->payment_type == 'deposit') {

                $payment->order->update(['status' => 1]);

                $this->createPaymentNotification(
                    $payment->order->user_id,
                    $payment->order,
                    30
                );
            }

            if ($payment->payment_type == 'final') {

                $payment->order->update(['status' => 2]);

                $this->createPaymentNotification(
                    $payment->order->user_id,
                    $payment->order,
                    70
                );
            }

            // LOG CONFIRM (CHỐNG DUPLICATE)
            if (! Transaction::where('transaction_code', $data['transId'])->exists()) {
                Transaction::create([
                    'payment_id' => $payment->id,
                    'transaction_type' => 'confirm',
                    'amount' => $payment->amount,
                    'transaction_code' => $data['transId'],
                    'response_data' => json_encode($data),
                    'status' => 'success',
                ]);
            }
        }

        return response()->json(['message' => 'ok']);
    }

    // ================= RETURN =================
    public function return(Request $request)
    {
        Log::info('MoMo Return', $request->all());

        $orderId = $request->orderId;
        $resultCode = $request->resultCode;

        $transaction = Transaction::where('transaction_code', $orderId)->first();

        if (! $transaction) {
            return redirect()->route('home');
        }

        $payment = $transaction->payment;

        if ($resultCode == 0 && $payment->status != 1) {

            $payment->update([
                'status' => 1,
                'payment_date' => now(),
            ]);

            if ($payment->payment_type == 'deposit') {

                $payment->order->update(['status' => 1]);

                $this->createPaymentNotification(
                    $payment->order->user_id,
                    $payment->order,
                    30
                );
            }

            if ($payment->payment_type == 'final') {

                $payment->order->update(['status' => 2]);

                $this->createPaymentNotification(
                    $payment->order->user_id,
                    $payment->order,
                    70
                );
            }

            if (! Transaction::where('transaction_code', $request->transId)->exists()) {
                Transaction::create([
                    'payment_id' => $payment->id,
                    'transaction_type' => 'confirm',
                    'amount' => $payment->amount,
                    'transaction_code' => $request->transId,
                    'response_data' => json_encode($request->all()),
                    'status' => 'success',
                ]);
            }
        }

        if ($resultCode != 0) {
            return redirect()->back()->with('error', 'Thanh toán thất bại!');
        }

        if ($payment->payment_type == 'deposit') {
            return redirect()
                ->route('tour.thankyou', $payment->order_id)
                ->with('success', 'Thanh toán cọc thành công!');
        }

        if ($payment->payment_type == 'final') {
            return redirect()
                ->route('tour.thankyou.final', $payment->order_id)
                ->with('success', 'Thanh toán hoàn tất!');
        }

        return redirect()->route('home');
    }

    // ================= NOTIFICATION =================
    private function createPaymentNotification($userId, $order, $percent)
    {
        Notification::create([
            'user_id' => $userId,
            'title' => 'Thanh toán thành công',
            'message' => $percent == 30
                ? "Bạn đã thanh toán thành công 30% tiền cọc cho {$order->tour->name}."
                : "Bạn đã thanh toán thành công cho {$order->tour->name}.",
            'type' => 'payment',
            'status' => 'unread',
        ]);
    }
}
