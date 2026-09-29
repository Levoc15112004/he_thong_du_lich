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

class BookingController extends Controller
{
    public function showDepositPage($order_id)
    {
        $user = User::findOrFail(Auth::user()->id);

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

        // Lấy order
        $order = Order::find($order_id);

        if (! $order) {
            return back()->with('error', 'Không tìm thấy đơn hàng.');
        }

        // Lấy tour từ order
        $tour = Tour::find($order->tour_id);

        if (! $tour) {
            return back()->with('error', 'Tour không tồn tại.');
        }

        // Thông tin khách hàng
        $customer = [
            'name' => $order->name,
            'email' => $order->email,
            'phone' => $order->phone,
            'address' => $order->address,
            'note' => $order->note,
            'time' => $order->time,
            'quantity' => $order->quantity,
        ];

        // Tính toán tiền
        $total_price = $order->total_price;
        $deposit_amount = $total_price * 0.30;

        // Các biến đang dùng trong Blade
        $quantity = $order->quantity;
        $startDate = $order->start_date;

        return view('users.desposit', compact(
            'tour',
            'customer',
            'total_price',
            'deposit_amount',
            'categories',
            'order',
            'quantity',
            'startDate',
            'user',
            'notifications',
            'unreadCount'
        ));
    }

    public function showFinalPaymentPage($order_id)
    {
        // Lấy user
        $user = User::findOrFail(Auth::id());

        // Lấy categories
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

        // Lấy Order
        $order = Order::find($order_id);
        if (! $order) {
            return back()->with('error', 'Không tìm thấy đơn hàng.');
        }

        // Lấy tour
        $tour = Tour::find($order->tour_id);
        if (! $tour) {
            return back()->with('error', 'Tour không tồn tại.');
        }

        // Lấy payment 30% (đã thanh toán)
        $depositPayment = Payment::where('order_id', $order->id)
            ->where('payment_type', 'deposit')
            ->where('status', 1)
            ->latest()
            ->first();

        if (! $depositPayment && $order->status != 1) {
            return back()->with('error', 'Bạn chưa thanh toán tiền cọc 30%.');
        }

        // Tính toán tiền
        $total_price = $order->total_price;
        // Cọc đã thu
        $deposit_amount = $depositPayment ? $depositPayment->amount : ($total_price * 0.3);
        // 70% còn lại
        $remain_amount = $total_price - $deposit_amount;

        if ($remain_amount <= 0) {
            return back()->with('error', 'Đơn hàng đã thanh toán đầy đủ.');
        }

        // Thông tin khách hàng
        $customer = [
            'name' => $order->name,
            'email' => $order->email,
            'phone' => $order->phone,
            'address' => $order->address,
            'note' => $order->note,
            'time' => $order->time,
            'quantity' => $order->quantity,
        ];

        return view('users.payment_finally', compact(
            'tour',
            'customer',
            'total_price',
            'deposit_amount',
            'remain_amount',
            'categories',
            'order',
            'user',
            'notifications',
            'unreadCount'
        ));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
            'tour_id' => 'required|exists:tours,id',
        ]);

        return back()->with('success', 'Phương thức thanh toán: '.$request->payment_method);
    }
}
