<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function showDepositPage($order_id)
    {
        return redirect()->route('user.order.success', ['order_id' => $order_id]);
    }

    public function processPayment(Request $request)
    {
        return back()->with('success', 'Thanh toán thành công');
    }

    public function showFinalPaymentPage($order_id)
    {
        return redirect()->route('user.order.success', ['order_id' => $order_id]);
    }
}
