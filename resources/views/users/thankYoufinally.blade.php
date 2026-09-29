@extends('users.master')

@section('home')
<style>
    .thank-you-container {
        font-family: 'Inter', 'Roboto', sans-serif;
        background: url('https://images.unsplash.com/photo-1506012787146-f92b2d7d6d96?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80') no-repeat center center fixed;
        background-size: cover;
        position: relative;
    }
    
    .thank-you-container::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(6, 78, 59, 0.9) 0%, rgba(15, 23, 42, 0.85) 100%);
        backdrop-filter: blur(10px);
        z-index: 1;
    }

    .content-wrapper {
        position: relative;
        z-index: 10;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-radius: 2rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4), 0 0 50px rgba(16, 185, 129, 0.15);
        overflow: hidden;
    }

    .glass-panel {
        background: rgba(248, 250, 252, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.9);
        border-radius: 1.5rem;
    }

    .text-gradient {
        background: linear-gradient(to right, #059669, #10b981, #0ea5e9);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: 200% auto;
        animation: gradientShift 3s ease infinite;
    }

    .btn-glow {
        position: relative;
        background: linear-gradient(135deg, #059669, #10b981);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .btn-glow::after {
        content: '';
        position: absolute;
        top: -50%; left: -50%; width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.4) 0%, transparent 60%);
        opacity: 0;
        transition: opacity 0.3s;
        transform: scale(0.5);
    }
    
    .btn-glow:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px -5px rgba(16, 185, 129, 0.5);
    }

    .btn-glow:hover::after {
        opacity: 1;
        transform: scale(1);
        animation: ripple pulse 1s infinite;
    }

    /* Success Celebration Icon */
    .celebration-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 50%;
        box-shadow: 0 0 0 10px rgba(16, 185, 129, 0.2), 0 20px 40px rgba(16, 185, 129, 0.4);
        animation: popIn 0.8s cubic-bezier(0.17, 0.89, 0.32, 1.49) forwards;
    }

    .celebration-icon i {
        font-size: 3.5rem;
        color: white;
        text-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .confetti {
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: #f0f0f0;
        opacity: 0;
    }
    
    @keyframes popIn {
        0% { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
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

</style>

<div class="thank-you-container min-h-screen pt-32 pb-24 flex items-center justify-center">
    <div class="content-wrapper max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <div class="glass-card p-6 md:p-10 animate-fadeInUp">
            
            <!-- Header Section -->
            <div class="text-center mb-12">
                <div class="mb-8 relative">
                    <div class="celebration-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <!-- Decorative sparkles -->
                    <div class="absolute top-0 right-[40%] animate-ping" style="animation-duration: 2s"><i class="fas fa-star text-yellow-400 text-xl"></i></div>
                    <div class="absolute bottom-0 left-[40%] animate-ping" style="animation-duration: 3s; animation-delay: 0.5s"><i class="fas fa-star text-yellow-400 text-sm"></i></div>
                </div>
                
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 text-slate-900 tracking-tight">
                    Hoàn Tất <span class="text-gradient">Tuyệt Vời!</span>
                </h1>
                <p class="text-emerald-700 font-bold text-lg bg-emerald-50 inline-block px-4 py-2 rounded-full mb-3 border border-emerald-100 shadow-sm">
                    <i class="fas fa-shield-check mr-2"></i>Thanh toán 100% thành công
                </p>
                <p class="text-slate-500 font-medium text-base max-w-2xl mx-auto mt-2">
                    Mọi thủ tục đã hoàn tất. Hành trang đã sẵn sàng, hãy chuẩn bị cho một chuyến đi không thể nào quên cùng TravelGo!
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- LEFT: Order Details -->
                <div class="lg:col-span-7 space-y-6 animate-fadeInUp delay-100">
                    <div class="glass-panel p-6 sm:p-8 h-full flex flex-col shadow-sm">
                        <div class="flex flex-wrap items-center justify-between gap-4 mb-8 pb-6 border-b border-slate-200 border-opacity-70">
                            <div>
                                <p class="text-xs uppercase tracking-widest font-bold text-slate-400 mb-1">Mã đơn hàng</p>
                                <div class="flex items-center gap-3">
                                    <h3 class="text-3xl font-bold text-slate-900">#ORDER-{{ $order->id }}</h3>
                                </div>
                            </div>
                            <div class="text-left md:text-right bg-white p-3 rounded-xl border border-slate-100 shadow-sm">
                                <p class="text-xs uppercase tracking-widest font-bold text-slate-400 mb-1">Ngày hoàn tất</p>
                                <p class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                    <i class="far fa-calendar-check text-emerald-500"></i>
                                    {{ $order->updated_at->format('d/m/Y - H:i') }}
                                </p>
                            </div>
                        </div>

                        <!-- Tour Block -->
                        <div class="flex sm:flex-row flex-col gap-5 mb-8 p-4 bg-white rounded-2xl shadow-sm border border-slate-100 group hover:shadow-md transition-all">
                            <div class="relative shrink-0 overflow-hidden rounded-xl h-24 sm:h-auto sm:w-32">
                                <img src="{{ asset($tour->image ?? 'images/default-tour.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                                <div class="absolute bottom-2 left-2 text-white text-xs font-bold flex items-center gap-1">
                                    <i class="fas fa-plane-departure text-emerald-400"></i> Khởi hành
                                </div>
                            </div>
                            <div class="flex flex-col justify-center flex-grow">
                                <h4 class="text-lg font-bold text-slate-900 line-clamp-2 leading-tight mb-3 group-hover:text-emerald-600 transition-colors">
                                    {{ $tour->name }}
                                </h4>
                                <div class="flex flex-wrap gap-x-6 gap-y-2">
                                    <span class="text-sm font-bold text-slate-600 flex items-center bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                        <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2">
                                            <i class="far fa-calendar-alt text-xs"></i>
                                        </div>
                                        {{ $order->tour->start_date?->format('d/m/Y') ?? '---' }}
                                    </span>
                                    <span class="text-sm font-bold text-slate-600 flex items-center bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mr-2">
                                            <i class="fas fa-users text-xs"></i>
                                        </div>
                                        {{ $order->quantity }} Hành khách
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Financials -->
                        <div class="mt-auto space-y-4">
                            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 flex justify-between items-center">
                                <span class="text-sm font-bold text-slate-600">Tổng giá trị Tour</span>
                                <span class="text-xl font-bold text-slate-900">{{ number_format($order->total_price, 0, ',', '.') }} đ</span>
                            </div>
                            
                            <div class="bg-gradient-to-r from-emerald-50 to-emerald-100/50 p-5 rounded-2xl border border-emerald-200 flex items-center justify-between shadow-sm">
                                <div>
                                    <p class="text-xs uppercase tracking-widest font-bold text-emerald-600 mb-1">Trạng thái tài chính</p>
                                    <p class="text-lg font-bold text-emerald-800 flex items-center gap-2">
                                        <i class="fas fa-check-circle text-emerald-500"></i> Đã thanh toán TOÀN BỘ
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow text-emerald-500 text-xl border border-emerald-100">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Actions & Info -->
                <div class="lg:col-span-5 space-y-6 animate-fadeInUp delay-200">
                    
                    <!-- What's next widget -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 relative overflow-hidden shadow-xl shadow-emerald-50 box-border">
                        <!-- Decorative bg -->
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-100/50 rounded-full mix-blend-multiply pointer-events-none"></div>
                        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-blue-100/50 rounded-full mix-blend-multiply pointer-events-none"></div>
                        
                        <h3 class="text-xl font-bold mb-6 flex items-center gap-3 text-slate-900 relative z-10">
                            <span class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center"><i class="fas fa-clipboard-list text-emerald-600 text-sm"></i></span>
                            Lưu ý quan trọng
                        </h3>

                        <ul class="space-y-6 relative z-10">
                            <li class="flex gap-4 items-start">
                                <div class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center shrink-0 shadow-sm text-blue-500 text-lg">
                                    <i class="fas fa-envelope-open-text"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 mb-1">Xác nhận Hóa đơn</p>
                                    <p class="text-sm text-slate-500 leading-relaxed font-medium">Hóa đơn điện tử và hướng dẫn chi tiết nhận phòng/vé đã được gửi qua email.</p>
                                </div>
                            </li>
                            <li class="flex gap-4 items-start">
                                <div class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center shrink-0 shadow-sm text-rose-500 text-lg">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 mb-1">Giấy tờ định danh</p>
                                    <p class="text-sm text-slate-500 leading-relaxed font-medium">Vui lòng chuẩn bị CCCD/Hộ chiếu bản gốc để đối chiếu khi tham gia Tour.</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('user.bill.export', $order->id) }}" class="col-span-1 sm:col-span-2 btn-glow p-4 rounded-2xl text-center text-white font-bold group flex justify-center items-center gap-3 shadow-lg shadow-emerald-500/30">
                            <i class="fas fa-download"></i> Tải Xuất Hóa Đơn PDF
                        </a>
                        
                        <a href="{{ route('user.home') }}" class="flex flex-col items-center justify-center gap-2 p-5 bg-white rounded-2xl border border-slate-200 hover:border-blue-300 hover:shadow-lg hover:-translate-y-1 transition-all group">
                            <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">
                                <i class="fas fa-home text-xl"></i>
                            </div>
                            <span class="font-bold text-slate-700 text-sm group-hover:text-blue-600 transition-colors">Trang chủ</span>
                        </a>
                        
                        <a href="{{ route('review.create', $order->id) }}" class="flex flex-col items-center justify-center gap-2 p-5 bg-white rounded-2xl border border-slate-200 hover:border-amber-300 hover:shadow-lg hover:-translate-y-1 transition-all group">
                            <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 group-hover:bg-amber-50 group-hover:text-amber-500 transition-colors">
                                <i class="fas fa-star text-xl"></i>
                            </div>
                            <span class="font-bold text-slate-700 text-sm group-hover:text-amber-600 transition-colors">Viết đánh giá</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Help -->
            <div class="mt-12 pt-8 border-t border-slate-200 text-center animate-fadeInUp delay-300 flex flex-col md:flex-row items-center justify-between gap-6">
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">TravelGo Đồng Hành Cùng Bạn 24/7</p>
                
                <div class="flex items-center gap-4">
                    <a href="tel:1900123456" class="bg-slate-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-slate-800 transition-colors shadow-sm flex items-center gap-2">
                        <i class="fas fa-phone-alt"></i> 1900 123 456
                    </a>
                    <a href="{{ route('contact') }}" class="bg-white text-slate-700 border border-slate-200 px-6 py-3 rounded-xl font-bold hover:bg-slate-50 transition-colors shadow-sm flex items-center gap-2">
                        <i class="fas fa-headset"></i> CSKH
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
