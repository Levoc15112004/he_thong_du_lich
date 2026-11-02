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

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                    
                    <!-- 1. VIETQR BANK TRANSFER BLOCK (DEFAULT CHECKED) -->
                    <label class="payment-option cursor-pointer block h-full">
                        <input type="radio" id="payment_bank" name="payment_method" value="bank" class="hidden" checked>
                        <div class="payment-card h-full relative bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border-2 border-slate-200 dark:border-slate-700 rounded-2xl p-4 flex flex-col items-center justify-center text-center gap-2.5 overflow-hidden">
                            <div class="card-ring absolute top-3 right-3 w-5 h-5 rounded-full bg-[#863c20] text-white flex items-center justify-center shadow-xs">
                                <i class="fa-solid fa-check text-[9px]"></i>
                            </div>
                            <div class="w-14 h-14 bg-emerald-50 dark:bg-emerald-950/60 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-2xl shadow-sm">
                                <i class="fa-solid fa-qrcode"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800 dark:text-white">Chuyển Khoản QR</h3>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Quét VietQR mọi ngân hàng</p>
                            </div>
                        </div>
                    </label>

                    <!-- 2. MOMO BLOCK -->
                    <label class="payment-option cursor-pointer block h-full">
                        <input type="radio" id="payment_momo" name="payment_method" value="momo" class="hidden">
                        <div class="payment-card h-full relative bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border-2 border-slate-200 dark:border-slate-700 rounded-2xl p-4 flex flex-col items-center justify-center text-center gap-2.5 overflow-hidden">
                            <div class="card-ring absolute top-3 right-3 w-5 h-5 rounded-full bg-[#863c20] text-white flex items-center justify-center shadow-xs">
                                <i class="fa-solid fa-check text-[9px]"></i>
                            </div>
                            <div class="w-14 h-14 bg-[#A50064]/10 rounded-xl flex items-center justify-center p-2 shadow-sm">
                                <img src="{{ asset('fontend/img/momo.svg') }}" class="w-full h-full object-contain" alt="Ví MoMo">
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800 dark:text-white">Ví MoMo</h3>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Quét mã qua app MoMo</p>
                            </div>
                        </div>
                    </label>

                    <!-- 3. DIRECT/CASH BLOCK -->
                    <label class="payment-option cursor-pointer block h-full">
                        <input type="radio" id="payment_cash" name="payment_method" value="cash" class="hidden">
                        <div class="payment-card h-full relative bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border-2 border-slate-200 dark:border-slate-700 rounded-2xl p-4 flex flex-col items-center justify-center text-center gap-2.5 overflow-hidden">
                            <div class="card-ring absolute top-3 right-3 w-5 h-5 rounded-full bg-[#863c20] text-white flex items-center justify-center shadow-xs">
                                <i class="fa-solid fa-check text-[9px]"></i>
                            </div>
                            <div class="w-14 h-14 bg-amber-50 dark:bg-amber-950/60 rounded-xl flex items-center justify-center text-[#863c20] text-2xl shadow-sm">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800 dark:text-white">Tại văn phòng</h3>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Nộp tiền mặt tại quầy</p>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- DYNAMIC ACTION BUTTON AREA -->
                <div class="bg-white dark:bg-slate-800/90 p-6 sm:p-7 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm relative overflow-hidden">
                    <p class="text-xs sm:text-sm font-bold text-slate-800 dark:text-white mb-4">Chi tiết thanh toán đã chọn</p>
                    
                    <!-- 1. MoMo Button -->
                    <form action="{{ route('momo.deposit', $order->id) }}" method="POST" id="form-momo" class="relative z-10 w-full">
                        @csrf
                        <button type="submit" class="w-full bg-[#A50064] hover:bg-[#850050] text-white py-3.5 px-6 rounded-xl font-bold text-sm transition-colors shadow-sm flex items-center justify-center gap-2.5">
                            <i class="fa-solid fa-qrcode text-base"></i> Thanh toán cọc qua Ví MoMo ({{ number_format($deposit_amount) }}đ)
                        </button>
                        <p class="text-center text-[11px] text-slate-500 dark:text-slate-400 mt-3">Quét mã QR MoMo để thanh toán cọc tức thì.</p>
                    </form>

                    <!-- 2. VietQR Bank Transfer Box -->
                    <div id="wrapper-bank" class="hidden relative z-10 w-full space-y-4">
                        @php
                            $bankId = config('services.vietqr.bank_id', env('VIETQR_BANK_ID', 'MB'));
                            $accountNo = config('services.vietqr.account_no', env('VIETQR_ACCOUNT_NO'));
                            $accountName = config('services.vietqr.account_name', env('VIETQR_ACCOUNT_NAME', 'CONG TY DU LICH WANDERLUST'));
                        @endphp
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row items-center gap-5">
                            <div class="w-36 h-36 bg-white p-2 rounded-xl shadow-xs border border-slate-200 shrink-0 flex items-center justify-center">
                                <img src="https://img.vietqr.io/image/{{ $bankId }}-{{ $accountNo }}-compact2.png?amount={{ (int)$deposit_amount }}&addInfo=WANDERLUST%20DH{{ $order->id }}&accountName={{ urlencode($accountName) }}" 
                                     class="w-full h-full object-contain" alt="VietQR {{ $bankId }}">
                            </div>
                            <div class="space-y-1.5 text-xs text-slate-700 dark:text-slate-300 w-full">
                                <p><span class="text-slate-400">Ngân hàng:</span> <strong class="text-slate-900 dark:text-white">{{ $bankId }} Bank</strong></p>
                                <p><span class="text-slate-400">Số tài khoản:</span> <strong class="text-slate-900 dark:text-white font-mono text-sm">{{ $accountNo }}</strong></p>
                                <p><span class="text-slate-400">Chủ tài khoản:</span> <strong class="text-slate-900 dark:text-white">{{ $accountName }}</strong></p>
                                <p><span class="text-slate-400">Số tiền cọc (30%):</span> <strong class="text-emerald-600 font-bold text-sm">{{ number_format($deposit_amount) }}đ</strong></p>
                                <p><span class="text-slate-400">Nội dung CK:</span> <strong class="text-[#863c20] font-mono font-bold">WANDERLUST DH{{ $order->id }}</strong></p>
                            </div>
                        </div>

                        <a href="{{ route('tour.thankyou', $order->id) }}?method=bank" 
                           class="block w-full bg-emerald-700 hover:bg-emerald-800 text-white py-3.5 px-6 rounded-xl font-bold text-sm text-center transition-colors shadow-xs">
                            <i class="fa-solid fa-check-circle mr-2"></i> Tôi đã chuyển khoản cọc thành công
                        </a>

                        <div class="pt-2 text-center">
                            <a href="{{ route('vietqr.test.pay', $order->id) }}" class="inline-flex items-center gap-1.5 text-xs text-emerald-700 dark:text-emerald-400 hover:underline font-semibold">
                                <i class="fa-solid fa-flask"></i> [Bấm vào đây để Test giả lập: Tiền đã về tài khoản]
                            </a>
                        </div>
                    </div>

                    <!-- 3. Direct/Cash Button -->
                    <div id="wrapper-cash" class="hidden relative z-10 w-full space-y-4">
                        <div class="p-4 rounded-xl bg-amber-50/70 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 text-xs text-amber-900 dark:text-amber-200 space-y-2">
                            <p class="font-bold text-sm text-[#863c20] dark:text-amber-400"><i class="fa-solid fa-location-dot mr-1.5"></i> Văn phòng giao dịch Wanderlust Travel:</p>
                            <p><strong>Địa chỉ:</strong> Tòa nhà Keangnam Landmark 72, Đường Phạm Hùng, Nam Từ Liêm, Hà Nội</p>
                            <p><strong>Giờ làm việc:</strong> 08:00 - 18:00 (Thứ 2 đến Thứ 7)</p>
                            <p><strong>Hotline:</strong> 1900 888 999 • Hotline tư vấn 24/7</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 pt-1 border-t border-amber-200 dark:border-amber-800/60">
                                <i>Lưu ý: Chỗ của Quý khách sẽ được tạm giữ trong 24 giờ để hoàn tất nộp tiền cọc tại văn phòng.</i>
                            </p>
                        </div>

                        <a href="{{ route('tour.thankyou', $order->id) }}?method=cash" 
                           class="block w-full bg-[#863c20] hover:bg-[#a34c2a] text-white py-3.5 px-6 rounded-xl font-bold text-sm text-center transition-colors shadow-xs">
                            <i class="fa-solid fa-check-to-slot mr-2"></i> Xác nhận giữ chỗ & Nộp cọc tại văn phòng
                        </a>
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
                                    <span class="text-[10px] font-bold bg-amber-100 text-[#863c20] px-2 py-1 rounded font-medium">Tiền cọc cần nộp (30%)</span>
                                </div>
                                <span class="text-2xl font-bold text-[#863c20]">{{ number_format($deposit_amount) }}₫</span>
                            </div>
                            <div class="flex justify-between items-center text-xs text-slate-500 mt-2">
                                <span>Trạng thái thanh toán:</span>
                                <span class="font-bold text-amber-600">Chờ nộp cọc (Chưa thanh toán)</span>
                            </div>
                        </div>
                    </div>

                    <p class="text-[10px] text-slate-400 font-medium text-center italic">
                        Khoản còn lại (70% ~ {{ number_format($total_price - $deposit_amount) }}₫) sẽ thanh toán khi khởi hành.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const momoRadio = document.getElementById('payment_momo');
    const bankRadio = document.getElementById('payment_bank');
    const cashRadio = document.getElementById('payment_cash');

    const momoForm = document.getElementById('form-momo');
    const bankWrapper = document.getElementById('wrapper-bank');
    const cashWrapper = document.getElementById('wrapper-cash');

    function togglePaymentButtons() {
        if (momoForm) momoForm.classList.add('hidden');
        if (bankWrapper) bankWrapper.classList.add('hidden');
        if (cashWrapper) cashWrapper.classList.add('hidden');

        if (momoRadio && momoRadio.checked) {
            if (momoForm) momoForm.classList.remove('hidden');
        } else if (bankRadio && bankRadio.checked) {
            if (bankWrapper) bankWrapper.classList.remove('hidden');
        } else if (cashRadio && cashRadio.checked) {
            if (cashWrapper) cashWrapper.classList.remove('hidden');
        }
    }

    if (momoRadio) momoRadio.addEventListener('change', togglePaymentButtons);
    if (bankRadio) bankRadio.addEventListener('change', togglePaymentButtons);
    if (cashRadio) cashRadio.addEventListener('change', togglePaymentButtons);

    // Initial check
    togglePaymentButtons();

    // ================= REALTIME POLLING KIỂM TRA TIỀN ĐÃ VỀ TÀI KHOẢN =================
    // Khi khách quét mã QR VietQR hoặc thanh toán MoMo, hệ thống tự động kiểm tra mỗi 3 giây
    let isRedirecting = false;
    const pollingInterval = setInterval(() => {
        if (isRedirecting) return;

        fetch('/api/order/check-status/{{ $order->id }}')
            .then(res => res.json())
            .then(data => {
                if (data.paid && !isRedirecting) {
                    isRedirecting = true;
                    clearInterval(pollingInterval);
                    
                    // Bật thông báo thành công
                    if (typeof showToast === 'function') {
                        showToast('Thanh toán cọc thành công! Tiền đã vào tài khoản.', 'success');
                    } else {
                        alert('Thanh toán cọc thành công! Tiền đã vào tài khoản và đơn tour của bạn đã được kích hoạt.');
                    }

                    setTimeout(() => {
                        window.location.href = data.redirect_url || '{{ route("tour.thankyou", $order->id) }}?method=bank';
                    }, 1200);
                }
            })
            .catch(() => {});
    }, 3000);
</script>
@endsection
