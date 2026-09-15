<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        Voucher::where('status', 1)
            ->whereNotNull('end_date')
            ->where('end_date', '<', now())
            ->update([
                'status' => 0,
            ]);

        Voucher::where('status', 1)
            ->where('quantity', '>', 0)
            ->whereColumn('used_count', '=', 'quantity')
            ->update([
                'status' => 0,
            ]);

        $totalVouchers = Voucher::count();
        $activeVouchers = Voucher::where('status', 1)->count();
        $inactiveVouchers = Voucher::where('status', 0)->count();

        $expiringSoon = Voucher::whereNotNull('end_date')
            ->where('end_date', '>=', now())
            ->where('end_date', '<=', now()->addDays(7))
            ->count();

        $vouchers = Voucher::latest()->paginate(7);

        return view('admin.voucher.home', compact(
            'vouchers',
            'totalVouchers',
            'activeVouchers',
            'inactiveVouchers',
            'expiringSoon'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.voucher.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:vouchers,code',
            'name' => 'required',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'start_date' => 'nullable|date',
            'status' => 'required|in:0,1',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'event_type' => 'nullable|string',
        ]);

        Voucher::create($request->all());

        return redirect()->route('admin.voucher.home')->with('success', 'Voucher đã được tạo thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);

        return view('admin.voucher.update', compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'code' => 'required|unique:vouchers,code,'.$voucher->id,
            'name' => 'required',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'start_date' => 'nullable|date',
            'status' => 'required|in:0,1',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'event_type' => 'nullable|string',

        ]);

        $voucher->update([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'max_discount' => $request->max_discount,
            'min_order_value' => $request->min_order_value,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'event_type' => $request->event_type,
        ]);

        return redirect()->route('admin.voucher.home')->with('success', 'Voucher được câp nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('admin.voucher.home')->with('success', 'Voucher deleted successfully.');
    }
}
