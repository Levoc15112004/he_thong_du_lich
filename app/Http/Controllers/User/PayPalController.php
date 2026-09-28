<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayPalController extends Controller
{
    public function createPayment($order_id)
    {
        return response()->json(['id' => 'PAYPAL-MOCK-ID']);
    }

    public function capture(Request $request)
    {
        return response()->json(['status' => 'COMPLETED']);
    }

    public function createFinalPayment($order_id)
    {
        return response()->json(['id' => 'PAYPAL-MOCK-ID-FINAL']);
    }

    public function captureFinal(Request $request)
    {
        return response()->json(['status' => 'COMPLETED']);
    }
}
