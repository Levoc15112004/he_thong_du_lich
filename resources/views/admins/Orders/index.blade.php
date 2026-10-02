@extends('admins.master')

@section('title', 'Danh sách Tiếp nhận Đơn đặt Tour')

@section('home')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 px-4 sm:px-6 lg:px-8 py-8 transition-colors duration-200">
    <div class="max-w-[120rem] mx-auto space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-2 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-13 h-13 p-3.5 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/20 shrink-0">
                    <i class="fa-solid fa-file-invoice-dollar text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Quản lý Đơn đặt Tour
                    </h4>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Theo dõi thời gian thực mọi yêu cầu đặt vé và trạng thái thanh toán từ khách hàng</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-receipt text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Tổng đơn</p>
                        <p class="text-base font-extrabold text-slate-800 dark:text-slate-100">{{ $totalCount ?? $orders->total() }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ALERTS --}}
        @if(session('success'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0">
                    <i class="fa-solid fa-check"></i>
                </div>
                <p class="font-medium text-sm">{{ session('success') }}</p>
            </div>
        @elseif(session('error'))
            <div class="bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-200 px-5 py-3.5 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-rose-100 dark:bg-rose-900/50 flex items-center justify-center text-rose-600 dark:text-rose-400 shrink-0">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <p class="font-medium text-sm">{{ session('error') }}</p>
            </div>
        @endif

        {{-- FILTER & SEARCH BAR --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-4 sm:p-5 shadow-sm">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 items-stretch md:items-center justify-between">
                <div class="flex-1 flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm theo Mã đơn, Tên khách hàng, SĐT, Email..." class="w-full pl-11 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                    <select name="status" class="px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 cursor-pointer">
                        <option value="all" {{ request('status') === 'all' || !request()->has('status') ? 'selected' : '' }}>Tất cả trạng thái</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Chờ duyệt / Chưa cọc</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Đã đặt cọc</option>
                        <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Đã thanh toán xong</option>
                        <option value="3" {{ request('status') === '3' ? 'selected' : '' }}>Hoàn thành</option>
                        <option value="4" {{ request('status') === '4' ? 'selected' : '' }}>Đã hủy</option>
                        <option value="5" {{ request('status') === '5' ? 'selected' : '' }}>Hoàn tiền</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all flex items-center gap-2 justify-center">
                        <i class="fa-solid fa-filter text-xs"></i>
                        <span>Lọc kết quả</span>
                    </button>
                    @if(request()->has('keyword') || (request()->has('status') && request('status') !== 'all'))
                        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 text-sm font-medium rounded-xl transition-all">
                            Xóa lọc
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- DESKTOP TABLE VIEW --}}
        <div class="hidden lg:block bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-3xl overflow-hidden relative">
            
            <table class="w-full text-left border-collapse relative z-10">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-4 w-16">#Đơn</th>
                        <th class="px-6 py-4">Khách hàng</th>
                        <th class="px-6 py-4 w-1/3">Chi tiết Tour & Hành trình</th>
                        <th class="px-6 py-4 text-right">Tổng thanh toán</th>
                        <th class="px-6 py-4 text-center w-36">Trạng thái</th>
                        <th class="px-6 py-4 text-center w-28">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4 font-mono text-sm font-bold text-slate-600 dark:text-slate-400">
                                #{{ $order->id }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-950 text-blue-700 dark:text-blue-300 font-bold text-sm flex items-center justify-center shrink-0">
                                        {{ mb_substr($order->name ?? 'K', 0, 1) }}
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-slate-800 dark:text-slate-100 text-sm leading-tight">{{ $order->name ?? 'Khách vãng lai' }}</h5>
                                        <div class="flex items-center gap-1.5 mt-1 text-xs text-slate-500 dark:text-slate-400 font-mono">
                                            <i class="fa-solid fa-phone text-[10px]"></i>
                                            <span>{{ $order->phone ?? '---' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <h6 class="font-bold text-slate-800 dark:text-slate-200 text-sm mb-1.5 line-clamp-1 leading-snug">
                                    {{ $order->tour->name ?? 'Tour không còn tồn tại' }}
                                </h6>
                                <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
                                    @if($order->tour && $order->tour->start_date)
                                        <span class="bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-300 px-2 py-0.5 rounded-md border border-blue-100 dark:border-blue-900">
                                            <i class="fa-regular fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($order->tour->start_date)->format('d/m/Y') }}
                                        </span>
                                    @endif
                                    <span class="bg-amber-50 dark:bg-amber-950 text-amber-600 dark:text-amber-300 px-2 py-0.5 rounded-md border border-amber-100 dark:border-amber-900">
                                        <i class="fa-solid fa-user-group mr-1"></i>{{ $order->quantity }} Khách
                                    </span>
                                    <span class="text-slate-400 text-[11px]">
                                        {{ $order->created_at ? $order->created_at->format('H:i d/m/Y') : '' }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <span class="text-base font-extrabold text-blue-600 dark:text-blue-400">
                                    {{ number_format($order->total_price) }} ₫
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusConfig = [
                                        0 => ['bg' => 'bg-slate-100 dark:bg-slate-800', 'text' => 'text-slate-700 dark:text-slate-300', 'border' => 'border-slate-200 dark:border-slate-700', 'label' => 'Chờ Duyệt', 'icon' => 'fa-clock'],
                                        1 => ['bg' => 'bg-blue-50 dark:bg-blue-950', 'text' => 'text-blue-700 dark:text-blue-300', 'border' => 'border-blue-200 dark:border-blue-800', 'label' => 'Đã Cọc', 'icon' => 'fa-coins'],
                                        2 => ['bg' => 'bg-indigo-50 dark:bg-indigo-950', 'text' => 'text-indigo-700 dark:text-indigo-300', 'border' => 'border-indigo-200 dark:border-indigo-800', 'label' => 'Đã TT Xong', 'icon' => 'fa-circle-check'],
                                        3 => ['bg' => 'bg-emerald-50 dark:bg-emerald-950', 'text' => 'text-emerald-700 dark:text-emerald-300', 'border' => 'border-emerald-200 dark:border-emerald-800', 'label' => 'Hoàn Thành', 'icon' => 'fa-flag-checkered'],
                                        4 => ['bg' => 'bg-rose-50 dark:bg-rose-950', 'text' => 'text-rose-700 dark:text-rose-300', 'border' => 'border-rose-200 dark:border-rose-800', 'label' => 'Đã Hủy', 'icon' => 'fa-ban'],
                                        5 => ['bg' => 'bg-amber-50 dark:bg-amber-950', 'text' => 'text-amber-700 dark:text-amber-300', 'border' => 'border-amber-200 dark:border-amber-800', 'label' => 'Hoàn Tiền', 'icon' => 'fa-rotate-left'],
                                    ];
                                    $config = $statusConfig[$order->status] ?? $statusConfig[0];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold justify-center shadow-sm border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                    <i class="fa-solid {{ $config['icon'] }} text-[10px]"></i>
                                    {{ $config['label'] }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                       class="w-8 h-8 flex items-center justify-center text-blue-600 bg-blue-50 dark:bg-blue-900/40 hover:bg-blue-600 hover:text-white rounded-lg transition-all" title="Xem chi tiết đơn">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.orders.edit', $order->id) }}"
                                       class="w-8 h-8 flex items-center justify-center text-amber-600 bg-amber-50 dark:bg-amber-900/40 hover:bg-amber-600 hover:text-white rounded-lg transition-all" title="Đổi trạng thái đơn">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-boxes-packing text-4xl mb-3 text-slate-300"></i>
                                    <p class="text-base font-semibold">Không tìm thấy đơn đặt tour nào phù hợp.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            @if ($orders->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900">
                    {{ $orders->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

        {{-- MOBILE CARDS VIEW --}}
        <div class="lg:hidden space-y-3">
            @forelse ($orders as $order)
                @php
                    $config = $statusConfig[$order->status] ?? $statusConfig[0];
                @endphp
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-4 space-y-3">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-2.5">
                            <span class="font-mono text-xs font-bold text-slate-400">#{{ $order->id }}</span>
                            <span class="font-bold text-slate-800 dark:text-slate-100 text-sm">{{ $order->name ?? '---' }}</span>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-bold border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                            <i class="fa-solid {{ $config['icon'] }} text-[9px]"></i>
                            {{ $config['label'] }}
                        </span>
                    </div>
                    
                    <div>
                        <p class="font-semibold text-slate-800 dark:text-slate-200 text-xs line-clamp-2">
                            {{ $order->tour->name ?? 'Tour không còn tồn tại' }}
                        </p>
                        <div class="flex items-center justify-between mt-2 pt-2 border-t border-slate-100 dark:border-slate-800 text-xs">
                            <span class="text-slate-500 font-mono"><i class="fa-solid fa-phone mr-1"></i>{{ $order->phone ?? '---' }}</span>
                            <span class="font-extrabold text-blue-600 dark:text-blue-400">{{ number_format($order->total_price) }} ₫</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="px-3 py-1.5 bg-blue-50 dark:bg-blue-900/40 text-blue-600 text-xs font-bold rounded-lg flex items-center gap-1">
                            <i class="fa-solid fa-eye text-[10px]"></i> Chi tiết
                        </a>
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="px-3 py-1.5 bg-amber-50 dark:bg-amber-900/40 text-amber-600 text-xs font-bold rounded-lg flex items-center gap-1">
                            <i class="fa-solid fa-pen text-[10px]"></i> Đổi trạng thái
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-slate-400">
                    <p class="text-sm">Chưa có đơn hàng nào.</p>
                </div>
            @endforelse

            @if ($orders->hasPages())
                <div class="py-4">
                    {{ $orders->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
