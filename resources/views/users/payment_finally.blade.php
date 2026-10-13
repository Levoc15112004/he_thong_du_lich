@extends('users.master')

@section('home')
<style>
    .bg-main {
        background-color: #f8fafc;
        background-image: 
            radial-gradient(at 100% 100%, hsla(160, 100%, 75%, 0.15) 0px, transparent 50%),
            radial-gradient(at 0% 100%, hsla(190, 100%, 75%, 0.15) 0px, transparent 50%);
    }

    /* Option Card Styling */
    .payment-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .payment-option input:checked + .payment-card {
        border-color: #f97316; /* orange-500 */
        background-color: #ffffff;
        box-shadow: 0 20px 40px -10px rgba(249, 115, 22, 0.2);
        transform: translateY(-5px);
    }

    .payment-option input:checked + .payment-card .card-ring {
        opacity: 1;
        transform: scale(1);
    }

    .payment-option input:not(:checked) + .payment-card {
        filter: grayscale(0.5);
        opacity: 0.8;
    }
    .payment-option input:not(:checked):hover + .payment-card {
        filter: grayscale(0);
        opacity: 1;
        transform: translateY(-2px);
    }

    .card-ring {
        opacity: 0;
        transform: scale(0.5);
        transition: all 0.3s ease;
    }

    /* Summary Panel */
    .summary-panel {
        background: white;
        border-radius: 2rem;
        box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05);
    }

    /* Strikethrough for paid amount */
    .strikethrough-anim {
        position: relative;
        display: inline-block;
    }
    .strikethrough-anim::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        width: 0%;
        height: 2px;
        background-color: #f43f5e;
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .strikethrough-anim.animate::before {
        width: 100%;
    }
</style>

