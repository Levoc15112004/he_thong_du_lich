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
        Log::info('VietQR Webhook:', [
            'headers' => $request->headers->all(),
            'body' => $request->all()
        ]);

        // Xác thực bảo mật Webhook từ VietQR
        if (!$this->verifyAuth($request)) {
            Log::warning('VietQR Webhook Unauthorized');
            return response()->json([
                'error' => true,
                'toastMessage' => 'Xác thực tài khoản VietQR thất bại'
            ], 401);
        }

        try {
            $data = $request->all();

            // Chuẩn hóa dữ liệu nếu VietQR bọc trong mảng 'data'
            if (isset($data['data'])) {
                $item = is_array($data['data']) && isset($data['data'][0]) ? $data['data'][0] : $data['data'];
            } else {
                $item = $data;
            }

            $amount = (float)($item['amount'] ?? 0);
            $content = $item['content'] ?? ($item['description'] ?? '');
            $orderId = $item['orderId'] ?? null;
            $transactionId = $item['transactionid'] ?? ($item['referenceCode'] ?? $item['id'] ?? ('TX' . time()));
            $transType = strtoupper($item['transType'] ?? ($item['type'] ?? 'C'));

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
                $previousPaid = $order->payments()->where('status', 1)->sum('amount');
                $isFullPayment = ($previousPaid + $amount) >= ($order->total_price - 1000);
                $newStatus = $isFullPayment ? 2 : 1;
                $order->update(['status' => $newStatus]);

                $paymentType = 'deposit';
                if ($isFullPayment) {
                    $paymentType = ($previousPaid > 0) ? 'final' : 'full';
                }

                $payment = Payment::create([
                    'order_id' => $order->id,
                    'amount' => $amount,
                    'payment_type' => $paymentType,
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
        $expectedPass = config('services.vietqr.password', env('VIETQR_PASSWORD'));

        $dummyRequest = new Request([
            'bankaccount' => config('services.vietqr.account_no', env('VIETQR_ACCOUNT_NO')),
            'amount' => $depositAmount,
            'transType' => 'C',
            'content' => "WANDERLUST DH{$order->id}",
            'transactionid' => 'VQR_TEST_' . time(),
            'transactiontime' => now()->timestamp * 1000,
            'orderId' => (string)$order->id,
            'password' => $expectedPass,
        ]);
        if ($expectedPass) {
            $dummyRequest->headers->set('Authorization', 'Basic ' . $expectedPass);
        }

        $this->handleTransactionSync($dummyRequest);

        return redirect()->route('tour.thankyou', $order->id)->with('success', 'Thanh toán cọc VietQR thành công! Tiền đã vào tài khoản và tour đã được kích hoạt.');
    }

    /**
     * Xác thực thông tin tài khoản hệ thống từ VietQR
     */
    private function verifyAuth(Request $request): bool
    {
        $expectedUser = config('services.vietqr.username', env('VIETQR_USERNAME'));
        $expectedPass = config('services.vietqr.password', env('VIETQR_PASSWORD'));

        // Chưa cấu hình xác thực thì bỏ qua
        if (!$expectedUser && !$expectedPass) {
            return true;
        }

        // 1. Chuẩn HTTP Basic Auth
        if ($request->getUser() === $expectedUser && $request->getPassword() === $expectedPass) {
            return true;
        }

        // 2. Kiểm tra Authorization header (Basic / Bearer)
        $authHeader = $request->header('Authorization', '');
        if ($authHeader) {
            $expectedBasic1 = 'Basic ' . base64_encode("{$expectedUser}:{$expectedPass}");
            $expectedBasic2 = 'Basic ' . $expectedPass;
            if (hash_equals($expectedBasic1, $authHeader) || hash_equals($expectedBasic2, $authHeader)) {
                return true;
            }
            if (str_contains($authHeader, (string)$expectedPass) || str_contains($authHeader, (string)$expectedUser)) {
                return true;
            }
        }

        // 3. Header X-API-KEY / api-key
        $apiKey = $request->header('X-API-KEY') ?: $request->header('api-key');
        if ($apiKey && ($apiKey === $expectedPass || $apiKey === $expectedUser)) {
            return true;
        }

        // 4. Kiểm tra trong params / body (nếu truyền qua form data)
        $inputPass = $request->input('password') ?: $request->input('token');
        $inputUser = $request->input('username');
        if (($inputUser === $expectedUser && $inputPass === $expectedPass) || $inputPass === $expectedPass) {
            return true;
        }

        return false;
    }
}
