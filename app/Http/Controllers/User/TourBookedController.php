<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Tour;
use Illuminate\Support\Facades\Auth;

class TourBookedController extends Controller
{
    public function myBookedTours()
    {
        // Nếu chưa đăng nhập
        if (! Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập để xem tour đã đặt.');
        }

        $user = Auth::user();

        // Lấy danh mục menu
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

        // lấy tất cả các đơn của user
        $orders = Order::with([
            'payments',
            'tour',
            'tour.schedules',
        ])
            ->where('user_id', $user->id)
            ->whereIn('status', [0, 1, 2, 3, 4])
            ->orderByDesc('id')
            ->get();

        // Thêm thông tin thanh toán cho mỗi order
        $orders->transform(function ($order) {

            $totalPaid = $order->payments
                ->where('status', 1)
                ->sum('amount');

            $depositPaid = $order->payments
                ->where('status', 1)
                ->where('payment_type', 'deposit')
                ->sum('amount');

            $finalPaid = $order->payments
                ->where('status', 1)
                ->where('payment_type', 'final')
                ->sum('amount');

            if ($totalPaid >= $order->total_price) {
                $paymentStatus = 'Đã thanh toán đủ';
            } elseif ($depositPaid > 0) {
                $paymentStatus = 'Đã đặt cọc';
            } else {
                $paymentStatus = 'Chưa thanh toán';
            }

            $order->paymentInfo = [
                'total_price' => $order->total_price,
                'total_paid' => $totalPaid,
                'deposit_paid' => $depositPaid,
                'final_paid' => $finalPaid,
                'payment_status' => $paymentStatus,
            ];

            return $order;
        });

        // tính tổng tất cả các đơn hàng trong giỏ hàng
        $total_price_all = $orders->sum(fn ($o) => $o->paymentInfo['total_price']);
        $total_paid_all = $orders->sum(fn ($o) => $o->paymentInfo['total_paid']);
        $total_remaining_all = $total_price_all - $total_paid_all;

        // Trả về view
        return view('users.tourBooked', [
            'categories' => $categories,
            'user' => $user,
            'orders' => $orders,
            'total_price_all' => $total_price_all,
            'total_paid_all' => $total_paid_all,
            'total_remaining_all' => $total_remaining_all,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    public function showSchedule($order_id)
    {
        // Lấy Order + Tour + Schedules
        $order = Order::with([
            'tour.images',
            'tour.attributes',
            'tour.schedules' => function ($q) {
                $q->orderBy('day_number', 'asc');
            },
        ])->findOrFail($order_id);

        $tour = $order->tour;

        return view('users.tourBooked', [
            'tour' => $tour,
            'schedules' => $tour->schedules,
            'mapUrl' => $tour->map_url ?? '',
            'directionsUrl' => $tour->directions_url ?? '',
        ]);
    }

    public function getScheduleData($order_id)
    {
        $order = Order::with([
            'tour.schedules' => function ($q) {
                $q->orderBy('day_number', 'asc');
            },
        ])->findOrFail($order_id);

        return response()->json([
            'tour' => $order->tour,
            'schedules' => $order->tour->schedules,
        ]);
    }
}
