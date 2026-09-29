<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserVoucher;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $userVouchers = UserVoucher::with(['user', 'voucher'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('voucher', function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                });
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                if ($status === 'used') {
                    $query->where('status', 1);
                } elseif ($status === 'unused') {
                    $query->where('status', 0);
                } elseif ($status === 'expired') {
                    $query->whereHas('voucher', function ($q) {
                        $q->whereNotNull('end_date')
                            ->where('end_date', '<', now());
                    });
                } elseif ($status === 'active') {
                    $query->where('status', 0)
                        ->whereHas('voucher', function ($q) {
                            $q->where(function ($sub) {
                                $sub->whereNull('end_date')
                                    ->orWhere('end_date', '>=', now());
                            })->where('status', 1);
                        });
                }
            })
            ->latest()
            ->paginate(3)
            ->withQueryString();

        $users = User::select('id', 'name', 'email')->orderBy('name')->get();

        $availableVouchers = Voucher::where('status', 1)
            ->where('quantity', '>', DB::raw('used_count'))
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->latest()
            ->get();

        $stats = [
            'users_have_voucher' => UserVoucher::distinct('user_id')->count('user_id'),
            'total_assigned' => UserVoucher::count(),
            'assigned_today' => UserVoucher::whereDate('created_at', today())->count(),
        ];

        $summerVouchers = Voucher::latest()->get();

        return view('admins.UserVoucher.index', compact(
            'userVouchers',
            'users',
            'availableVouchers',
            'stats',
            'search',
            'status',
            'summerVouchers'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select('id', 'name', 'email')->get();

        $vouchers = Voucher::where('status', 1)
            ->whereColumn('used_count', '<', 'quantity')
            ->get();

        return view('admins.UserVoucher.create', compact('users', 'vouchers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'voucher_ids' => ['required', 'array', 'min:1'],
            'voucher_ids.*' => ['exists:vouchers,id'],
        ], [
            'user_id.required' => 'Vui lòng chọn người dùng.',
            'user_id.exists' => 'Người dùng không tồn tại.',
            'voucher_ids.required' => 'Vui lòng chọn ít nhất 1 voucher.',
            'voucher_ids.min' => 'Vui lòng chọn ít nhất 1 voucher.',
        ]);

        DB::beginTransaction();

        try {
            $assignedCount = 0;

            foreach ($request->voucher_ids as $voucherId) {
                $voucher = Voucher::lockForUpdate()->findOrFail($voucherId);

                if (! $voucher->status) {
                    continue;
                }

                if ($voucher->end_date && Carbon::parse($voucher->end_date)->isPast()) {
                    continue;
                }

                if ($voucher->start_date && Carbon::parse($voucher->start_date)->isFuture()) {
                    continue;
                }

                if ($voucher->used_count >= $voucher->quantity) {
                    continue;
                }

                $exists = UserVoucher::where('user_id', $request->user_id)
                    ->where('voucher_id', $voucher->id)
                    ->where('status', 0)
                    ->exists();

                if ($exists) {
                    continue;
                }

                UserVoucher::create([
                    'user_id' => $request->user_id,
                    'voucher_id' => $voucher->id,
                    'status' => 0,
                    'used_at' => null,
                ]);

                $assignedCount++;
            }

            DB::commit();

            if ($assignedCount === 0) {
                return redirect()
                    ->route('admin.user_vouchers.index')
                    ->with('error', 'Không có voucher nào được gán. Có thể voucher đã tồn tại, hết hạn hoặc hết số lượng.');
            }

            return redirect()
                ->route('admin.user_vouchers.index')
                ->with('success', "Đã gán thành công {$assignedCount} voucher cho người dùng.");
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()
                ->route('admin.user_vouchers.index')
                ->with('error', 'Có lỗi xảy ra khi gán voucher: '.$th->getMessage());
        }
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
        $userVoucher = UserVoucher::findOrFail($id);

        $users = User::select('id', 'name')->get();

        $vouchers = Voucher::all();

        return view('admins.UserVoucher.edit',
            compact('userVoucher', 'users', 'vouchers')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userVoucher = UserVoucher::findOrFail($id);

        $request->validate([
            'status' => 'required',
        ]);

        $data = [
            'status' => $request->status,
        ];

        if ($request->status == 1) {
            $data['used_at'] = now();
        }

        $userVoucher->update($data);

        return redirect()->route('admin.user_vouchers.index')
            ->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userVoucher = UserVoucher::findOrFail($id);
        $userVoucher->delete();

        return redirect()
            ->route('admin.user_vouchers.index')
            ->with('success', 'Đã xóa voucher khỏi người dùng.');
    }

    public function assignRandomUsers(Request $request)
    {
        $request->validate([
            'voucher_id' => ['required', 'exists:vouchers,id'],
            'total_users' => ['required', 'integer', 'min:1'],
        ], [
            'voucher_id.required' => 'Vui lòng chọn voucher.',
            'voucher_id.exists' => 'Voucher không tồn tại.',
            'total_users.required' => 'Vui lòng nhập số lượng người dùng cần phát.',
            'total_users.integer' => 'Số lượng người dùng phải là số nguyên.',
            'total_users.min' => 'Số lượng người dùng phải lớn hơn 0.',
        ]);

        DB::beginTransaction();

        try {
            $voucher = Voucher::lockForUpdate()->findOrFail($request->voucher_id);

            if (! $voucher->status) {
                DB::rollBack();

                return redirect()
                    ->route('admin.user_vouchers.index')
                    ->with('error', 'Voucher hiện không hoạt động.');
            }

            if ($voucher->start_date && Carbon::parse($voucher->start_date)->isFuture()) {
                DB::rollBack();

                return redirect()
                    ->route('admin.user_vouchers.index')
                    ->with('error', 'Voucher chưa đến thời gian áp dụng.');
            }

            if ($voucher->end_date && Carbon::parse($voucher->end_date)->isPast()) {
                DB::rollBack();

                return redirect()
                    ->route('admin.user_vouchers.index')
                    ->with('error', 'Voucher đã hết hạn.');
            }

            $remaining = $voucher->quantity - $voucher->used_count;

            if ($remaining <= 0) {
                DB::rollBack();

                return redirect()
                    ->route('admin.user_vouchers.index')
                    ->with('error', 'Voucher đã hết số lượng để phát.');
            }

            $take = min((int) $request->total_users, $remaining);

            $userIds = User::whereNotIn('id', function ($query) use ($voucher) {
                $query->select('user_id')
                    ->from('user_vouchers')
                    ->where('voucher_id', $voucher->id);
            })
                ->inRandomOrder()
                ->limit($take)
                ->pluck('id');

            if ($userIds->isEmpty()) {
                DB::rollBack();

                return redirect()
                    ->route('admin.user_vouchers.index')
                    ->with('error', 'Không còn user phù hợp để phát voucher này.');
            }

            $insertData = [];

            foreach ($userIds as $userId) {
                $insertData[] = [
                    'user_id' => $userId,
                    'voucher_id' => $voucher->id,
                    'status' => 0,
                    'used_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            UserVoucher::insert($insertData);

            $assignedCount = count($insertData);

            $voucher->increment('used_count', $assignedCount);
            $voucher->refresh();

            if ($voucher->used_count >= $voucher->quantity) {
                $voucher->update([
                    'status' => 0,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.user_vouchers.index')
                ->with('success', "Đã phát voucher [{$voucher->code}] cho {$assignedCount} người dùng ngẫu nhiên.");
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()
                ->route('admin.user_vouchers.index')
                ->with('error', 'Có lỗi xảy ra khi phát voucher ngẫu nhiên: '.$th->getMessage());
        }
    }
}
