<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
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

    // Tạo PayPal Order
    public function createPayment(Request $request, $order_id)
    {
        $order = Order::findOrFail($order_id);
        $depositAmount = round($order->total_price * 0.3, 0);

        //  Tạo payment
        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $depositAmount,
            'payment_type' => 'deposit',
            'payment_method' => 'PayPal',
            'status' => 0,
            'payment_date' => now(),
        ]);

        //  Ghi transaction INIT
        $this->logTransaction(
            paymentId: $payment->id,
            type: 'init',
            amount: $payment->amount,
            code: null,
            response: null,
            status: 'pending'
        );

        //  Tạo PayPal Order
        $paypal = new PayPalClient;
        $paypal->setApiCredentials(config('paypal'));
        $paypal->setAccessToken($paypal->getAccessToken());

        $usd = number_format($payment->amount / 23000, 2, '.', '');

        $data = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'invoice_id' => 'ORDER-'.$order->id,
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $usd,
                    ],
                ],
            ],
            'application_context' => [
                'cancel_url' => route('user.tour.deposit', $order->id),
                'return_url' => route('paypal.capture'),
            ],
        ];

        try {
            $response = $paypal->createOrder($data);

            if (isset($response['links'])) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        if (!$request->wantsJson() && !$request->ajax()) {
                            return redirect()->away($link['href']);
                        }
                        return response()->json([
                            'orderID' => $response['id'] ?? null,
                            'approve_url' => $link['href'],
                            'status' => 'success',
                        ]);
                    }
                }
            }

            return response()->json([
                'orderID' => $response['id'] ?? null,
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error('PayPal createPayment error: ' . $e->getMessage());
            if (!$request->wantsJson() && !$request->ajax()) {
                return back()->with('error', 'Cổng thanh toán PayPal đang được kết nối: ' . $e->getMessage());
            }
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // Capture thanh toán
    public function capture(Request $request)
    {
        $orderID = $request->input('orderID') ?? $request->input('token');

        if (! $orderID) {
            if (! $request->wantsJson() && ! $request->ajax()) {
                return redirect()->route('home')->with('error', 'Không tìm thấy mã thanh toán PayPal.');
            }
            return response()->json(['status' => 'error', 'message' => 'Missing order ID or token'], 400);
        }

        $paypal = new PayPalClient;
        $paypal->setApiCredentials(config('paypal'));
        $paypal->setAccessToken($paypal->getAccessToken());

        $response = $paypal->capturePaymentOrder($orderID);

        if (! isset($response['status']) || $response['status'] !== 'COMPLETED') {
            Log::error('PayPal capture failed', ['response' => $response]);

            $invoiceId = $response['purchase_units'][0]['payments']['captures'][0]['invoice_id'] ?? null;
            $orderId = $invoiceId ? (int) str_replace('ORDER-', '', $invoiceId) : null;
            $payment = $orderId ? Payment::where('order_id', $orderId)->where('payment_method', 'PayPal')->latest()->first() : null;

            if ($payment) {
                $this->logTransaction(
                    paymentId: $payment->id,
                    type: 'error',
                    amount: 0,
                    code: $orderID,
                    response: $response,
                    status: 'failed'
                );
            }

            if (! $request->wantsJson() && ! $request->ajax()) {
                return redirect()->route('home')->with('error', 'Thanh toán PayPal không thành công hoặc đã bị từ chối.');
            }

            return response()->json([
                'status' => 'error',
                'message' => 'PayPal capture failed',
                'paypal_response' => $response,
            ], 400);
        }

        // Lấy order ID từ invoice_id
        $invoiceId = $response['purchase_units'][0]['payments']['captures'][0]['invoice_id'] ?? null;
        $orderId = $invoiceId ? (int) str_replace('ORDER-', '', $invoiceId) : null;

        $order = $orderId ? Order::find($orderId) : null;
        if (! $order) {
            if (! $request->wantsJson() && ! $request->ajax()) {
                return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng tương ứng.');
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        $payment = Payment::where('order_id', $order->id)
            ->where('payment_method', 'PayPal')
            ->latest()
            ->first();

        if (! $payment) {
            if (! $request->wantsJson() && ! $request->ajax()) {
                return redirect()->route('tour.thankyou', $order->id);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Payment not found',
            ], 404);
        }

        $captureId = $response['purchase_units'][0]['payments']['captures'][0]['id'] ?? $response['id'];

        $payment->update([
            'charge_id' => $captureId,
            'status' => 1,
            'payment_date' => now(),
        ]);

        // Update Order
        $order->update(['status' => 1]);
        $this->createPaymentNotification(
            $order->user_id,
            $order,
            30
        );

        // Ghi transaction SUCCESS
        $this->logTransaction(
            paymentId: $payment->id,
            type: 'confirm',
            amount: $payment->amount,
            code: $response['id'],
            response: $response,
            status: 'success'
        );

        if (! $request->wantsJson() && ! $request->ajax()) {
            return redirect()->route('tour.thankyou', $order->id)->with('success', 'Thanh toán tiền cọc qua PayPal thành công!');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Thanh toán thành công',
        ]);
    }

    public function createFinalPayment(Request $request, $order_id)
    {
        $order = Order::findOrFail($order_id);
        $finalAmount = round($order->total_price * 0.7, 0);  // 70%

        // Tạo payment final
        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $finalAmount,
            'payment_type' => 'final',   
            'payment_method' => 'PayPal',
            'status' => 0,
            'payment_date' => now(),
        ]);

        // Log transaction INIT
        $this->logTransaction(
            paymentId: $payment->id,
            type: 'init',
            amount: $payment->amount,
            code: null,
            response: null,
            status: 'pending'
        );

        // Tạo PayPal Order
        $paypal = new PayPalClient;
        $paypal->setApiCredentials(config('paypal'));
        $paypal->setAccessToken($paypal->getAccessToken());

        // Quy đổi USD
        $usd = number_format($payment->amount / 23000, 2, '.', '');

        $data = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'invoice_id' => 'ORDER-FINAL-'.$order->id,
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $usd,
                    ],
                ],
            ],
            'application_context' => [
                'cancel_url' => route('user.payment.final', $order->id),
                'return_url' => route('paypal.captureFinal'),
            ],
        ];

        try {
            $response = $paypal->createOrder($data);

            if (isset($response['links'])) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        if (!$request->wantsJson() && !$request->ajax()) {
                            return redirect()->away($link['href']);
                        }
                        return response()->json([
                            'orderID' => $response['id'] ?? null,
                            'approve_url' => $link['href'],
                            'status' => 'success',
                        ]);
                    }
                }
            }

            return response()->json([
                'orderID' => $response['id'] ?? null,
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error('PayPal createFinalPayment error: ' . $e->getMessage());
            if (!$request->wantsJson() && !$request->ajax()) {
                return back()->with('error', 'Cổng thanh toán PayPal đang được kết nối: ' . $e->getMessage());
            }
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function captureFinal(Request $request)
    {
        $orderID = $request->input('orderID') ?? $request->input('token');

        if (! $orderID) {
            if (! $request->wantsJson() && ! $request->ajax()) {
                return redirect()->route('home')->with('error', 'Không tìm thấy mã thanh toán PayPal.');
            }
            return response()->json(['status' => 'error', 'message' => 'Missing order ID or token'], 400);
        }

        $paypal = new PayPalClient;
        $paypal->setApiCredentials(config('paypal'));
        $paypal->setAccessToken($paypal->getAccessToken());

        // Capture từ PayPal
        $response = $paypal->capturePaymentOrder($orderID);

        // XỬ LÝ NẾU FAILED
        if (! isset($response['status']) || $response['status'] !== 'COMPLETED') {
            Log::error('PayPal final capture failed', ['response' => $response]);

            $invoiceId = $response['purchase_units'][0]['payments']['captures'][0]['invoice_id'] ?? null;
            $orderId = $invoiceId ? (int) last(explode('-', $invoiceId)) : null;
            $payment = $orderId ? Payment::where('order_id', $orderId)->where('payment_method', 'PayPal')->where('payment_type', 'final')->latest()->first() : null;

            if ($payment) {
                $this->logTransaction(
                    paymentId: $payment->id,
                    type: 'error',
                    amount: 0,
                    code: $orderID,
                    response: $response,
                    status: 'failed'
                );
            }

            if (! $request->wantsJson() && ! $request->ajax()) {
                return redirect()->route('home')->with('error', 'Thanh toán 70% qua PayPal không thành công.');
            }

            return response()->json([
                'status' => 'error',
                'message' => 'PayPal final capture failed',
                'paypal_response' => $response,
            ], 400);
        }

        // LẤY ORDER ID TỪ invoice_id
        $invoiceId = $response['purchase_units'][0]['payments']['captures'][0]['invoice_id'] ?? null;
        $orderId = $invoiceId ? (int) last(explode('-', $invoiceId)) : null;

        $order = $orderId ? Order::find($orderId) : null;
        if (! $order) {
            if (! $request->wantsJson() && ! $request->ajax()) {
                return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng.');
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        // LẤY PAYMENT FINAL
        $payment = Payment::where('order_id', $order->id)
            ->where('payment_method', 'PayPal')
            ->where('payment_type', 'final')
            ->latest()
            ->first();

        if (! $payment) {
            if (! $request->wantsJson() && ! $request->ajax()) {
                return redirect()->route('tour.thankyou.final', $order->id);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Final payment not found',
            ], 404);
        }

        // UPDATE PAYMENT
        $captureId = $response['purchase_units'][0]['payments']['captures'][0]['id'] ?? $response['id'];
        $payment->update([
            'charge_id' => $captureId,
            'status' => 1,
            'payment_date' => now(),
        ]);

        // UPDATE ORDER → PAID FULLY
        $order->update([
            'status' => 2, // Đã thanh toán hết
        ]);
        $this->createPaymentNotification(
            $order->user_id,
            $order,
            70
        );

        // LOG 
        $this->logTransaction(
            paymentId: $payment->id,
            type: 'confirm',
            amount: $payment->amount,
            code: $response['id'],
            response: $response,
            status: 'success'
        );

        if (! $request->wantsJson() && ! $request->ajax()) {
            return redirect()->route('tour.thankyou.final', $order->id)->with('success', 'Thanh toán 70% còn lại qua PayPal thành công!');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Thanh toán 70% còn lại thành công.',
        ]);
    }

    public function createRefund(Request $request, $payment_id)
    {
        $payment = Payment::findOrFail($payment_id);

        // Chỉ cho phép refund khi payment đã thanh toán thành công
        if ($payment->status !== 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment chưa ở trạng thái thanh toán thành công',
            ], 400);
        }

        // BẮT BUỘC phải có capture_id
        if (! $payment->charge_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment chưa được capture nên không thể hoàn tiền',
            ], 400);
        }

        // Không cho refund trùng
        $refunded = Transaction::where('payment_id', $payment->id)
            ->where('transaction_type', 'refund')
            ->where('status', 'success')
            ->exists();

        if ($refunded) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment này đã được hoàn tiền',
            ], 400);
        }

        // Log INIT REFUND
        $this->logTransaction(
            paymentId: $payment->id,
            type: 'refund',
            amount: $payment->amount,
            code: null,
            response: null,
            status: 'pending'
        );

        return response()->json([
            'status' => 'success',
            'payment_id' => $payment->id,
            'message' => 'Khởi tạo hoàn tiền thành công',
        ]);
    }

    public function captureRefund(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
        ]);

        $payment = Payment::findOrFail($request->payment_id);

        //  Check trạng thái payment
        if ($payment->status !== 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment không ở trạng thái có thể hoàn tiền',
            ], 400);
        }

        if (! $payment->charge_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'charge_id trống – payment chưa được capture',
            ], 400);
        }

        //  Chuẩn bị dữ liệu refund
        $invoiceId = 'REFUND-'.$payment->id;
        $amountUSD = round($payment->amount / 23000, 2); // VND → USD
        $note = 'Hoan tien don hang #'.$payment->order_id;

        //  Gọi PayPal
        $paypal = new PayPalClient;
        $paypal->setApiCredentials(config('paypal'));
        $paypal->setAccessToken($paypal->getAccessToken());

        $response = $paypal->refundCapturedPayment(
            $payment->charge_id, 
            $invoiceId,          
            $amountUSD,         
            $note               
        );

        if (! isset($response['status'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'PayPal response invalid',
                'paypal' => $response,
            ], 500);
        }

        if ($response['status'] !== 'COMPLETED') {

            $this->logTransaction(
                paymentId: $payment->id,
                type: 'refund',
                amount: 0,
                code: $response['id'] ?? null,
                response: $response,
                status: 'failed'
            );

            return response()->json([
                'status' => 'error',
                'message' => 'Hoàn tiền thất bại',
                'paypal' => $response,
            ], 400);
        }

        //  Update payment → REFUNDED
        $payment->update([
            'status' => 3,
        ]);

        //  Log 
        Transaction::create([
            'payment_id' => $payment->id,
            'transaction_type' => 'refund',
            'amount' => $payment->amount,
            'transaction_code' => $response['id'],
            'response_data' => json_encode($response),
            'status' => 'success',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Hoàn tiền thành công',
        ]);
    }

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