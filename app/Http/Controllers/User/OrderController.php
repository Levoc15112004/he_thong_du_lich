<?php

namespace App\Http\Controllers\User;

use App\Helper\Cart;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Tour;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function order()
    {
        $cart = new Cart;
        $items = $cart->getItems();

        if (empty($items)) {
            return redirect()->route('user.cart')->with('error', 'Giỏ hàng của bạn đang trống! Vui lòng chọn tour trước.');
        }

        $firstItem = reset($items);
        $cartTour = Tour::with('category')->find($firstItem['tour_id']);

        if (!$cartTour) {
            $cart->clear();
            return redirect()->route('user.home')->with('error', 'Tour đã chọn không còn tồn tại.');
        }

        $totalPrice = $cart->getTotalPrice();
        $totalQuantity = $cart->getTotalQuantity();
        $discount = $cart->getDiscount();
        $finalTotal = $cart->getFinalPrice();
        $voucher = session('voucher');
        $user = Auth::user();

        $categories = Category::where('status', 1)
            ->whereNull('category_id')
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

        return view('user.order', compact(
            'cart',
            'cartTour',
            'firstItem',
            'totalPrice',
            'totalQuantity',
            'discount',
            'finalTotal',
            'voucher',
            'user',
            'categories',
            'notifications',
            'unreadCount'
        ));
    }

    public function addOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:1000',
            'payment_method' => 'required|string',
        ]);

        $cart = new Cart;
        $items = $cart->getItems();

        if (empty($items)) {
            return redirect()->route('user.cart')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $firstItem = reset($items);
        $tour = Tour::find($firstItem['tour_id']);

        if (!$tour) {
            $cart->clear();
            return redirect()->route('user.home')->with('error', 'Tour này hiện không tồn tại.');
        }

        DB::beginTransaction();
        try {
            $voucher = session('voucher');
            $voucherId = is_array($voucher) ? ($voucher['id'] ?? null) : ($voucher->id ?? null);

            $order = Order::create([
                'tour_id' => $tour->id,
                'user_id' => Auth::id(),
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'note' => $request->note,
                'total_price' => $cart->getFinalPrice(),
                'voucher_id' => $voucherId,
                'discount_amount' => $cart->getDiscount(),
                'status' => 0, // 0: Chờ xác nhận
                'time' => $tour->time ?? 'Theo lịch trình',
                'quantity' => $cart->getTotalQuantity(),
            ]);

            Payment::create([
                'order_id' => $order->id,
                'amount' => $cart->getFinalPrice(),
                'payment_type' => 'full',
                'payment_method' => $request->payment_method ?? 'direct',
                'status' => ($request->payment_method === 'direct' ? 0 : 1),
                'payment_date' => now(),
            ]);

            $cart->clear();

            DB::commit();

            return redirect()->route('user.order.success', ['order_id' => $order->id])
                ->with('success', 'Đặt tour thành công! Cảm ơn quý khách.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }

    public function orderSuccess($order_id)
    {
        $order = Order::with(['tour.category', 'payments', 'voucher'])->findOrFail($order_id);

        $categories = Category::where('status', 1)
            ->whereNull('category_id')
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

        return view('user.order_success', compact(
            'order',
            'categories',
            'notifications',
            'unreadCount'
        ));
    }
}
