<?php

namespace App\Http\Controllers\User;

use App\Helper\Cart;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use App\Models\UserVoucher;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function order()
    {
        $cart = new Cart;

        // ===== cart =====
        $totalPrice = $cart->getTotalPrice();
        $totalQuantity = $cart->getTotalQuantity();

        // thêm để dùng voucher
        $discount = $cart->getDiscount();
        $finalTotal = $cart->getFinalPrice();
        $voucher = session('voucher');

        // ===== category =====
        $categories = Category::where('status', 1)
            ->whereNull('parent_id')
            ->with('children')
            ->orderByDesc('id')
            ->take(10)
            ->get();

        // ===== notification =====
        $notifications = Notification::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('status', 'unread')
            ->count();

        // ===== user =====
        $user = User::findOrFail(Auth::user()->id);

        return view('users.order', compact(
            'cart',
            'totalPrice',
            'totalQuantity',
            'discount',
            'finalTotal',
            'voucher',
            'categories',
            'user',
            'notifications',
            'unreadCount'
        ));
    }

    public function addOrder(Request $req)
    {
        $cart = new Cart;
        $items = $cart->getItems();

        if (! $items || count($items) == 0) {
            return redirect()->back()->with('error', 'Giỏ hàng đang trống!');
        }

        $totalPrice = $cart->getTotalPrice();
        $totalQuantity = $cart->getTotalQuantity();
        $discount = $cart->getDiscount();
        $finalPrice = $cart->getFinalPrice();

        $voucher = session('voucher');

        $firstItem = reset($items);

        $tourId = $firstItem['tour_id'] ?? null;
        $time = $firstItem['time'] ?? null;
        $qtyForOrder = (int) ($firstItem['quantity'] ?? $totalQuantity);

        if (! $tourId) {
            return redirect()->back()->with('error', 'Không tìm thấy tour_id trong giỏ hàng.');
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'name' => $req->name,
            'phone' => $req->phone,
            'email' => $req->email,
            'address' => $req->address,
            'note' => $req->note,

            'total_price' => $finalPrice, // giá sau giảm
            'discount_amount' => $discount,

            'voucher_id' => $voucher->id ?? null,

            'quantity' => $qtyForOrder,
            'tour_id' => $tourId,
            'time' => $time,
            'status' => 0,
        ]);

         if ($order) {
            // Nếu có voucher thì cập nhật trạng thái user_vouchers = 2
            if ($voucher && isset($voucher['id'])) {
                $userVoucher = UserVoucher::where('user_id', auth()->id())
                    ->where('voucher_id', $voucher['id'])
                    ->where('status', 0)
                    ->latest()
                    ->first();

                if ($userVoucher) {
                    $userVoucher->update([
                        'status' => 2
                    ]);
                }
            }
         }

        if ($order) {

            // xóa cart sau khi đặt hàng
            $cart->clear();

            return redirect()->route('user.tour.deposit', ['order_id' => $order->id]);
        }

        return redirect()->back()->with('error', 'Không thể tạo đơn hàng!');
    }
}
