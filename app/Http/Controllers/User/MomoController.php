<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MomoController extends Controller
{
    public function createDeposit($order)
    {
        return redirect()->route('user.order.success', ['order_id' => $order]);
    }

    public function createFinal($order)
    {
        return redirect()->route('user.order.success', ['order_id' => $order]);
    }

    public function ipn(Request $request)
    {
        return response()->json(['resultCode' => 0, 'message' => 'Success']);
    }

    public function return(Request $request)
    {
        return redirect()->route('user.home');
    }
}