<div class="relative pt-32 pb-24 min-h-screen bg-main font-sans">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- HEADER BANNER -->
        <div class="bg-gradient-to-r from-orange-500 via-rose-500 to-amber-500 rounded-[2.5rem] p-8 sm:p-12 mb-12 text-center text-white shadow-xl shadow-orange-500/20 relative overflow-hidden">
            <!-- Decorative Blobs -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-white rounded-full blur-2xl"></div>
                <div class="absolute -bottom-10 -right-10 w-56 h-56 bg-rose-300 rounded-full blur-2xl"></div>
            </div>

            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md text-white border border-white/30 px-5 py-2 rounded-full mb-6 font-bold text-xs uppercase tracking-wider shadow-sm">
                <i class="fa-solid fa-flag-checkered"></i>
                Hoàn tất bước cuối cùng
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-bold tracking-tight mb-4 drop-shadow-md relative z-10">
                Thanh toán <span class="text-yellow-300">70% còn lại</span>
            </h1>
            <p class="text-orange-50 text-sm sm:text-base font-medium max-w-lg mx-auto relative z-10 leading-relaxed">
                Vui lòng hoàn tất giao dịch để chúng tôi xuất vé điện tử chính thức và chốt hành trình của bạn.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start flex-col-reverse lg:flex-row">
            
            <!-- LEFT: SUMMARY PANEL -->
            <div class="lg:col-span-5 relative order-2 lg:order-1">
                <div class="summary-panel p-8 sticky top-28">
                    <!-- Ticket Header -->
                    <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-100 border-dashed">
                        <div>
                            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-1">Mã Phiếu Đặt</p>
                            <p class="text-xl font-bold text-slate-800">#TVG-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 border border-slate-100">
                            <i class="fa-solid fa-barcode text-2xl"></i>
                        </div>
                    </div>

                    <!-- Tour Info -->
                    <div class="mb-8">
                        <div class="flex gap-4">
                            <img src="{{ asset($tour->image) }}" class="w-16 h-16 rounded-xl object-cover shrink-0 border border-slate-100 shadow-sm">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800 leading-snug mb-2 line-clamp-2">{{ $tour->name }}</h4>
                                <p class="text-[11px] font-bold text-slate-500"><i class="fa-regular fa-calendar text-orange-500 mr-1"></i> Khởi hành: {{ $tour->start_date->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Money Section -->
                    <div class="bg-slate-50 rounded-2xl p-5 mb-6 border border-slate-100">
                        <div class="flex justify-between items-center text-[13px] font-semibold text-slate-500 mb-4">
                            <span>Tổng giá vé Tour</span>
                            <span class="text-slate-800 font-bold">{{ number_format($total_price, 0, ',', '.') }}đ</span>
                        </div>

                        <!-- Đã thanh toán -->
                        <div class="flex justify-between items-center text-[13px] font-bold text-rose-500 bg-rose-50/50 p-2.5 rounded-xl border border-rose-100 mb-3">
                            <div class="flex items-center gap-2 text-rose-600">
                                <i class="fa-solid fa-check-circle"></i>
                                <span>Đã thanh toán (30%)</span>
                            </div>
                            <span id="strikethrough-text" class="strikethrough-anim text-rose-600">
                                -{{ number_format($deposit_amount, 0, ',', '.') }}đ
                            </span>
                        </div>

                        @if ($order->discount_amount > 0)
                            <div class="flex justify-between items-center text-[13px] font-bold text-orange-600 bg-orange-50/50 p-2.5 rounded-xl border border-orange-100 mb-3">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-tag"></i>
                                    <span>Mã giảm giá áp dụng</span>
                                </div>
                                <span>-{{ number_format($order->discount_amount, 0, ',', '.') }}đ</span>
                            </div>
                        @else
                            <div class="flex justify-between items-center text-[13px] font-bold text-slate-400 mb-3 px-2">
                                <span>Voucher giảm giá</span>
                                <span>0đ</span>
                            </div>
                        @endif
                        
                        <div class="border-t border-slate-200 border-dashed pt-4 mt-2">
                            <div class="flex flex-col text-right">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Thanh toán nốt (70%)</span>
                                <span class="text-3xl font-bold text-orange-600 drop-shadow-sm">{{ number_format($remain_amount, 0, ',', '.') }}đ</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3 bg-blue-50/50 p-4 rounded-xl border border-blue-100/50">
                        <i class="fa-solid fa-shield-halved text-blue-500 text-lg mt-0.5"></i>
                        <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                            Bằng cách xác nhận thanh toán, bạn đồng ý với <a href="#" class="text-blue-600 font-bold underline decoration-blue-300 underline-offset-2">Quy định & điều khoản</a> của TravelGo.
                        </p>
                    </div>
                </div>
            </div>

            <!-- RIGHT: MAIN OPTIONS -->
            <div class="lg:col-span-7 order-1 lg:order-2">
                <h2 class="text-xl font-extrabold text-slate-800 mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-wallet text-orange-500"></i> Phương thức thanh toán 
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-10">
                    
                    <!-- MOMO BLOCK -->
                    <label class="payment-option cursor-pointer block h-full">
                        <input type="radio" id="payment_momo" name="payment_method" value="momo" class="hidden" checked>
                        <div class="payment-card h-full relative bg-white/80 backdrop-blur-sm border-2 border-slate-200/60 rounded-3xl p-5 flex flex-col items-center justify-center text-center gap-3 overflow-hidden">
                            <!-- Selected Ring -->
                            <div class="card-ring absolute top-4 right-4 w-6 h-6 rounded-full bg-orange-500 text-white flex items-center justify-center shadow-md">
                                <i class="fa-solid fa-check text-[10px]"></i>
                            </div>
                            
                            <div class="w-16 h-16 bg-[#A50064]/10 rounded-2xl flex items-center justify-center p-2 mb-1 shadow-sm">
                                <img src="{{ asset('fontend/img/momo.svg') }}" class="w-full h-full object-contain" alt="Ví MoMo">
                            </div>
                            
                            <div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-800">Ví MoMo</h3>
                                <p class="text-[11px] text-slate-500 font-medium mt-0.5">Quét mã QR siêu tốc</p>
                            </div>
                        </div>
                    </label>

                    <!-- PAYPAL BLOCK -->
                    <label class="payment-option cursor-pointer block h-full">
                        <input type="radio" id="payment_paypal" name="payment_method" value="paypal" class="hidden">
                        <div class="payment-card h-full relative bg-white/80 backdrop-blur-sm border-2 border-slate-200/60 rounded-3xl p-5 flex flex-col items-center justify-center text-center gap-3 overflow-hidden">
                            <!-- Selected Ring -->
                            <div class="card-ring absolute top-4 right-4 w-6 h-6 rounded-full bg-orange-500 text-white flex items-center justify-center shadow-md">
                                <i class="fa-solid fa-check text-[10px]"></i>
                            </div>
                            
                            <div class="w-16 h-16 bg-[#003087]/10 rounded-2xl flex items-center justify-center p-2 mb-1 shadow-sm text-[#003087]">
                                <i class="fa-brands fa-paypal text-3xl"></i>
                            </div>
                            
                            <div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-800">Cổng PayPal</h3>
                                <p class="text-[11px] text-slate-500 font-medium mt-0.5">Thẻ Visa/Mastercard</p>
                            </div>
                        </div>
                    </label>

                    <!-- DIRECT/CASH BLOCK -->
                    <label class="payment-option cursor-pointer block h-full">
                        <input type="radio" id="payment_cash" name="payment_method" value="cash" class="hidden">
                        <div class="payment-card h-full relative bg-white/80 backdrop-blur-sm border-2 border-slate-200/60 rounded-3xl p-5 flex flex-col items-center justify-center text-center gap-3 overflow-hidden">
                            <!-- Selected Ring -->
                            <div class="card-ring absolute top-4 right-4 w-6 h-6 rounded-full bg-orange-500 text-white flex items-center justify-center shadow-md">
                                <i class="fa-solid fa-check text-[10px]"></i>
                            </div>
                            
                            <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center p-2 mb-1 text-orange-500 shadow-sm">
                                <i class="fa-solid fa-building-columns text-3xl"></i>
                            </div>
                            
                            <div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-800">Tại quầy</h3>
                                <p class="text-[11px] text-slate-500 font-medium mt-0.5">Trực tiếp với HDV</p>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- DYNAMIC ACTION BUTTON AREA -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-bl-full pointer-events-none"></div>
                    <p class="text-sm font-bold text-slate-800 mb-4 relative z-10">Bấm xác nhận để hoàn tất</p>
                    
                    <!-- MoMo Button -->
                    <form method="POST" action="{{ route('momo.final', $order->id) }}" id="form-momo" class="relative z-10 w-full">
                        @csrf
                        <button type="submit" class="w-full bg-gradient-to-r from-[#A50064] to-[#C8107A] text-white py-4 px-6 rounded-2xl font-extrabold text-base hover:brightness-110 hover:-translate-y-1 transition-all duration-300 shadow-xl shadow-pink-500/20 flex items-center justify-center gap-3">
                            <i class="fa-solid fa-qrcode text-lg"></i> Thanh toán dư nợ bằng MoMo ({{ number_format($remain_amount) }}đ)
                        </button>
                    </form>

                    <!-- PayPal Button -->
                    <form action="{{ route('paypal.createFinal', $order->id) }}" method="POST" id="form-paypal" class="hidden relative z-10 w-full">
                        @csrf
                        <button type="submit" class="w-full bg-gradient-to-r from-[#0070BA] to-[#003087] text-white py-4 px-6 rounded-2xl font-extrabold text-base hover:brightness-110 hover:-translate-y-1 transition-all duration-300 shadow-xl shadow-blue-500/20 flex items-center justify-center gap-3">
                            <i class="fa-brands fa-paypal text-xl"></i> Thanh toán dư nợ qua PayPal (~${{ number_format(round($remain_amount / 24000, 2), 2) }} USD)
                        </button>
                        <p class="text-center text-[11px] text-slate-500 mt-3 flex items-center justify-center gap-1.5 font-medium">
                            <i class="fa-solid fa-shield-halved text-blue-500"></i> Hỗ trợ số dư PayPal và thẻ tín dụng Visa/Mastercard quốc tế.
                        </p>
                    </form>

                    <!-- Direct/Cash Button -->
                    <div id="wrapper-cash" class="hidden relative z-10 w-full">
                        <a href="{{ route('tour.thankyou.final', $order->id) }}?method=cash" 
                           class="block w-full bg-gradient-to-r from-orange-500 via-rose-500 to-amber-500 hover:from-orange-600 hover:to-rose-600 text-white py-4 px-6 rounded-2xl font-extrabold text-base text-center hover:-translate-y-1 transition-all duration-300 shadow-xl shadow-orange-500/20">
                            <i class="fa-solid fa-check-double mr-2"></i> Xác nhận thanh toán trực tiếp
                        </a>
                        <p class="text-center text-[11px] text-slate-500 mt-3 flex items-center justify-center gap-1.5 font-medium">
                            <i class="fa-solid fa-circle-info text-orange-500"></i> Mã Code vé sẽ được xác nhận khi thu đủ tiền.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Init strikethrough animation
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            const strikeText = document.getElementById('strikethrough-text');
            if (strikeText) strikeText.classList.add('animate');
        }, 800);
    });

    const momoRadio = document.getElementById('payment_momo');
    const paypalRadio = document.getElementById('payment_paypal');
    const cashRadio = document.getElementById('payment_cash');

    const momoForm = document.getElementById('form-momo');
    const paypalForm = document.getElementById('form-paypal');
    const cashWrapper = document.getElementById('wrapper-cash');

    function togglePaymentButtons() {
        if (momoRadio && momoRadio.checked) {
            momoForm.classList.remove('hidden');
            if (paypalForm) paypalForm.classList.add('hidden');
            cashWrapper.classList.add('hidden');
        } else if (paypalRadio && paypalRadio.checked) {
            momoForm.classList.add('hidden');
            if (paypalForm) paypalForm.classList.remove('hidden');
            cashWrapper.classList.add('hidden');
        } else {
            momoForm.classList.add('hidden');
            if (paypalForm) paypalForm.classList.add('hidden');
            cashWrapper.classList.remove('hidden');
        }
    }

    if (momoRadio) momoRadio.addEventListener('change', togglePaymentButtons);
    if (paypalRadio) paypalRadio.addEventListener('change', togglePaymentButtons);
    if (cashRadio) cashRadio.addEventListener('change', togglePaymentButtons);

    // Initial check
    togglePaymentButtons();
</script>
@endsection
