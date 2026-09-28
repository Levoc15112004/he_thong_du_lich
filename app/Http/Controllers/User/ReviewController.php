<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create($orderId)
    {
        return redirect()->route('user.order.success', ['order_id' => $orderId]);
    }

    public function store(Request $request)
    {
        return back()->with('success', 'Cảm ơn bạn đã gửi đánh giá!');
    }
}
