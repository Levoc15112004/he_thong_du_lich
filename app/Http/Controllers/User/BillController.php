<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function export($order_id)
    {
        return redirect()->route('user.order.success', ['order_id' => $order_id]);
    }
}
