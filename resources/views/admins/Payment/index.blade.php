@extends('admins.master')

@section('title', 'Danh sách thanh toán')

@section('home')
<div class="min-h-screen bg-slate-50/50 py-4 sm:py-8">
    <div class="max-w-[120rem] mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-xl sm:text-3xl font-bold text-slate-900 ">Quản lý thanh toán</h1>
                <p class="mt-1 text-sm text-slate-500 font-medium ">Theo dõi các giao dịch tài chính và trạng thái thanh toán.</p>
            </div>
            <div class="bg-white px-6 py-3 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-sm font-medium text-slate-400 ">Tổng giao dịch</p>
                <p class="text-xl font-bold text-emerald-600">{{ $payments->total() }} <span class="text-xs text-slate-400 font-bold ">giao dịch</span></p>
            </div>
        </div>

        <div class="bg-white shadow-xl shadow-slate-200/50 ring-1 ring-slate-100 rounded-3xl overflow-hidden">
            <!-- Desktop Table View (Hidden on Mobile) -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-bold text-slate-700 ">Giao dịch</th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-bold text-slate-700 ">Khách hàng & Tour</th>
                            <th scope="col" class="px-6 py-4 text-center text-sm font-bold text-slate-700 ">Số tiền</th>
                            <th scope="col" class="px-6 py-4 text-center text-sm font-bold text-slate-700 ">Loại thanh toán</th>
                            <th scope="col" class="px-6 py-4 text-center text-sm font-bold text-slate-700 ">Trạng thái</th>
                            <th scope="col" class="px-6 py-4 text-right text-sm font-bold text-slate-700 ">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-50">
                        @foreach ($payments as $payment)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs ring-2 ring-white shadow-sm ">
                                            {{ substr($payment->payment_method ?? 'P', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-slate-900">#{{ $payment->id }}</div>
                                            <div class="text-sm text-slate-400 font-medium  ">{{ $payment->payment_method }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-slate-800 line-clamp-1 max-w-[200px]">{{ $payment->order->user->name ?? 'N/A' }}</div>
                                    <div class="text-sm text-slate-400 font-medium  line-clamp-1 max-w-[200px]">{{ $payment->order->tour->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center text-sm font-bold text-emerald-600">
                                    {{ number_format($payment->amount) }}₫
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    @if ($payment->payment_type === 'deposit')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-blue-50 text-blue-700 text-sm font-bold  border border-blue-100">
                                            Đặt cọc
                                        </span>
                                    @elseif($payment->payment_type === 'final')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-emerald-50 text-emerald-700 text-sm font-bold  border border-emerald-100">
                                            Hoàn tất
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-slate-50 text-slate-600 text-sm font-bold  border border-slate-200">
                                            {{ $payment->payment_type }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    @php
                                        $statusConfig = [
                                            0 => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-100', 'label' => 'Chờ xử lý', 'icon' => 'fa-clock'],
                                            1 => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-100', 'label' => 'Thành công', 'icon' => 'fa-circle-check'],
                                            2 => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-100', 'label' => 'Thất bại', 'icon' => 'fa-circle-xmark'],
                                        ];
                                        $config = $statusConfig[$payment->status] ?? $statusConfig[0];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold  border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }} shadow-sm">
                                        <i class="fa-solid {{ $config['icon'] }} mr-1.5 text-[9px]"></i>
                                        {{ $config['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right">
                                    <a href="{{ route('admin.payments.show', $payment->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-xl transition-all active:scale-90 inline-block" title="Chi tiết">
                                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View (Shown on Mobile) -->
            <div class="lg:hidden divide-y divide-slate-100 bg-white">
                @foreach ($payments as $payment)
                    @php
                        $config = $statusConfig[$payment->status] ?? $statusConfig[0];
                    @endphp
                    <div class="p-5 space-y-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm shadow-inner ">
                                    {{ substr($payment->payment_method ?? 'P', 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-slate-900 leading-tight">#{{ $payment->id }}</h3>
                                    <p class="text-sm text-slate-400 font-bold ">{{ $payment->payment_method }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[9px] font-bold  border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }} shadow-sm">
                                <i class="fa-solid {{ $config['icon'] }} mr-1 text-[8px]"></i>
                                {{ $config['label'] }}
                            </span>
                        </div>

                        <div class="bg-slate-50/80 p-4 rounded-2xl border border-slate-100 space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-[9px] font-bold text-slate-400  block mb-0.5">Khách hàng</span>
                                    <span class="text-xs font-bold text-slate-800 line-clamp-1 ">{{ $payment->order->user->name ?? 'N/A' }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[9px] font-bold text-slate-400  block mb-0.5">Số tiền</span>
                                    <span class="text-sm font-bold text-emerald-600">{{ number_format($payment->amount) }}₫</span>
                                </div>
                            </div>
                            <div class="pt-2 border-t border-slate-100">
                                <span class="text-[9px] font-bold text-slate-400  block mb-1">Tour đăng ký</span>
                                <span class="text-xs font-bold text-slate-600 line-clamp-1   er">{{ $payment->order->tour->name ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            @if ($payment->payment_type === 'deposit')
                                <div class="flex-1 px-4 py-3 bg-blue-50 text-blue-700 rounded-2xl text-sm font-bold  border border-blue-100 text-center">
                                    Đặt cọc
                                </div>
                            @elseif($payment->payment_type === 'final')
                                <div class="flex-1 px-4 py-3 bg-emerald-50 text-emerald-700 rounded-2xl text-sm font-bold  border border-emerald-100 text-center">
                                    Hoàn tất
                                </div>
                            @endif

                            <a href="{{ route('admin.payments.show', $payment->id) }}" class="flex-[1.5] flex items-center justify-center gap-2 py-3 bg-emerald-600 text-white rounded-2xl text-sm font-bold  shadow-lg shadow-emerald-100 active:scale-95 transition-all">
                                <i class="fa-solid fa-eye"></i>
                                Chi tiết giao dịch
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($payments->hasPages())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                    {{ $payments->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

