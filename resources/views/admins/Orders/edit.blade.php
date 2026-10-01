@extends('admins.master')

@section('title', 'Cập nhật Đơn đặt Tour')

@section('home')
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-6xl mx-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-2 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-lg shadow-amber-200 shrink-0">
                    <i class="fa-solid fa-file-signature text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-amber-600 to-orange-500">
                        Cập nhật Đơn hàng #{{ $order->id }}
                    </h4>
                    <p class="text-sm text-slate-500 mt-1 flex items-center gap-2 font-medium">
                        <i class="fa-solid fa-map-location-dot text-slate-400"></i>
                        <span class="truncate max-w-[200px] sm:max-w-md" title="{{ $order->tour->name }}">{{ $order->tour->name }}</span>
                    </p>
                </div>
            </div>

            <a href="{{ route('admin.orders.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-xl transition-all duration-300 shadow-sm group shrink-0">
                <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                <span>Trở lại danh sách</span>
            </a>
        </div>

        {{-- CONTENT CARD --}}
        <div class="bg-white/95 backdrop-blur-xl border border-white shadow-2xl shadow-slate-200/60 rounded-3xl overflow-hidden relative">
            <div class="absolute top-0 right-0 p-40 bg-amber-50/50 rounded-full blur-3xl opacity-60 -z-10 -translate-y-1/2 translate-x-1/2"></div>
            
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="relative z-10 p-6 sm:p-10 space-y-8">
                @csrf
                @method('PUT')

                {{-- GRID THÔNG TIN --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    {{-- BẢNG THÔNG TIN KHÁCH HÀNG --}}
                    <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-6 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-user text-lg"></i>
                            </div>
                            <h5 class="text-base font-bold text-slate-800">Thông tin Khách hàng</h5>
                        </div>

                        <ul class="space-y-4">
                            <li class="flex items-start justify-between border-b border-slate-100 pb-3">
                                <span class="text-sm font-medium text-slate-500">Họ & Tên</span>
                                <span class="text-sm font-bold text-slate-800">{{ $order->name }}</span>
                            </li>
                            <li class="flex items-start justify-between border-b border-slate-100 pb-3">
                                <span class="text-sm font-medium text-slate-500">Số Điện thoại</span>
                                <span class="text-sm font-bold text-blue-600 font-mono">{{ $order->phone }}</span>
                            </li>
                            <li class="flex items-start justify-between border-b border-slate-100 pb-3">
                                <span class="text-sm font-medium text-slate-500">Email LH</span>
                                <span class="text-sm font-bold text-slate-800">{{ $order->email }}</span>
                            </li>
                            <li class="flex items-start justify-between border-b border-slate-100 pb-3">
                                <span class="text-sm font-medium text-slate-500">Số lượng đặt</span>
                                <span class="text-sm font-bold text-amber-600 px-3 py-1 bg-amber-50 rounded-lg border border-amber-100">{{ $order->quantity }} Chỗ</span>
                            </li>
                            <li class="flex items-start justify-between pt-1">
                                <span class="text-sm font-bold text-slate-500">Tổng thanh toán</span>
                                <span class="text-lg font-bold text-emerald-600">{{ number_format($order->total_price) }} ₫</span>
                            </li>
                            @if($order->note)
                                <li class="flex flex-col border-t border-slate-100 pt-3 mt-2">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Phương tiện & Ghi chú</span>
                                    <div class="text-xs font-semibold text-slate-700 bg-white p-3 rounded-xl border border-slate-200 leading-relaxed shadow-sm">
                                        {{ $order->note }}
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>

                    {{-- BẢNG THÔNG TIN TOUR --}}
                    <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-6 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-route text-lg"></i>
                            </div>
                            <h5 class="text-base font-bold text-slate-800">Thông tin Quy trình Tour</h5>
                        </div>

                        <ul class="space-y-4">
                            <li class="flex flex-col border-b border-slate-100 pb-3">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5 opacity-80">Chương trình Tour</span>
                                <span class="text-sm font-bold text-teal-700 leading-tight">{{ $order->tour->name }}</span>
                            </li>
                            <li class="flex items-start gap-4 border-b border-slate-100 pb-3">
                                <div class="flex-1">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5 opacity-80 block">Điểm đi</span>
                                    <span class="text-sm font-bold text-slate-800 inline-flex items-center gap-1.5"><i class="fa-solid fa-location-dot text-slate-300"></i> {{ $order->tour->start_location }}</span>
                                </div>
                                <div class="flex items-center pt-5">
                                    <i class="fa-solid fa-arrow-right text-slate-300 text-sm"></i>
                                </div>
                                <div class="flex-1 text-right">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5 opacity-80 block">Điểm đến</span>
                                    <span class="text-sm font-bold text-slate-800 inline-flex items-center gap-1.5">{{ $order->tour->end_location }} <i class="fa-solid fa-location-dot text-rose-300"></i></span>
                                </div>
                            </li>
                            <li class="grid grid-cols-2 gap-4 pt-1">
                                <div>
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5 opacity-80 block">Khởi hành</span>
                                    <span class="text-sm font-bold text-slate-800 bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm inline-block"><i class="fa-regular fa-calendar text-blue-500 mr-1.5"></i>{{ \Carbon\Carbon::parse($order->tour->start_date)->format('d/m/Y') }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5 opacity-80 block">Thời lượng</span>
                                    <span class="text-sm font-bold text-slate-800 bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm inline-block w-full text-center">{{ $order->tour->time }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
                
                <hr class="border-slate-100">

                {{-- CẬP NHẬT TRẠNG THÁI --}}
                <div class="bg-amber-50/50 border border-amber-100 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-toggle-on text-lg"></i>
                        </div>
                        <h5 class="text-base font-bold text-slate-800">Trạng thái Xử lý Hệ thống</h5>
                    </div>

                    <div>
                        <label class="block text-slate-600 font-semibold mb-2">Đổi trạng thái đơn hàng: <span class="text-rose-500">*</span></label>
                        <div class="relative max-w-lg">
                            <i class="fa-solid fa-shield-halved absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 z-10 w-5"></i>
                            <select name="status" class="w-full bg-white border-2 border-slate-200 rounded-xl pl-12 pr-4 py-3.5 text-slate-800 font-bold focus:outline-none focus:ring-4 focus:ring-amber-500/10 focus:border-amber-400 appearance-none transition-all duration-300 cursor-pointer shadow-sm relative z-0">
                                <option value="0" @selected($order->status == 0)>⏳ Đang chờ hệ thống & KH duyệt</option>
                                <option value="1" @selected($order->status == 1)>💰 Đã thanh toán tiền đặt cọc</option>
                                <option value="2" @selected($order->status == 2)>✅ Khách hàng đã thanh toán 100%</option>
                                <option value="3" @selected($order->status == 3)>🎉 Lịch trình Tour đã hoàn tất</option>
                                <option value="4" @selected($order->status == 4)>⛔ Hủy đơn (Chưa phát sinh thanh toán)</option>
                                <option value="5" @selected($order->status == 5)>🔄 Đã hoàn tiền cọc / hủy lịch</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs z-10"></i>
                        </div>
                        
                        @error('status')
                            <p class="text-rose-500 text-xs font-bold mt-2"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- SUBMIT --}}
                <div class="flex flex-col sm:flex-row justify-end pt-2">
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex justify-center items-center gap-2 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white px-10 py-4 rounded-xl font-bold shadow-lg shadow-orange-200/50 hover:shadow-xl hover:shadow-orange-300/50 hover:-translate-y-0.5 transition-all duration-300 text-sm">
                        <i class="fa-solid fa-floppy-disk text-lg"></i> Cập nhật ngay
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
