@extends('admins.master')

@section('home')
    <style>
        .gradient-primary {
            background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
        }
    </style>

<div class="min-h-screen bg-slate-50/50 py-4 sm:py-8">
    <div class="max-w-[120rem] mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-xl sm:text-3xl font-bold text-slate-900  ">Quản lý Voucher</h1>
                <p class="mt-1 text-sm text-slate-500 font-medium">Hệ thống khuyến mãi và mã giảm giá Travel Go.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.vouchers.create') }}"
                   class="flex items-center justify-center gap-2 px-6 py-3 bg-emerald-600 text-white font-medium rounded-2xl shadow-xl shadow-emerald-100 hover:bg-emerald-700 transition-all active:scale-95 group">
                    <i class="fa-solid fa-plus text-sm group-hover:rotate-90 transition-transform duration-300"></i>
                    <span class="text-sm font-medium ">Thêm voucher mới</span>
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-ticket"></i>
                </div>
                <div>
                    <p class="text-slate-400 text-sm font-bold  ">Tổng Voucher</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $totalVouchers }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <p class="text-slate-400 text-sm font-bold  ">Đang hoạt động</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $activeVouchers }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5">
                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
                <div>
                    <p class="text-slate-400 text-sm font-bold  ">Sắp hết hạn</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $expiringSoon }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-3xl overflow-hidden">
            <!-- Desktop Table View (Hidden on Mobile) -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-bold text-slate-700  ">Voucher</th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-bold text-slate-700  ">Giảm giá</th>
                            <th scope="col" class="px-6 py-4 text-center text-sm font-bold text-slate-700  ">Lượt dùng</th>
                            <th scope="col" class="px-6 py-4 text-center text-sm font-bold text-slate-700  ">Thời gian</th>
                            <th scope="col" class="px-6 py-4 text-center text-sm font-bold text-slate-700  ">Trạng thái</th>
                            <th scope="col" class="px-6 py-4 text-right text-sm font-bold text-slate-700  ">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-50">
                        @foreach ($vouchers as $voucher)
                            @php
                                $percent = $voucher->quantity > 0 ? ($voucher->used_count / $voucher->quantity) * 100 : 0;
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm  shadow-inner">
                                            {{ strtoupper(substr($voucher->code, 0, 3)) }}
                                        </div>
                                        <div>
                                            <div class="text-base font-medium text-slate-900 ">{{ $voucher->code }}</div>
                                            <div class="text-xs text-slate-400 font-medium">{{ $voucher->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-900">
                                        {{ $voucher->discount_type == 'percent' ? $voucher->discount_value . '%' : number_format($voucher->discount_value) . '₫' }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-bold  ">
                                        {{ $voucher->min_order_value ? 'Đơn từ ' . number_format($voucher->min_order_value) . '₫' : 'Mọi đơn hàng' }}
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="w-32 mx-auto">
                                        <div class="flex justify-between text-[10px] font-bold mb-1.5 ">
                                            <span class="text-blue-600">{{ $voucher->used_count }}/{{ $voucher->quantity }}</span>
                                            <span class="text-slate-400">{{ round($percent) }}%</span>
                                        </div>
                                        <div class="w-full bg-slate-50 h-1.5 rounded-full overflow-hidden shadow-inner">
                                            <div class="bg-blue-500 h-full rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    <div class="text-[11px] font-bold text-slate-700">{{ $voucher->start_date?->format('d/m/Y') }}</div>
                                    <div class="text-[10px] text-slate-400 font-medium">đến {{ $voucher->end_date?->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center text-sm font-medium">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold
                                        {{ $voucher->status == 1 ? 'bg-green-50 text-green-700 border border-green-100' : ($voucher->status == 0 ? 'bg-slate-50 text-slate-400 border border-slate-200' : 'bg-amber-50 text-amber-700 border border-amber-100') }}">
                                        {{ $voucher->status == 1 ? 'Hoạt động' : ($voucher->status == 0 ? 'Đã dừng' : 'Chờ duyệt') }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa Voucher?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View (Shown on Mobile) -->
            <div class="lg:hidden divide-y divide-slate-100 bg-white">
                @foreach ($vouchers as $voucher)
                    @php
                        $percent = $voucher->quantity > 0 ? ($voucher->used_count / $voucher->quantity) * 100 : 0;
                    @endphp
                    <div class="p-5 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm shadow-inner">
                                    {{ strtoupper(substr($voucher->code, 0, 3)) }}
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-slate-900 er  leading-tight">{{ $voucher->code }}</h3>
                                    <span class="text-[10px] font-bold
                                        {{ $voucher->status == 1 ? 'text-green-600' : 'text-slate-400' }}">
                                        {{ $voucher->status == 1 ? 'Active' : 'Stopped' }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="p-2 text-blue-600 bg-blue-50 rounded-xl active:scale-90 transition-transform">
                                    <i class="fa-solid fa-edit text-sm"></i>
                                </a>
                                <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 bg-red-50 rounded-xl active:scale-90 transition-transform">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-slate-50/80 p-3 rounded-2xl border border-slate-100">
                                <p class="text-[9px] font-bold text-slate-400   mb-1">Giảm giá</p>
                                <p class="text-sm font-bold text-slate-900">
                                    {{ $voucher->discount_type == 'percent' ? $voucher->discount_value . '%' : number_format($voucher->discount_value) . '₫' }}
                                </p>
                            </div>
                            <div class="bg-slate-50/80 p-3 rounded-2xl border border-slate-100">
                                <p class="text-[9px] font-bold text-slate-400   mb-1">Thời hạn</p>
                                <p class="text-[11px] font-bold text-slate-700 leading-tight">
                                    {{ $voucher->end_date?->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <div class="flex justify-between text-[10px] font-bold ">
                                <span class="text-blue-600">Sử dụng: {{ $voucher->used_count }}/{{ $voucher->quantity }}</span>
                                <span class="text-slate-400">{{ round($percent) }}%</span>
                            </div>
                            <div class="w-full bg-slate-50 h-2 rounded-full overflow-hidden shadow-inner">
                                <div class="bg-blue-500 h-full rounded-full" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

    </main>
@endsection

