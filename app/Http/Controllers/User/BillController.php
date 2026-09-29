<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;

class BillController extends Controller
{
    public function export($orderId)
    {
        // Lấy order + tour + user
        $order = Order::with(['tour', 'user'])->findOrFail($orderId);

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('users.export.pdf', [
                'order' => $order,
                'tour'  => $order->tour,
                'user'  => $order->user,
            ])->setPaper('a4');

            return $pdf->download('hoa_don_' . $order->id . '.pdf');
        }

        return view('users.export.pdf', [
            'order' => $order,
            'tour'  => $order->tour,
            'user'  => $order->user,
        ]);
    }
}
