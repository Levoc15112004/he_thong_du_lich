<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Danh sách thanh toán
     */
    public function index()
    {
        $payments = Payment::with([
                'order.user',
                'order.tour'
            ])
            ->orderByDesc('created_at')
            ->paginate(6);

        return view('admin.payment.home', compact('payments'));
    }

    /**
     * Chi tiết thanh toán
     */
    public function show($id)
    {
        $payment = Payment::with([
                'order.user',
                'order.tour',
                'transactions'
            ])->findOrFail($id);

        return redirect()->route('admin.payment.home');
    }

    /**
     * Cập nhật trạng thái thanh toán
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1,2'
            // 0: chờ thanh toán
            // 1: thành công
            // 2: thất bại
        ]);

        $payment = Payment::findOrFail($id);
        $payment->status = $request->status;
        $payment->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái thanh toán thành công!');
    }

    /**
     * Xóa thanh toán
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()
            ->route('admin.payment.home')
            ->with('success', 'Đã xóa thanh toán!');
    }
}
