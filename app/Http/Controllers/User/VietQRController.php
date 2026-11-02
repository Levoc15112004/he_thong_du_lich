<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VietQRController extends Controller
{
    /**
     * Webhook nhận Callback Biến động số dư từ VietQR (Transaction Sync)
     */
    public function handleTransactionSync(Request $request)
    {
        Log::info('VietQR Webhook:', $request->all());

        try {
            $data = $request->all();
            $amount = $data['amount'] ?? 0;
            $content = $data['content'] ?? '';
            $orderId = $data['orderId'] ?? null;
            $transactionId = $data['transactionid'] ?? ('TX' . time());
            $transType = strtoupper($data['transType'] ?? 'C');

            if (!$orderId && preg_match('/(?:WANDERLUST\s*)?DH(\d+)/i', $content, $matches)) {
                $orderId = $matches[1];
            }

            if (!$orderId) {
                return response()->json([
                    'error' => true,
                    'errorReason' => 'ORDER_NOT_FOUND',
                    'toastMessage' => 'Không tìm thấy mã đơn hàng',
                    'object' => null
                ], 400);
            }

            $order = Order::find($orderId);
            if (!$order) {
                return response()->json([
                    'error' => true,
                    'errorReason' => 'ORDER_NOT_FOUND',
                    'toastMessage' => "Không tìm thấy đơn hàng #{$orderId}",
                    'object' => null
                ], 404);
            }

            if ($transType === 'C') {
                $newStatus = ($amount >= $order->total_price) ? 2 : 1;
                $order->update(['status' => $newStatus]);

                $payment = Payment::create([
                    'order_id' => $order->id,
                    'amount' => $amount,
                    'payment_type' => ($newStatus === 2) ? 'full' : 'deposit',
                    'payment_method' => 'VietQR',
                    'status' => 1,
                    'payment_date' => now(),
                ]);

                Transaction::create([
                    'payment_id' => $payment->id,
                    'transaction_type' => 'credit',
                    'amount' => $amount,
                    'transaction_code' => $transactionId,
                    'response_data' => json_encode($data),
                    'status' => 'success',
                ]);

                if ($order->user_id) {
                    Notification::create([
                        'user_id' => $order->user_id,
                        'title' => 'Thanh toán cọc VietQR thành công',
                        'message' => "Đơn tour #{$order->id} ({$order->tour->name}) đã nhận được khoản thanh toán cọc " . number_format($amount, 0, ',', '.') . "đ qua VietQR. Vé giữ chỗ đã được kích hoạt!",
                        'type' => 'payment',
                        'status' => 'unread',
                    ]);
                }

                $admins = User::where('role', 'admin')->get();
                foreach ($admins as $admin) {
                    Notification::create([
                        'user_id' => $admin->id,
                        'title' => "Biến động số dư VietQR: Đơn #{$order->id}",
                        'message' => "Khách hàng {$order->name} đã chuyển khoản " . number_format($amount, 0, ',', '.') . "đ cọc cho tour #{$order->id} qua VietQR.",
                        'type' => 'payment',
                        'status' => 'unread',
                    ]);
                }

                return response()->json([
                    'error' => false,
                    'errorReason' => null,
                    'toastMessage' => 'Transaction processed successfully',
                    'object' => ['reftransactionid' => $transactionId]
                ], 200);
            }

            return response()->json(['error' => false, 'toastMessage' => 'Bỏ qua giao dịch không phải ghi có', 'object' => null], 200);
        } catch (\Throwable $e) {
            Log::error('VietQR Webhook Error: ' . $e->getMessage());
            return response()->json(['error' => true, 'toastMessage' => $e->getMessage(), 'object' => null], 500);
        }
    }

    /**
     * API kiểm tra trạng thái đơn hàng thời gian thực cho Client Polling
     */
    public function checkOrderStatus($order_id)
    {
        $order = Order::with('payments')->find($order_id);
        if (!$order) {
            return response()->json(['paid' => false, 'status' => -1], 404);
        }

        $hasSuccess = $order->payments->where('status', 1)->count() > 0;
        $isPaid = ($order->status == 1 || $order->status == 2 || $hasSuccess);

        return response()->json([
            'order_id' => $order->id,
            'status' => $order->status,
            'paid' => $isPaid,
            'redirect_url' => route('tour.thankyou', $order->id) . '?method=bank',
        ]);
    }

    /**
     * Giả lập thanh toán thành công (Phục vụ Demo / Test nhanh)
     */
    public function simulateSuccessPayment($order_id)
    {
        $order = Order::findOrFail($order_id);
        $depositAmount = round($order->total_price * 0.3, 0);

        $dummyRequest = new Request([
            'bankaccount' => '0909888999',
            'amount' => $depositAmount,
            'transType' => 'C',
            'content' => "WANDERLUST DH{$order->id}",
            'transactionid' => 'VQR_TEST_' . time(),
            'transactiontime' => now()->timestamp * 1000,
            'orderId' => (string)$order->id,
        ]);

        $this->handleTransactionSync($dummyRequest);

        return redirect()->route('tour.thankyou', $order->id)->with('success', 'Thanh toán cọc VietQR thành công! Tiền đã vào tài khoản và tour đã được kích hoạt.');
    }
}
