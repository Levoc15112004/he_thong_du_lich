@extends('admins.master')

@section('title', 'Chi tiết Đơn hàng #' . $order->id)

@section('home')
<div class="min-h-screen bg-transparent dark:bg-transparent px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-6xl mx-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-2 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-[#863c20] flex items-center justify-center text-white shadow-md shadow-xs shrink-0">
                    <i class="fa-solid fa-file-invoice text-2xl"></i>
                </div>
                <div>
                    <div class="flex items-center gap-3">
                        <h4 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-white">
                            Đơn đặt Tour #{{ $order->id }}
                        </h4>
                        @php
                            $statusConfig = [
                                0 => ['bg' => 'bg-amber-50 dark:bg-amber-950/60', 'text' => 'text-amber-800 dark:text-amber-300', 'border' => 'border-amber-200 dark:border-amber-800', 'label' => 'Chờ xử lý / Chưa cọc'],
                                1 => ['bg' => 'bg-blue-50 dark:bg-blue-950/60', 'text' => 'text-blue-800 dark:text-blue-300', 'border' => 'border-blue-200 dark:border-blue-800', 'label' => 'Đã cọc 30%'],
                                2 => ['bg' => 'bg-indigo-50 dark:bg-indigo-950/60', 'text' => 'text-indigo-800 dark:text-indigo-300', 'border' => 'border-indigo-200 dark:border-indigo-800', 'label' => 'Đã thanh toán 100%'],
                                3 => ['bg' => 'bg-emerald-50 dark:bg-emerald-950/60', 'text' => 'text-emerald-800 dark:text-emerald-300', 'border' => 'border-emerald-200 dark:border-emerald-800', 'label' => 'Hoàn thành'],
                                4 => ['bg' => 'bg-rose-50 dark:bg-rose-950/60', 'text' => 'text-rose-800 dark:text-rose-300', 'border' => 'border-rose-200 dark:border-rose-800', 'label' => 'Đã hủy đơn'],
                                5 => ['bg' => 'bg-slate-100 dark:bg-slate-800', 'text' => 'text-slate-700 dark:text-slate-300', 'border' => 'border-slate-200 dark:border-slate-700', 'label' => 'Đã hoàn tiền'],
                            ];
                            $cfg = $statusConfig[$order->status] ?? $statusConfig[0];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-bold border {{ $cfg['bg'] }} {{ $cfg['text'] }} {{ $cfg['border'] }}">
                            {{ $cfg['label'] }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Ngày tạo đơn: {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y - H:i') }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.orders.edit', $order->id) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-xs sm:text-sm font-bold rounded-xl transition-colors shadow-sm">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Cập nhật trạng thái</span>
                </a>
                <a href="{{ route('admin.orders.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-semibold rounded-xl transition-colors shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Danh sách đơn</span>
                </a>
            </div>
        </div>

        {{-- MAIN CARD --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 space-y-8 shadow-sm">

            {{-- 2 COLUMNS: CUSTOMER INFO & TOUR INFO --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
                
                {{-- KHÁCH HÀNG --}}
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/80 space-y-4">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-200 dark:border-slate-700">
                        <div class="w-9 h-9 rounded-xl bg-orange-100 dark:bg-orange-950 text-orange-600 dark:text-orange-400 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-user text-sm"></i>
                        </div>
                        <h5 class="text-base font-bold text-slate-800 dark:text-white">Thông tin khách hàng</h5>
                    </div>

                    <div class="space-y-3 text-xs sm:text-sm">
                        <div class="flex justify-between items-start py-1">
                            <span class="text-slate-500 dark:text-slate-400">Họ và tên:</span>
                            <span class="font-bold text-slate-800 dark:text-white text-right">{{ $order->name }}</span>
                        </div>
                        <div class="flex justify-between items-start py-1">
                            <span class="text-slate-500 dark:text-slate-400">Số điện thoại:</span>
                            <a href="tel:{{ $order->phone }}" class="font-bold text-blue-600 hover:underline">{{ $order->phone }}</a>
                        </div>
                        <div class="flex justify-between items-start py-1">
                            <span class="text-slate-500 dark:text-slate-400">Địa chỉ Email:</span>
                            <span class="font-bold text-slate-800 dark:text-white text-right">{{ $order->email }}</span>
                        </div>
                        <div class="flex justify-between items-start py-1">
                            <span class="text-slate-500 dark:text-slate-400">Địa chỉ liên hệ:</span>
                            <span class="font-medium text-slate-700 dark:text-slate-200 text-right max-w-[65%]">{{ $order->address ?: 'Không có' }}</span>
                        </div>
                        @if($order->note)
                            <div class="pt-2 border-t border-slate-200 dark:border-slate-700">
                                <span class="text-slate-500 dark:text-slate-400 block mb-1">Ghi chú & Tùy chọn dịch vụ:</span>
                                <p class="text-xs font-semibold text-slate-800 dark:text-slate-100 bg-white dark:bg-slate-900 p-3 rounded-xl border border-slate-200 dark:border-slate-700">
                                    {{ $order->note }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- THÔNG TIN TOUR --}}
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/80 space-y-4">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-200 dark:border-slate-700">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-map-location-dot text-sm"></i>
                        </div>
                        <h5 class="text-base font-bold text-slate-800 dark:text-white">Thông tin tour du lịch</h5>
                    </div>

                    @if($order->tour)
                        <div class="flex items-center gap-3.5 pb-2">
                            <img src="{{ Str::startsWith($order->tour->image, ['http://', 'https://']) ? $order->tour->image : asset($order->tour->image) }}"
                                 class="w-16 h-16 rounded-xl object-cover shrink-0 border border-slate-200 dark:border-slate-700 shadow-sm" alt="Tour">
                            <div class="min-w-0 flex-1">
                                <a href="{{ route('user.tourDetail.index', $order->tour->id) }}" target="_blank"
                                   class="font-bold text-slate-800 dark:text-white hover:text-[#b85e3a] text-sm leading-snug line-clamp-2">
                                    {{ $order->tour->name }}
                                </a>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                    Mã tour: #TOUR-{{ $order->tour->id }} • Lịch trình: {{ $order->tour->time }}
                                </p>
                            </div>
                        </div>

                        <div class="space-y-3 text-xs sm:text-sm pt-2 border-t border-slate-200 dark:border-slate-700">
                            <div class="flex justify-between items-start py-1">
                                <span class="text-slate-500 dark:text-slate-400">Ngày khởi hành:</span>
                                <span class="font-bold text-slate-800 dark:text-white">
                                    {{ \Carbon\Carbon::parse($order->start_date ?: $order->tour->start_date)->format('d/m/Y') }}
                                </span>
                            </div>
                            <div class="flex justify-between items-start py-1">
                                <span class="text-slate-500 dark:text-slate-400">Lộ trình:</span>
                                <span class="font-bold text-slate-800 dark:text-white">
                                    {{ $order->tour->start_location }} &rarr; {{ $order->tour->end_location }}
                                </span>
                            </div>
                            <div class="flex justify-between items-start py-1">
                                <span class="text-slate-500 dark:text-slate-400">Số lượng hành khách:</span>
                                <span class="font-bold text-[#863c20] text-sm">{{ $order->quantity }} người lớn</span>
                            </div>
                        </div>
                    @else
                        <p class="text-xs text-rose-500 italic py-4">Tour gốc đã bị gỡ hoặc không còn tồn tại trên hệ thống.</p>
                    @endif
                </div>
            </div>

            {{-- FINANCIALS --}}
            <div class="p-6 rounded-2xl bg-[#faf8f5] dark:bg-slate-800/40 border border-[#e8dfd1] dark:border-slate-700 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-[#e8dfd1] dark:border-slate-700">
                    <h5 class="text-base font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-coins text-[#863c20]"></i> Bảng kê tài chính & Đặt cọc
                    </h5>
                    <span class="text-xs font-semibold text-slate-500">Chính sách đặt chỗ lữ hành</span>
                </div>

                @php
                    $total = $order->total_price;
                    $depositAmt = round($total * 0.3, 0);
                    $remainAmt = $total - $depositAmt;
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 text-center">
                    <div class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                        <span class="text-xs text-slate-400 block mb-1">Tổng giá trị đơn</span>
                        <span class="text-lg font-bold text-slate-800 dark:text-white">{{ number_format($total) }}đ</span>
                    </div>

                    <div class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                        <span class="text-xs text-slate-400 block mb-1">Mức cọc tối thiểu (30%)</span>
                        <span class="text-lg font-bold text-[#863c20]">{{ number_format($depositAmt) }}đ</span>
                    </div>

                    <div class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                        <span class="text-xs text-slate-400 block mb-1">Khoản còn lại (70%)</span>
                        <span class="text-lg font-bold text-slate-600 dark:text-slate-300">{{ number_format($remainAmt) }}đ</span>
                    </div>

                    <div class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                        <span class="text-xs text-slate-400 block mb-1">Thực thu qua cổng TT</span>
                        <span class="text-lg font-bold {{ $order->status >= 1 ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ $order->status >= 1 ? number_format($depositAmt) . 'đ' : '0đ (Chờ thu)' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- PAYMENT HISTORY --}}
            <div class="space-y-4">
                <h5 class="text-base font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-slate-400"></i> Lịch sử thanh toán & Giao dịch
                </h5>

                @if($order->payments && $order->payments->count() > 0)
                    <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-bold">
                                <tr>
                                    <th class="px-4 py-3">Mã GD</th>
                                    <th class="px-4 py-3">Phương thức</th>
                                    <th class="px-4 py-3">Loại thanh toán</th>
                                    <th class="px-4 py-3 text-right">Số tiền</th>
                                    <th class="px-4 py-3 text-center">Trạng thái</th>
                                    <th class="px-4 py-3">Thời gian</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach($order->payments as $pm)
                                    <tr>
                                        <td class="px-4 py-3 font-mono font-bold text-slate-700 dark:text-slate-300">#PM-{{ $pm->id }}</td>
                                        <td class="px-4 py-3 font-semibold">{{ $pm->payment_method }}</td>
                                        <td class="px-4 py-3">{{ $pm->payment_type === 'deposit' ? 'Đặt cọc 30%' : 'Thanh toán đợt cuối' }}</td>
                                        <td class="px-4 py-3 text-right font-bold text-emerald-600">{{ number_format($pm->amount) }}đ</td>
                                        <td class="px-4 py-3 text-center">
                                            @if($pm->status == 1)
                                                <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 font-bold text-[10px]">Thành công</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-700 font-bold text-[10px]">Chờ xử lý</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-slate-400">{{ $pm->created_at ? $pm->created_at->format('d/m/Y - H:i') : '---' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-6 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-800 text-center text-xs text-slate-500">
                        Chưa có bản ghi thanh toán trực tuyến nào được tạo qua cổng MoMo / PayPal cho đơn hàng này.
                    </div>
                @endif
            </div>

            {{-- ACTION FOOTER --}}
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('admin.orders.index') }}"
                   class="w-full sm:w-auto px-6 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-slate-50 text-center">
                    &larr; Trở về danh sách đơn hàng
                </a>

                <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                    <button type="button" onclick="window.print()"
                            class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-200 font-bold text-xs transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-print"></i> In đơn hàng
                    </button>
                    <a href="{{ route('admin.orders.edit', $order->id) }}"
                       class="px-6 py-2.5 rounded-xl bg-[#863c20] hover:bg-[#a34c2a] text-white font-bold text-xs transition-colors flex items-center gap-2 shadow-xs">
                        <i class="fa-solid fa-pen"></i> Chỉnh sửa trạng thái
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
