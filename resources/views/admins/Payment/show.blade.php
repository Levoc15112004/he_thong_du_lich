@extends('admins.master')

@section('title', 'Chi tiết thanh toán')

@section('home')
<div class="min-h-screen bg-slate-50/50 py-4 sm:py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- HEADER -->
        <div class="relative overflow-hidden bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100">
            <!-- Decorative Background Element -->
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-emerald-50 rounded-full opacity-50 blur-3xl"></div>

            <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-sm font-bold   rounded-lg border border-emerald-100 shadow-sm">Giao dịch #{{ $payment->id }}</span>
                    </div>
                    <h1 class="text-2xl sm:text-4xl font-bold text-slate-900   leading-none">Chi tiết thanh toán</h1>
                    <p class="mt-2 text-sm text-slate-400 font-medium ">Mã tham chiếu: <span class="font-mono text-slate-600">{{ $payment->charge_id ?? 'N/A' }}</span></p>
                </div>

                <div class="flex flex-col items-end gap-2">
                    @php
                        $statusConfig = [
                            0 => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-100', 'label' => 'Chờ xử lý', 'icon' => 'fa-clock'],
                            1 => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-100', 'label' => 'Thành công', 'icon' => 'fa-circle-check'],
                            2 => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-100', 'label' => 'Thất bại', 'icon' => 'fa-circle-xmark'],
                        ];
                        $config = $statusConfig[$payment->status] ?? $statusConfig[0];
                    @endphp
                    <span class="inline-flex items-center px-4 py-2 rounded-2xl text-xs font-bold   border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }} shadow-sm">
                        <i class="fa-solid {{ $config['icon'] }} mr-2"></i>
                        {{ $config['label'] }}
                    </span>
                    <p class="text-sm text-slate-400 font-bold  ">{{ optional($payment->payment_date)->format('d/m/Y H:i') ?? 'Chưa cập nhật ngày' }}</p>
                </div>
            </div>
        </div>

        <!-- GRID INFO -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- PAYMENT INFO -->
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/30">
                    <h3 class="text-sm font-bold text-slate-400   flex items-center gap-2">
                        <i class="fa-solid fa-credit-card text-emerald-500"></i>
                        Thông tin tài chính
                    </h3>
                </div>
                <div class="p-8 space-y-6">
                    <div class="flex justify-between items-end border-b border-slate-50 pb-4">
                        <span class="text-sm font-bold text-slate-400   ">Số tiền giao dịch</span>
                        <span class="text-2xl font-bold text-emerald-600  ">{{ number_format($payment->amount) }}₫</span>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <span class="text-sm font-bold text-slate-400   block mb-1">Phương thức</span>
                            <span class="text-sm font-bold text-slate-800  ">{{ $payment->payment_method }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-bold text-slate-400   block mb-1">Loại</span>
                            <span class="text-sm font-bold text-emerald-600   ">{{ $payment->payment_type == 'deposit' ? 'Đặt cọc' : 'Hoàn tất' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ORDER INFO -->
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/30">
                    <h3 class="text-sm font-bold text-slate-400   flex items-center gap-2">
                        <i class="fa-solid fa-file-invoice text-emerald-500"></i>
                        Thông tin đơn hàng
                    </h3>
                </div>
                <div class="p-8 space-y-6">
                    <div class="flex justify-between items-start gap-4 border-b border-slate-50 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs  shadow-inner">
                                {{ substr($payment->order->user->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <span class="text-sm font-bold text-slate-400   block">Khách hàng</span>
                                <span class="text-sm font-bold text-slate-900  ">{{ $payment->order->user->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-bold text-slate-400   block">Mã đơn</span>
                            <span class="text-sm font-bold text-slate-800 ">#{{ $payment->order->id }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-slate-400   block mb-1">Tour đăng ký</span>
                        <span class="text-xs font-bold text-slate-600  leading-relaxed  line-clamp-1 ">{{ $payment->order->tour->name ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- TRANSACTION TIMELINE -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-50 bg-slate-50/30">
                <h3 class="text-sm font-bold text-slate-400   flex items-center gap-2">
                    <i class="fa-solid fa-timeline text-emerald-500"></i>
                    Lịch sử dòng tiền
                </h3>
            </div>
            <div class="p-8">
                <div class="relative space-y-8 before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gray-100 before:to-transparent">

                    @forelse($payment->transactions as $tran)
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                            <!-- Icon/Dot -->
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-50 group-[.is-active]:bg-emerald-500 group-[.is-active]:text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 transition-all duration-300">
                                <i class="fa-solid {{ $tran->status == 'success' ? 'fa-check' : ($tran->status == 'pending' ? 'fa-clock' : 'fa-xmark') }} text-sm"></i>
                            </div>
                            <!-- Content -->
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-6 rounded-3xl bg-slate-50/50 border border-slate-100 shadow-sm group-hover:bg-white transition-all duration-300">
                                <div class="flex items-center justify-between space-x-2 mb-1">
                                    <div class="text-sm font-bold text-slate-400  ">
                                        @if ($tran->transaction_type === 'init') Khởi tạo @elseif($tran->transaction_type === 'confirm') Xác nhận @else Giao dịch @endif
                                    </div>
                                    <time class="text-sm font-bold text-emerald-600  ">{{ $tran->created_at->format('H:i d/m/Y') }}</time>
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <div class="text-xs font-bold text-slate-800   ">{{ $tran->transaction_code ?? 'NO_CODE' }}</div>
                                    <div class="text-sm font-bold text-emerald-600">{{ number_format($tran->amount) }}₫</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <p class="text-xs font-bold text-gray-300  ">Không có dữ liệu dòng tiền</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

        <!-- ACTIONS -->
        <div class="flex flex-col sm:flex-row gap-4 pt-4">
            <a href="{{ route('admin.payments.index') }}" class="flex-1 flex items-center justify-center gap-2 py-4 bg-white border border-slate-200 text-slate-500 text-sm font-bold   rounded-2xl hover:bg-slate-50 transition-all active:scale-95 shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                Quay lại danh sách
            </a>
            <button onclick="window.print()" class="flex-1 flex items-center justify-center gap-2 py-4 bg-gray-900 text-white text-sm font-bold   rounded-2xl hover:bg-black transition-all active:scale-95 shadow-lg shadow-slate-200">
                <i class="fa-solid fa-print"></i>
                In hóa đơn giao dịch
            </button>
        </div>

    </div>
</div>
@endsection

