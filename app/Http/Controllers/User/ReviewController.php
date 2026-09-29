<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Review;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Hiển thị form đánh giá dựa trên order
    public function create($orderId)
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
        $userId = auth()->id();

        // Lấy order và kiểm tra quyền đánh giá
        $order = Order::with('tour')
            ->where('id', $orderId)
            ->where('user_id', $userId)
            ->where('status', 2)
            ->first();

        if (! $order) {
            return back()->with('error', 'Bạn phải thanh toán đơn hàng để đánh giá');
        }

        // Kiểm tra xem order này đã được đánh giá chưa
        $reviewed = Review::where('user_id', $userId)
            ->where('order_id', $order->id)
            ->exists();

        if ($reviewed) {
            return back()->with('error', 'Bạn đã đánh giá đơn hàng này rồi');
        }

        // Lấy tour từ order để hiển thị thông tin
        $tour = $order->tour;

        return view('users.review.create', compact('tour', 'categories', 'order', 'notifications', 'unreadCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
        ]);

        $userId = auth()->id();

        $order = Order::where('id', $request->order_id)
            ->where('user_id', $userId)
            ->where('status', 2)
            ->first();

        if (! $order) {
            return back()->with('error', 'Đơn hàng không hợp lệ hoặc chưa thanh toán');
        }

        // Kiểm tra đã đánh giá chưa
        $reviewed = Review::where('user_id', $userId)
            ->where('order_id', $order->id)
            ->exists();

        if ($reviewed) {
            return back()->with('error', 'Bạn đã đánh giá đơn hàng này rồi');
        }

        // Lưu review
        Review::create([
            'user_id' => $userId,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()
            ->route('user.tourDetail.index', $order->tour_id)
            ->with('success', 'Cảm ơn bạn đã đánh giá tour!');
    }
}
