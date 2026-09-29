@extends('admins.master')

@section('title', 'Danh sách Tiêp nhận Đơn đặt Tour')

@section('home')
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-[120rem] mx-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-4 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-400 to-emerald-500 flex items-center justify-center text-white shadow-lg shadow-teal-200 shrink-0">
                    <i class="fa-solid fa-file-invoice-dollar text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-700 to-emerald-600">
                        Quản lý Đơn đặt Tour
                    </h4>
                    <p class="text-sm text-slate-500 mt-1">Theo dõi và xử lý các yêu cầu đặt vé từ khách hàng</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl shadow-sm flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Tổng Đơn Hàng</p>
                        <p class="text-sm font-bold text-slate-800">{{ $orders->total() }} Đơn</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ALERTS --}}
        @if(session('success'))
            <div class="bg-emerald-50/80 backdrop-blur-sm border border-emerald-200 text-emerald-800 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                    <i class="fa-solid fa-check"></i>
                </div>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @elseif(session('error'))
            <div class="bg-rose-50/80 backdrop-blur-sm border border-rose-200 text-rose-800 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif

        {{-- DESKTOP TABLE VIEW --}}
        <div class="hidden lg:block bg-white/90 backdrop-blur-xl border border-white shadow-2xl shadow-slate-200/50 rounded-3xl overflow-hidden relative">
            <div class="absolute top-0 right-0 p-40 bg-teal-50/50 rounded-full blur-3xl opacity-50 -z-10 -translate-y-1/2 translate-x-1/2"></div>
            
            <table class="w-full text-left border-collapse relative z-10">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 w-16">#</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700">Khách hàng</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 w-1/3">Chi tiết Tour & Hành trình</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 text-right">Tổng thanh toán</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 text-center w-40">Trạng thái</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 text-center w-28">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            
                            <td class="px-6 py-5 font-mono text-sm text-slate-500 font-bold group-hover:text-teal-600 transition-colors">
                                {{ $order->id }}
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full overflow-hidden border border-slate-200 shadow-sm bg-teal-50 text-teal-600 font-bold text-lg flex items-center justify-center shrink-0">
                                        {{ substr($order->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-slate-800 text-base leading-tight group-hover:text-teal-600 transition-colors">{{ $order->name ?? '---' }}</h5>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <i class="fa-solid fa-phone text-slate-400 text-xs shrink-0"></i>
                                            <span class="text-xs font-mono text-slate-500 font-medium">{{ $order->phone ?? 'Không có SĐT' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <h6 class="font-bold text-slate-700 text-sm mb-1.5 line-clamp-2 leading-relaxed" title="{{ $order->tour->name }}">{{ $order->tour->name }}</h6>
                                <div class="flex items-center gap-4 text-xs font-semibold">
                                    <span class="bg-blue-50 text-blue-600 border border-blue-100 px-2.5 py-1 rounded-md shadow-sm"><i class="fa-regular fa-calendar shrink-0 mr-1"></i>{{ \Carbon\Carbon::parse($order->tour->start_date)->format('d/m/Y') }}</span>
                                    <span class="bg-orange-50 text-orange-600 border border-orange-100 px-2.5 py-1 rounded-md shadow-sm"><i class="fa-solid fa-user-group shrink-0 mr-1"></i>{{ $order->quantity }} Chỗ</span>
                                </div>
                            </td>

                            <td class="px-6 py-5 text-right whitespace-nowrap">
                                <span class="text-lg font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-500 to-teal-600">{{ number_format($order->total_price) }} ₫</span>
                            </td>

                            <td class="px-6 py-5 text-center">
                                @php
                                    $statusConfig = [
                                        0 => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'border' => 'border-slate-200', 'label' => 'Chờ Duyệt', 'icon' => 'fa-clock'],
                                        1 => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'label' => 'Đã Cọc', 'icon' => 'fa-coins'],
                                        2 => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-200', 'label' => 'Đã TT Xong', 'icon' => 'fa-check'],
                                        3 => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'label' => 'Hoàn Thành', 'icon' => 'fa-flag-checkered'],
                                        4 => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-200', 'label' => 'Đã Hủy', 'icon' => 'fa-ban'],
                                        5 => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'label' => 'Hoàn Tiền', 'icon' => 'fa-rotate-left'],
                                    ];
                                    $config = $statusConfig[$order->status] ?? $statusConfig[0];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold w-32 justify-center shadow-sm border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                    <i class="fa-solid {{ $config['icon'] }}"></i>
                                    {{ $config['label'] }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-center">
                                <div class="flex justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.orders.edit', $order->id) }}"
                                        class="w-10 h-10 flex items-center justify-center text-amber-500 bg-amber-50 border border-amber-200 rounded-xl hover:bg-amber-500 hover:text-white transition-all shadow-sm tooltip" title="Kiểm tra & Cập nhật">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-boxes-packing text-5xl mb-4 text-slate-300"></i>
                                    <p class="text-lg font-medium">Chưa có đơn đặt tour nào trong hệ thống.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            @if ($orders->hasPages())
                <div class="px-6 py-4 border-t border-slate-50 bg-white relative z-10">
                    {{ $orders->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

        {{-- MOBILE CARDS VIEW --}}
        <div class="lg:hidden space-y-4">
            @forelse ($orders as $order)
                @php
                    $config = $statusConfig[$order->status] ?? $statusConfig[0];
                @endphp
                <div class="bg-white/90 backdrop-blur-xl border border-white rounded-3xl shadow-lg shadow-slate-200/50 p-5 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-8 bg-teal-50/50 rounded-full blur-2xl -z-10 -translate-y-1/2 translate-x-1/2"></div>
                    
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden border border-slate-200 shadow-sm bg-teal-50 text-teal-600 font-bold flex items-center justify-center shrink-0">
                                {{ substr($order->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <h5 class="font-bold text-slate-800 text-sm leading-tight">{{ $order->name ?? '---' }}</h5>
                                <span class="text-xs text-slate-500 font-mono"><i class="fa-solid fa-phone mr-1"></i>{{ $order->phone ?? '---' }}</span>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold border uppercase tracking-wider {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                            <i class="fa-solid {{ $config['icon'] }}"></i>
                            {{ $config['label'] }}
                        </span>
                    </div>
                    
                    <div class="bg-slate-50/80 p-3.5 rounded-xl border border-slate-100 mb-4">
                        <h6 class="font-bold text-slate-800 text-xs mb-2 line-clamp-2 leading-relaxed">{{ $order->tour->name }}</h6>
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-600 bg-white p-2 rounded-lg border border-slate-100 shadow-sm">
                            <span class="text-blue-600"><i class="fa-regular fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($order->tour->start_date)->format('d/m/Y') }}</span>
                            <span class="text-orange-500"><i class="fa-solid fa-user-group mr-1"></i>{{ $order->quantity }} Chỗ</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-2 pt-2 border-t border-slate-50">
                        <span class="text-xs font-bold text-slate-400">TỔNG TIỀN:</span>
                        <span class="text-lg font-bold text-emerald-600">{{ number_format($order->total_price) }} ₫</span>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-3 pt-4 mt-2">
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="flex items-center justify-center gap-2 bg-amber-50 hover:bg-amber-500 text-amber-600 hover:text-white py-3 rounded-xl font-bold transition-colors text-sm border border-amber-100 shadow-sm">
                            <i class="fa-solid fa-clipboard-check"></i> Cập nhật Đơn hàng
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white/80 p-10 rounded-3xl border border-dashed border-slate-300 text-center">
                    <i class="fa-solid fa-boxes-packing text-4xl mb-3 text-slate-300"></i>
                    <p class="text-slate-500 font-medium">Không có dữ liệu đơn hàng!</p>
                </div>
            @endforelse
            
            @if ($orders->hasPages())
                <div class="pt-2">
                    {{ $orders->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
