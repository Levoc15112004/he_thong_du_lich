@extends('users.master')

@section('home')
    <div class="relative py-8 pt-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            @if (session('error'))
                <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif
            {{-- Header --}}
            <div class="flex items-center justify-between mb-10">
                <h1 class="text-xl font-bold text-slate-900 flex items-center gap-4">
                    <span class="p-3 bg-blue-600 text-white rounded-2xl shadow-lg shadow-blue-200">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </span>
                    Giỏ hàng của bạn
                </h1>
                <a href="{{ route('user.home') }}"
                    class="text-blue-600 font-semibold hover:text-blue-700 flex items-center gap-2 transition">
                    <i class="fa-solid fa-arrow-left"></i> Tiếp tục chọn Tour
                </a>
            </div>

            @php
                $items = $cart->getItems();
                $discount = $discount ?? 0;
                $finalTotal = $finalTotal ?? $totalPrice;

            @endphp

            @if ($items && count($items) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                    {{-- LEFT COLUMN: Tour List --}}
                    <div class="lg:col-span-2 space-y-2">
                        @foreach ($items as $key => $item)
                            <div
                                class="bg-white rounded-3xl p-4 shadow-sm border border-slate-100 flex flex-col md:flex-row gap-6 hover:shadow-md transition duration-300">
                                {{-- Tour Image --}}
                                <div class="relative shrink-0">
                                    <img src="{{ asset($item['image'] ?? 'images/default-tour.jpg') }}"
                                        class="w-full md:w-48 h-40 rounded-2xl object-cover shadow-sm">
                                    <span
                                        class="absolute top-2 left-2 bg-white/90 backdrop-blur px-2 py-1 rounded-lg text-[10px] font-bold text-blue-600 uppercase">
                                        {{ $item['tour_type'] }}
                                    </span>
                                </div>

                                {{-- Tour Info --}}
                                <div class="flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-lg font-bold text-slate-800 leading-tight">
                                                {{ $item['tour_name'] }}
                                            </h3>
                                            <form action="{{ route('user.cart.remove', $key) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-slate-300 hover:text-red-500 transition-colors p-2">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <div class="flex flex-wrap gap-4 mt-3 text-xs text-slate-500">
                                            <span class="flex items-center gap-1">
                                                <i class="fa-solid fa-calendar-day text-blue-500"></i>
                                                {{ \Carbon\Carbon::parse($item['start_date'])->format('d/m/Y') }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <i class="fa-solid fa-plane text-blue-500"></i>
                                                {{ $item['transport'] }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Quantity & Price --}}
                                    <div class="flex flex-wrap items-center justify-between mt-6 pt-4 border-t border-slate-50 gap-4">
                                        <form action="{{ route('user.cart.update', $key) }}" method="POST"
                                            class="flex items-center bg-slate-100 rounded-xl p-1">
                                            @csrf
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                                min="1"
                                                class="w-12 bg-transparent text-sm text-center font-bold text-slate-800 focus:outline-none">
                                            <button
                                                class="bg-white text-blue-600 px-3 py-1 rounded-lg shadow-sm hover:bg-blue-600 hover:text-white transition font-bold text-xs uppercase">
                                                Cập nhật
                                            </button>
                                        </form>

                                        <div class="text-right">
                                            <p class="text-sm text-slate-400 font-medium">Đơn giá:
                                                {{ number_format($item['price'], 0, '.', '.') }}đ</p>
                                            <p class="text-2xl font-bold text-blue-600">
                                                {{ number_format($item['price'] * $item['quantity'], 0, '.', '.') }}đ
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- RIGHT COLUMN: Summary & Vouchers (Sticky) --}}
                    <div class="space-y-6 lg:sticky lg:top-10">

                        {{-- Voucher --}}
                        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">

                            <h2 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-ticket text-orange-500"></i>
                                Mã giảm giá của bạn
                            </h2>


                            {{-- nhập mã --}}
                            <form action="{{ route('user.cart.applyVoucher') }}" method="POST" class="flex gap-2 mb-6">
                                @csrf

                                <input type="text" name="voucher_code" id="voucher_input"
                                    value="{{ $voucher->code ?? (session('voucher.code') ?? '') }}"
                                    placeholder="Nhập mã hoặc chọn bên dưới"
                                    class="flex-1 bg-slate-50 border text-xs border-slate-200 rounded-xl px-3 py-1">

                                <button class="bg-slate-900 text-white px-3 py-1 rounded-xl font-bold">
                                    Áp dụng
                                </button>

                            </form>


                            {{-- list voucher --}}
                            <div class="space-y-3 max-h-60 overflow-y-auto pr-2 custom-scrollbar">

                                @forelse($userVouchers as $v)
                                    <div onclick="applyVoucher('{{ $v->code }}')"
                                        class="cursor-pointer p-3 rounded-2xl border-2
                                        {{ ($voucher->code ?? '') == $v->code
                                            ? 'border-blue-500 bg-blue-50'
                                            : 'border-dashed border-slate-200 hover:border-blue-300' }}
                                        ">


                                        <p class="text-xs font-bold text-blue-600">
                                            {{ $v->code }}
                                        </p>

                                        <p class="font-bold">
                                            {{ $v->name }}
                                        </p>


                                        {{-- giảm --}}
                                        <p class="font-bold text-slate-800">

                                            @if ($v->discount_type == 'percent')
                                                Giảm {{ $v->discount_value }} %

                                                @if ($v->max_discount)
                                                    (tối đa {{ number_format($v->max_discount, 0, '.', '.') }}đ)
                                                @endif
                                            @else
                                                Giảm
                                                {{ number_format($v->discount_value, 0, '.', '.') }}đ
                                            @endif

                                        </p>


                                        @if ($v->min_order_value)
                                            <p class="text-xs text-slate-500">
                                                Đơn tối thiểu
                                                {{ number_format($v->min_order_value, 0, '.', '.') }}đ
                                            </p>
                                        @endif


                                        @if ($v->end_date)
                                            <p class="text-xs text-red-500">
                                                HSD: {{ $v->end_date->format('d/m/Y') }}

                                                @if ($v->days_left !== null)
                                                    ({{ $v->days_left }} ngày)
                                                @endif

                                            </p>
                                        @endif

                                    </div>

                                @empty

                                    <div class="text-center text-slate-400  text-sm">
                                        Bạn chưa có voucher
                                    </div>
                                @endforelse

                            </div>

                        </div>



                        {{-- Summary --}}
                        <div class="bg-white rounded-3xl p-8 shadow border">

                            <h2 class="text-xl font-bold mb-4">
                                Chi tiết thanh toán
                            </h2>


                            <div class="flex text-sm justify-between">
                                <span>Tạm tính</span>
                                <span>{{ number_format($totalPrice, 0, '.', '.') }}đ</span>
                            </div>



                            {{-- voucher --}}
                            @if (!empty($voucher))
                                <div class="flex justify-between text-green-600 font-bold mt-2">

                                    <span>

                                        {{ $voucher['code'] ?? '' }}

                                        @if (($voucher['discount_type'] ?? '') == 'percent')
                                            ({{ $voucher['discount_value'] }}%)
                                        @else
                                            ({{ number_format($voucher['discount_value'] ?? 0, 0, '.', '.') }}đ)
                                        @endif

                                    </span>

                                    <span>

                                        -{{ number_format($discount ?? 0, 0, '.', '.') }}đ

                                    </span>

                                </div>
                            @endif



                            <hr class="my-4">


                            <div class="flex justify-between items-end gap-2">
                                <span class="text-lg md:text-2xl font-bold r">{{ number_format($finalTotal, 0, '.', '.') }}đ</span>
                            </div>


                            <a href="{{ route('user.order.index') }}"
                                class="block mt-6 bg-blue-600 font-bold text-white text-center py-2 rounded-xl">

                                Thanh toán

                            </a>

                        </div>

                    </div>
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-24 bg-white rounded-[3rem] border border-dashed border-slate-200 shadow-sm">
                    <div class="w-32 h-32 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-cart-arrow-down text-slate-200 text-5xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800 mb-2">Giỏ hàng đang trống</h2>
                    <p class="text-slate-400 mb-8 max-w-xs mx-auto text-base font-medium">
                        Có vẻ như bạn chưa chọn được tour nào ưng ý. Hãy khám phá các tour du lịch hấp dẫn của chúng tôi!
                    </p>
                    <a href="{{ route('user.home') }}"
                        class="inline-block bg-blue-600 text-white px-10 py-4 rounded-2xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                        Khám phá Tour ngay
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>


    <script>
        let selectedVoucher = "{{ $voucher['code'] ?? '' }}";

        function applyVoucher(code) {

            let input = document.getElementById('voucher_input');

            // click lại voucher đang chọn → bỏ
            if (selectedVoucher === code) {

                input.value = "";
                selectedVoucher = "";

            } else {

                input.value = code;
                selectedVoucher = code;

            }

            input.form.submit();
        }
    </script>
@endsection
