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
    public function Cart(Request $request)
    {
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

        $cart = new Cart;

        if ($request->filled('tour_id')) {
            $tour = Tour::find($request->tour_id);
            if ($tour) {
                $qty = max(1, (int)$request->get('qty', 1));
                $cart->add(
                    $tour,
                    $qty,
                    $request->get('transport', 'Xe du lịch'),
                    $request->get('tour_type', 'Tiêu chuẩn')
                );
            }
        }

        $items = $cart->getItems();
        $firstItem = !empty($items) ? reset($items) : null;
        $cartTour = $firstItem ? Tour::with('category')->find($firstItem['tour_id']) : null;
        $qty = $firstItem ? ($firstItem['quantity'] ?? 1) : 1;

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

        return view('user.cart', compact(
            'categories',
            'cart',
            'cartTour',
            'qty',
            'items',
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

        if ($tour) {
            $cart->add(
                $tour,
                $req->quantity ?? 1,
                $req->transport ?? 'Xe du lịch',
                $req->tour_type ?? 'Tiêu chuẩn'
            );
        }

        return redirect()->route('user.cart');
    }


    public function update(Request $req)
    {
        $cart = new Cart;

        $cart->update(
            $req->id,
            $req->quantity
        );

        if ($req->ajax() || $req->wantsJson()) {
            return response()->json([
                'success' => true,
                'totalPrice' => $cart->getTotalPrice(),
                'totalQuantity' => $cart->getTotalQuantity(),
                'discount' => $cart->getDiscount(),
                'finalTotal' => $cart->getFinalPrice(),
            ]);
        }

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
        $code = trim((string)$request->voucher_code);

        if (! $code) {
            session()->forget('voucher');
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Vui lòng nhập mã giảm giá']);
            }
            return back();
        }

        $voucher = Voucher::where('code', $code)->first();

        if (! $voucher) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Mã giảm giá không tồn tại']);
            }
            return back()->with('error', 'Mã giảm giá không tồn tại');
        }

        $cart = new Cart;

        if (! $cart->canUseVoucher($voucher)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Không đủ điều kiện sử dụng voucher']);
            }
            return back()->with('error', 'Không đủ điều kiện sử dụng voucher');
        }

        $cart->applyVoucher($code);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Áp dụng voucher thành công',
                'discount' => $cart->getDiscount(),
                'finalTotal' => $cart->getFinalPrice(),
            ]);
        }

        return back()->with('success', 'Áp dụng voucher thành công');
    }


    public function removeVoucher()
    {
        $cart = new Cart;

        $cart->removeVoucher();

        return back()->with('success', 'Đã xoá voucher');
    }
}
