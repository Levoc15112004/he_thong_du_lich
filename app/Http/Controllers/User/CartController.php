<?php

namespace App\Http\Controllers\User;

use App\Helper\Cart;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Tour;
use App\Models\UserVoucher;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function Cart()
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



        $cart = new Cart;

        $totalPrice = $cart->getTotalPrice();
        $totalQuantity = $cart->getTotalQuantity();
        $discount = $cart->getDiscount();
        $finalTotal = $cart->getFinalPrice();

        $voucher = session('voucher');


        $userVouchers = UserVoucher::where('user_id', auth()->id())
            ->where('status', '0')
            ->with('voucher')
            ->get()
            ->pluck('voucher');

        return view('users.cart', compact(
            'categories',
            'cart',
            'totalPrice',
            'totalQuantity',
            'discount',
            'finalTotal',
            'voucher',
            'notifications',
            'unreadCount',
            'userVouchers'
        ));
    }


    public function add(Request $req)
    {
        $tour = Tour::find($req->id);

        $cart = new Cart;

        $cart->add(
            $tour,
            $req->quantity,
            $req->transport,
            $req->tour_type
        );

        return redirect()->route('user.cart');
    }


    public function update(Request $req)
    {
        $cart = new Cart;

        $cart->update(
            $req->id,
            $req->quantity
        );

        return redirect()->route('user.cart');
    }

    public function delete($id)
    {
        $cart = new Cart;

        $cart->delete($id);

        return redirect()->route('user.cart');
    }


    public function applyVoucher(Request $request)
    {
        $code = $request->voucher_code;

        if (! $code) {

            session()->forget('voucher');

            return back();
        }

        $voucher = Voucher::where('code', $code)->first();

        if (! $voucher) {

            return back()->with('error', 'Mã giảm giá không tồn tại');

        }

        $cart = new Cart;

        if (! $cart->canUseVoucher($voucher)) {

            return back()->with('error', 'Không đủ điều kiện sử dụng voucher');

        }

        $cart->applyVoucher($code); // đúng

        return back()->with('success', 'Áp dụng voucher thành công');
    }


    public function removeVoucher()
    {
        $cart = new Cart;

        $cart->removeVoucher();

        return back()->with('success', 'Đã xoá voucher');
    }
}