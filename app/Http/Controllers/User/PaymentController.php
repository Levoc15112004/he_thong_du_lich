<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        // Lấy dữ liệu đầu vào
        $user = User::find(Auth::id());
        $payment = $request->payment_method;
        $tourId = $request->tour_id;
        $orderId = $request->order_id;

        // Kiểm tra order_id hợp lệ
        if (! $orderId) {
            return back()->with('error', 'Không tìm thấy đơn hàng (order_id).');
        }

        // Lấy số tiền cọc 30%
        $depositAmount = $request->deposit_amount;

        if (! $depositAmount || $depositAmount <= 0) {
            return back()->with('error', 'Số tiền cọc không hợp lệ.');
        }

        // thanh toán paypal
        if ($payment === 'PayPal') {

            return redirect()->route('paypal.deposit.create', [
                'order_id' => $orderId,
                'deposit' => $depositAmount,
                'tour_id' => $tourId,
            ]);
        }

        // thanh toán momo/vnpay
        if (in_array($payment, ['Momo', 'VNPay', 'Visa'])) {

            return redirect()->route('user.tour.deposit.qr', [
                'method' => $payment,
                'deposit' => $depositAmount,
                'tour_id' => $tourId,
                'order_id' => $orderId,
            ]);
        }

        // Thanh toán tại quầy
        if ($payment === 'Cash') {

            session()->flash('booking', [
                'deposit' => $depositAmount,
                'quantity' => $request->quantity,
                'start_date' => $request->start_date,
                'code' => 'TG'.rand(100000, 999999),
            ]);

            return redirect()->route('tour.thankyou', [
                'order_id' => $orderId,
                'user_id' => $user->id,

            ])->with('success', 'Bạn đã thanh toán tiền cọc thành công!');
        }

        return back()->with('error', 'Phương thức thanh toán không hợp lệ');
    }

    public function thankYou($order_id)
    {
        $categories = Category::where('status', 1)
            ->whereNull('parent_id')
            ->with('children')
            ->orderByDesc('id')
            ->take(10)
            ->get();

        $notifications = Notification::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('status', 'unread')
            ->count();

        $order = Order::find($order_id);

        if (! $order) {
            return back()->with('error', 'Không tìm thấy đơn hàng.');
        }

        $tour = Tour::find($order->tour_id);

        if (! $tour) {
            return back()->with('error', 'Không tìm thấy tour.');
        }

        $booking = session('booking');

        return view('users.thankyou', compact('categories', 'tour', 'booking', 'order', 'notifications', 'unreadCount'));
    }

    public function thankYouFinal($order_id)
    {
        // Menu
        $categories = Category::where('status', 1)
            ->whereNull('parent_id')
            ->with('children')
            ->orderByDesc('id')
            ->take(10)
            ->get();

        // Notifications
        $notifications = Notification::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('status', 'unread')
            ->count();

        $order = Order::with(['tour', 'user'])->find($order_id);

        if (! $order) {
            return redirect()->route('user.order.index')
                ->with('error', 'Không tìm thấy đơn hàng.');
        }

        if ($order->status != 2) {
            return redirect()->route('user.order.index')
                ->with('error', 'Thanh toán chưa hoàn tất.');
        }

        // Gửi email hóa đơn
        try {
            Mail::send('users.email.invoice', [
                'order' => $order,
                'tour' => $order->tour,
                'user' => $order->user,
            ], function ($message) use ($order) {
                $message->to($order->user->email)
                    ->subject('Hóa đơn thanh toán tour #'.$order->id);
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Lỗi gửi email: ' . $e->getMessage());
        }

        return view('users.thankYoufinally', [
            'categories' => $categories,
            'order' => $order,
            'tour' => $order->tour,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    public function cancelOrder(Request $request, $order_id)
    {
        //  Tìm order của user
        $order = Order::where('id', $order_id)
            ->where('user_id', Auth::id())
            ->first();

        if (! $order) {
            return back()->with('error', 'Không tìm thấy đơn hàng.');
        }

        //  Không cho hủy nếu đã hoàn thành
        if ($order->status == 3) {
            return back()->with('error', 'Tour đã hoàn thành, không thể hủy.');
        }

        //  Lấy các payment đã thanh toán
        $payments = Payment::where('order_id', $order->id)
            ->where('status', 1)
            ->get();

        //  Chưa thanh toán → chỉ hủy order
        if ($payments->isEmpty()) {
            $order->update(['status' => 4]);

            return back()->with('success', 'Đã hủy tour thành công.');
        }

        //  Có thanh toán → hoàn tiền
        $paypalController = app(PayPalController::class);

        foreach ($payments as $payment) {

            //  CHỈ xử lý PayPal
            if ($payment->payment_method !== 'PayPal') {
                continue;
            }

            try {
                //  Khởi tạo refund
                $paypalController->createRefund(
                    new Request,
                    $payment->id
                );

                //  Capture refund
                $paypalController->captureRefund(
                    new Request(['payment_id' => $payment->id])
                );

            } catch (\Throwable $e) {
                return back()->with(
                    'error',
                    'Hoàn tiền PayPal thất bại. Vui lòng liên hệ hỗ trợ.'
                );
            }
        }

        //  Update order → đã hoàn tiền
        $order->update(['status' => 5]); // refunded

        return back()->with('success', 'Tour đã được hủy và hoàn tiền thành công.');
    }
}