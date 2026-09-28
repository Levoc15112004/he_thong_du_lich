<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        return redirect()->route('user.order.index');
    }

    public function thankYou($order_id)
    {
        return redirect()->route('user.order.success', ['order_id' => $order_id]);
    }

    public function thankYouFinal($order_id)
    {
        return redirect()->route('user.order.success', ['order_id' => $order_id]);
    }

    public function cancelOrder($order)
    {
        $o = Order::find($order);
        if ($o) {
            $o->update(['status' => 4]); // 4: Đã hủy
        }
        return back()->with('success', 'Đã hủy đơn hàng');
    }
}
