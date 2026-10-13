@extends('users.master')

@section('home')
<style>
    .bg-main {
        background-color: #f8fafc;
        background-image: 
            radial-gradient(at 0% 0%, hsla(160, 100%, 75%, 0.15) 0px, transparent 50%),
            radial-gradient(at 100% 0%, hsla(190, 100%, 75%, 0.15) 0px, transparent 50%);
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
</style>

<div class="relative pt-32 pb-24 min-h-screen bg-main font-sans">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- HEADER & STEPPER COMPACT -->
        <div class="flex flex-col md:flex-row items-center justify-between mb-12 gap-6 bg-white/60 backdrop-blur-xl p-6 rounded-[2rem] shadow-sm border border-white">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Thanh toán đặt cọc</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Bảo mật giao dịch bằng mã hoá SSL 256-bit an toàn.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-xs"><i class="fa-solid fa-check"></i></div>
                </div>
                <div class="w-12 h-1 bg-orange-200 rounded-full"></div>
                <div class="flex flex-col items-center relative">
                    <div class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-xs shadow-lg shadow-orange-500/40 ring-4 ring-orange-50"><i class="fa-solid fa-2"></i></div>
                </div>
                <div class="w-12 h-1 bg-slate-200 rounded-full"></div>
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 border border-slate-200 flex items-center justify-center font-bold text-xs"><i class="fa-solid fa-3 hidden"></i><i class="fa-solid fa-check hidden"></i>3</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT: PAYMENT OPTIONS (GRID LAYOUT) -->
            <div class="lg:col-span-7">
                <h2 class="text-xl font-extrabold text-slate-800 mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-wallet text-orange-500"></i> Chọn phương thức giao dịch
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
                                <i class="fa-solid fa-store text-3xl"></i>
                            </div>
                            
                            <div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-800">Tại quầy</h3>
                                <p class="text-[11px] text-slate-500 font-medium mt-0.5">Nộp tiền trực tiếp</p>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- DYNAMIC ACTION BUTTON AREA -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-bl-full pointer-events-none"></div>
                    <p class="text-sm font-bold text-slate-800 mb-4 relative z-10">Tiến hành thanh toán</p>
                    
                    <!-- MoMo Button -->
                    <form action="{{ route('momo.deposit', $order->id) }}" method="POST" id="form-momo" class="relative z-10 w-full">
                        @csrf
                        <button type="submit" class="w-full bg-gradient-to-r from-[#A50064] to-[#C8107A] text-white py-4 px-6 rounded-2xl font-extrabold text-base hover:brightness-110 hover:-translate-y-1 transition-all duration-300 shadow-xl shadow-pink-500/20 flex items-center justify-center gap-3">
                            <i class="fa-solid fa-qrcode text-lg"></i> Thanh toán bằng MoMo ({{ number_format($deposit_amount) }}đ)
                        </button>
                    </form>

                    <!-- PayPal Button -->
                    <form action="{{ route('paypal.create', $order->id) }}" method="POST" id="form-paypal" class="hidden relative z-10 w-full">
                        @csrf
                        <button type="submit" class="w-full bg-gradient-to-r from-[#0070BA] to-[#003087] text-white py-4 px-6 rounded-2xl font-extrabold text-base hover:brightness-110 hover:-translate-y-1 transition-all duration-300 shadow-xl shadow-blue-500/20 flex items-center justify-center gap-3">
                            <i class="fa-brands fa-paypal text-xl"></i> Thanh toán bằng PayPal (~${{ number_format(round($deposit_amount / 24000, 2), 2) }} USD)
                        </button>
                        <p class="text-center text-[11px] text-slate-500 mt-3 flex items-center justify-center gap-1.5 font-medium">
                            <i class="fa-solid fa-shield-halved text-blue-500"></i> Hỗ trợ số dư PayPal và thẻ Visa/Mastercard quốc tế.
                        </p>
                    </form>

                    <!-- Direct/Cash Button -->
                    <div id="wrapper-cash" class="hidden relative z-10 w-full">
                        <a href="{{ route('tour.thankyou', $order->id) }}?method=cash" 
                           class="block w-full bg-gradient-to-r from-orange-500 via-rose-500 to-amber-500 hover:from-orange-600 hover:to-rose-600 text-white py-4 px-6 rounded-2xl font-extrabold text-base text-center hover:-translate-y-1 transition-all duration-300 shadow-xl shadow-orange-500/20">
                            <i class="fa-solid fa-check-to-slot mr-2"></i> Xác nhận & Thanh toán tại văn phòng
                        </a>
                        <p class="text-center text-[11px] text-slate-500 mt-3 flex items-center justify-center gap-1.5 font-medium">
                            <i class="fa-solid fa-circle-info text-amber-500"></i> Giữ chỗ sẽ được kích hoạt tức thì.
                        </p>
                    </div>
                </div>
            </div>

            <!-- RIGHT: SUMMARY PANEL -->
            <div class="lg:col-span-5 relative">
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
                        <h4 class="text-lg font-bold text-slate-800 leading-snug mb-4">{{ $tour->name }}</h4>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <i class="fa-regular fa-calendar-check text-orange-500 mb-1 block"></i>
                                <p class="text-[10px] text-slate-400 font-semibold mb-0.5 uppercase">Khởi hành</p>
                                <p class="text-xs font-bold text-slate-800">{{ \Carbon\Carbon::parse($customer['time'])->format('d/m/Y') }}</p>
                            </div>
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <i class="fa-solid fa-user-group text-orange-500 mb-1 block"></i>
                                <p class="text-[10px] text-slate-400 font-semibold mb-0.5 uppercase">Số lượng</p>
                                <p class="text-xs font-bold text-slate-800">{{ $customer['quantity'] }} Ghế</p>
                            </div>
                        </div>
                    </div>

                    <!-- Money Section -->
                    <div class="bg-slate-50 rounded-2xl p-5 mb-6 border border-slate-100">
                        <div class="flex justify-between items-center text-sm font-semibold text-slate-500 mb-3">
                            <span>Tổng giá trị Tour</span>
                            <span class="text-slate-800 font-bold">{{ number_format($total_price) }}₫</span>
                        </div>

                        @if (!empty($voucher))
                            <div class="flex justify-between items-center text-[13px] font-bold text-orange-600 mb-3">
                                <span>Mã giảm giá ({{ $voucher['code'] }})</span>
                                <span>-{{ number_format($discount) }}₫</span>
                            </div>
                        @else
                            <div class="flex justify-between items-center text-[13px] font-bold text-slate-400 mb-3">
                                <span>Giảm giá/Khuyến mãi</span>
                                <span>0₫</span>
                            </div>
                        @endif
                        
                        <div class="border-t border-slate-200 border-dashed pt-4 mt-1">
                            <div class="flex justify-between items-end">
                                <div>
                                    <span class="text-[10px] font-bold bg-orange-100 text-orange-700 px-2 py-1 rounded uppercase tracking-wider">Thanh toán cọc 30%</span>
                                </div>
                                <span class="text-2xl font-bold text-orange-600">{{ number_format($deposit_amount) }}₫</span>
                            </div>
                        </div>
                    </div>

                    <p class="text-[10px] text-slate-400 font-medium text-center italic">
                        Khoản còn lại (70%) sẽ thu tiền lúc lên xe / hướng dẫn viên thu.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
