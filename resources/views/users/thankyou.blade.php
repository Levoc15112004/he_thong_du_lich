@extends('users.master')

@section('home')
<style>
    .thank-you-container {
        font-family: 'Inter', 'Roboto', sans-serif;
        background: url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') no-repeat center center fixed;
        background-size: cover;
        position: relative;
    }
    
    .thank-you-container::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 58, 138, 0.85) 100%);
        backdrop-filter: blur(8px);
        z-index: 1;
    }

    .content-wrapper {
        position: relative;
        z-index: 10;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 2rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3), 0 0 40px rgba(59, 130, 246, 0.1);
        overflow: hidden;
    }

    .glass-panel {
        background: rgba(248, 250, 252, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 1.5rem;
    }

    .text-gradient {
        background: linear-gradient(to right, #059669, #10b981, #3b82f6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: 200% auto;
        animation: gradientShift 3s ease infinite;
    }

    .btn-glow {
        position: relative;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .btn-glow::after {
        content: '';
        position: absolute;
        top: -50%; left: -50%; width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 60%);
        opacity: 0;
        transition: opacity 0.3s;
        transform: scale(0.5);
    }
    
    .btn-glow:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px -5px rgba(37, 99, 235, 0.5);
    }

    .btn-glow:hover::after {
        opacity: 1;
        transform: scale(1);
        animation: ripple pulse 1s infinite;
    }

    /* Success Checkmark Animation */
    .success-checkmark {
        width: 100px;
        height: 100px;
        margin: 0 auto;
        position: relative;
    }

    .success-checkmark .check-icon {
        width: 100px;
        height: 100px;
        position: relative;
        border-radius: 50%;
        box-sizing: content-box;
        border: 4px solid #10b981;
    }

    .success-checkmark .check-icon::before {
        top: 3px;
        left: -2px;
        width: 30px;
        transform-origin: 100% 50%;
        border-radius: 100px 0 0 100px;
    }

    .success-checkmark .check-icon::after {
        top: 0;
        left: 30px;
        width: 60px;
        transform-origin: 0 50%;
        border-radius: 0 100px 100px 0;
        animation: rotate-circle 4.25s ease-in;
    }

    .success-checkmark .check-icon::before, .success-checkmark .check-icon::after {
        content: '';
        height: 100px;
        position: absolute;
        background: transparent;
        transform: rotate(-45deg);
    }

    .success-checkmark .check-icon .icon-line {
        height: 5px;
        background-color: #10b981;
        display: block;
        border-radius: 2px;
        position: absolute;
        z-index: 10;
    }

    .success-checkmark .check-icon .icon-line.line-tip {
        top: 54px;
        left: 20px;
        width: 25px;
        transform: rotate(45deg);
        animation: icon-line-tip 0.75s;
    }

    .success-checkmark .check-icon .icon-line.line-long {
        top: 46px;
        right: 18px;
        width: 47px;
        transform: rotate(-45deg);
        animation: icon-line-long 0.75s;
    }

    .success-checkmark .check-icon .icon-circle {
        top: -4px;
        left: -4px;
        z-index: 10;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        position: absolute;
        box-sizing: content-box;
        border: 4px solid rgba(16, 185, 129, 0.2);
    }

    .success-checkmark .check-icon .icon-fix {
        top: 8px;
        width: 5px;
        left: 26px;
        z-index: 1;
        height: 85px;
        position: absolute;
        transform: rotate(-45deg);
        background-color: transparent;
    }

    @keyframes icon-line-tip {
        0% { width: 0; left: 1px; top: 19px; }
        54% { width: 0; left: 1px; top: 19px; }
        70% { width: 50px; left: -8px; top: 37px; }
        84% { width: 17px; left: 21px; top: 48px; }
        100% { width: 25px; left: 20px; top: 54px; }
    }

    @keyframes icon-line-long {
        0% { width: 0; right: 46px; top: 54px; }
        65% { width: 0; right: 46px; top: 54px; }
        84% { width: 55px; right: 0px; top: 35px; }
        100% { width: 47px; right: 18px; top: 46px; }
    }
    
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    @keyframes slideUpFade {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fadeInUp {
        animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    
    .delay-100 { animation-delay: 100ms; opacity: 0; }
    .delay-200 { animation-delay: 200ms; opacity: 0; }
    .delay-300 { animation-delay: 300ms; opacity: 0; }

    /* Modern Stepper */
    .stepper-container {
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 0 1rem;
    }
    .step-line {
        position: absolute;
        top: 24px;
        left: 40px;
        right: 40px;
        height: 3px;
        background: rgba(226, 232, 240, 0.5);
        z-index: 1;
        border-radius: 3px;
    }
    .step-line-fill {
        position: absolute;
        top: 0; left: 0; height: 100%;
        background: linear-gradient(90deg, #10b981, #3b82f6);
        width: 100%;
        border-radius: 3px;
        box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
    }
    .step-item {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }
    .step-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }
    .step-completed .step-circle {
        background: #10b981;
        color: white;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2), 0 10px 15px -3px rgba(16, 185, 129, 0.3);
    }
    .step-current .step-circle {
        background: #3b82f6;
        color: white;
        box-shadow: 0 0 0 6px rgba(59, 130, 246, 0.2), 0 10px 15px -3px rgba(59, 130, 246, 0.4);
        transform: scale(1.1);
    }
    .step-text {
        font-size: 0.875rem;
        font-weight: 700;
    }
    .step-completed .step-text { color: #10b981; }
    .step-current .step-text { color: #3b82f6; }
</style>

<div class="thank-you-container min-h-screen pt-32 pb-24 flex items-center justify-center">
    <div class="content-wrapper max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <div class="glass-card p-6 md:p-10 animate-fadeInUp">
            <!-- Header Section -->
            <div class="text-center mb-10">
                <div class="success-checkmark mb-6">
                    <div class="check-icon">
                        <span class="icon-line line-tip"></span>
                        <span class="icon-line line-long"></span>
                        <div class="icon-circle"></div>
                        <div class="icon-fix"></div>
                    </div>
                </div>
                
                <h1 class="text-3xl md:text-5xl font-extrabold mb-4 text-slate-900 tracking-tight">
                    Thanh Toán <span class="text-gradient">Thành Công!</span>
                </h1>
                <p class="text-slate-500 font-medium text-lg max-w-2xl mx-auto">
                    Cảm ơn bạn đã tin tưởng chọn TravelGo. Số tiền cọc đã được ghi nhận.
                </p>
            </div>

            <!-- Stepper -->
            <div class="max-w-2xl mx-auto mb-12 animate-fadeInUp delay-100 hidden md:block">
                <div class="stepper-container">
                    <div class="step-line"><div class="step-line-fill"></div></div>
                    
                    <div class="step-item step-completed">
                        <div class="step-circle"><i class="fas fa-check"></i></div>
                        <span class="step-text uppercase tracking-wider">Thông tin</span>
                    </div>
                    
                    <div class="step-item step-completed">
                        <div class="step-circle"><i class="fas fa-check"></i></div>
                        <span class="step-text uppercase tracking-wider">Thanh toán</span>
                    </div>
                    
                    <div class="step-item step-current">
                        <div class="step-circle"><i class="fas fa-flag-checkered"></i></div>
                        <span class="step-text uppercase tracking-wider">Hoàn tất</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- LEFT: Order Summary -->
                <div class="lg:col-span-7 space-y-6 animate-fadeInUp delay-200">
                    <div class="glass-panel p-6 sm:p-8 h-full flex flex-col shadow-sm">
                        <div class="flex flex-wrap items-center justify-between gap-4 mb-8 pb-6 border-b border-slate-200 border-opacity-70">
                            <div>
                                <p class="text-xs uppercase tracking-widest font-bold text-slate-400 mb-1">Mã xác nhận</p>
                                <div class="flex items-center gap-3">
                                    <h3 class="text-3xl font-bold text-slate-900">#{{ $booking['code'] ?? 'VT-'.rand(1000, 9999) }}</h3>
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-md border border-emerald-200">Đã cọc 30%</span>
                                </div>
                            </div>
                            <div class="text-left md:text-right bg-white p-3 rounded-xl border border-slate-100 shadow-sm">
                                <p class="text-xs uppercase tracking-widest font-bold text-slate-400 mb-1">Ngày giao dịch</p>
                                <p class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                    <i class="far fa-clock text-blue-500"></i>
                                    {{ now()->format('d/m/Y - H:i') }}
                                </p>
                            </div>
                        </div>

                        <!-- Tour Block -->
                        <div class="flex sm:flex-row flex-col gap-5 mb-8 p-4 bg-white rounded-2xl shadow-sm border border-slate-100 group hover:shadow-md transition-all">
                            <div class="relative shrink-0 overflow-hidden rounded-xl h-24 sm:h-auto sm:w-32">
                                <img src="{{ asset($tour->image ?? 'images/default-tour.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                                <div class="absolute bottom-2 left-2 text-white text-xs font-bold flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-rose-500"></i> Tour
                                </div>
                            </div>
                            <div class="flex flex-col justify-center flex-grow">
                                <h4 class="text-lg font-bold text-slate-900 line-clamp-2 leading-tight mb-3 group-hover:text-blue-600 transition-colors">
                                    {{ $tour->name }}
                                </h4>
                                <div class="flex flex-wrap gap-x-6 gap-y-2">
                                    <span class="text-sm font-bold text-slate-600 flex items-center bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                        <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2">
                                            <i class="far fa-calendar-alt text-xs"></i>
                                        </div>
                                        {{ isset($tour->start_date) ? date('d/m/Y', strtotime($tour->start_date)) : 'Chưa xác định' }}
                                    </span>
                                    <span class="text-sm font-bold text-slate-600 flex items-center bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mr-2">
                                            <i class="fas fa-user-friends text-xs"></i>
                                        </div>
                                        {{ $order['quantity'] ?? 1 }} Khách
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Financials -->
                        @php
                            $total = $order['total_price'] ?? 0;
                            $deposit = $total * 0.3;
                            $remain = $total - $deposit;
                        @endphp
                        <div class="mt-auto space-y-3 bg-slate-50 p-5 rounded-2xl border border-slate-200">
                            <div class="flex justify-between items-center text-sm font-bold text-slate-500 pb-3 border-b border-slate-200">
                                <span>Tổng giá trị tour</span>
                                <span class="text-slate-900 text-base">{{ number_format($total, 0, ',', '.') }} đ</span>
                            </div>
                            <div class="flex justify-between items-center text-sm font-bold text-emerald-600 pb-3 border-b border-slate-200">
                                <span class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center"><i class="fas fa-check text-xs"></i></span>
                                    Đã thanh toán (Cọc 30%)
                                </span>
                                <span class="text-base">-{{ number_format($deposit, 0, ',', '.') }} đ</span>
                            </div>

                            <div class="pt-2 flex justify-between items-end">
                                <div>
                                    <p class="text-[11px] uppercase tracking-widest font-bold text-rose-500 mb-1">Số tiền còn lại</p>
                                    <p class="text-xs font-semibold text-slate-400 bg-white px-2 py-1 rounded inline-block shadow-sm">Thanh toán bổ sung sau</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">
                                        {{ number_format($remain, 0, ',', '.') }}<span class="text-lg text-slate-500 ml-1">đ</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Actions & Info -->
                <div class="lg:col-span-5 space-y-6 animate-fadeInUp delay-300">
                    
                    <!-- What's next widget -->
                    <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl shadow-slate-900/20 box-border">
                        <!-- Decorative bg -->
                        <div class="absolute top-0 right-0 w-48 h-48 bg-blue-500/20 blur-[60px] rounded-full mix-blend-screen pointer-events-none"></div>
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-emerald-500/20 blur-[40px] rounded-full mix-blend-screen pointer-events-none"></div>
                        
                        <h3 class="text-xl font-bold mb-6 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center shadow-inner"><i class="fas fa-lightbulb text-amber-400 text-sm"></i></span>
                            Bước tiếp theo?
                        </h3>

                        <ul class="space-y-5 relative z-10">
                            <li class="flex gap-4 items-start group">
                                <div class="w-10 h-10 rounded-xl bg-blue-500/20 border border-blue-400/20 flex items-center justify-center shrink-0 group-hover:bg-blue-500/40 transition-colors shadow-inner">
                                    <i class="fas fa-paper-plane text-blue-300"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-white mb-1">Kiểm tra hộp thư</p>
                                    <p class="text-xs text-slate-400 leading-relaxed font-medium">Vé điện tử và xác nhận đã được gửi đến email của bạn.</p>
                                </div>
                            </li>
                            <li class="flex gap-4 items-start group">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-400/20 flex items-center justify-center shrink-0 group-hover:bg-emerald-500/40 transition-colors shadow-inner">
                                    <i class="fas fa-headset text-emerald-300"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-white mb-1">Chờ liên hệ</p>
                                    <p class="text-xs text-slate-400 leading-relaxed font-medium">NV Tư vấn sẽ gọi cho bạn trong vòng 24h tới để hỗ trợ.</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('user.payment.final', $order->id) }}" class="col-span-1 sm:col-span-2 btn-glow p-4 rounded-2xl text-center text-white font-bold group flex justify-center items-center gap-3 shadow-lg shadow-blue-500/30">
                            <span class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center shadow-inner"><i class="fas fa-credit-card"></i></span>
                            Thanh toán phần còn lại ngay
                            <i class="fas fa-arrow-right opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all"></i>
                        </a>
                        
                        <a href="{{ route('user.tourDetail.index', $tour->id ?? 1) }}" class="flex items-center gap-3 p-4 bg-white rounded-2xl border border-slate-200 hover:border-blue-300 hover:shadow-lg hover:shadow-blue-50 transition-all group font-bold text-slate-700 text-sm">
                            <div class="w-10 h-10 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">
                                <i class="fas fa-map"></i>
                            </div>
                            Xem lại Tour
                        </a>
                        
                        <a href="{{ route('user.home') }}" class="flex items-center gap-3 p-4 bg-white rounded-2xl border border-slate-200 hover:border-emerald-300 hover:shadow-lg hover:shadow-emerald-50 transition-all group font-bold text-slate-700 text-sm">
                            <div class="w-10 h-10 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-emerald-50 group-hover:text-emerald-600 transition-colors">
                                <i class="fas fa-home"></i>
                            </div>
                            Về trang chủ
                        </a>
                    </div>
                    
                </div>
            </div>

            <!-- Footer Help -->
            <div class="mt-12 pt-8 border-t border-slate-200 text-center animate-fadeInUp delay-300 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-full border border-slate-200 shadow-sm">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    <span class="text-sm font-bold text-slate-600">Đội ngũ hỗ trợ Online 24/7</span>
                </div>
                
                <a href="tel:1900123456" class="text-slate-600 font-bold hover:text-blue-600 transition-colors flex items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    HOTLINE: <span class="text-lg">1900 123 456</span>
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
