<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourBookedController extends Controller
{
    public function myBookedTours()
    {
        return redirect()->route('user.home');
    }

    public function showSchedule($order_id)
    {
        return redirect()->route('user.order.success', ['order_id' => $order_id]);
    }

    public function getScheduleData($order_id)
    {
        return response()->json(['status' => 'success', 'schedules' => []]);
    }
}
