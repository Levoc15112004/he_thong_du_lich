@extends('users.master')

@section('home')
<style>
    /* Pulse ring for active step */
    @keyframes pulse-ring {
        0% { transform: scale(0.8); opacity: 0.5; }
        100% { transform: scale(1.3); opacity: 0; }
    }
    .step-active-ring::before {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 2px solid #10b981;
        animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
    }

    /* Soft glass inputs */
    .glass-input {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        transition: all 0.3s ease;
    }
    .glass-input:focus {
        background: rgba(255, 255, 255, 0.95);
        border-color: #34d399;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        outline: none;
    }

    /* Cinematic Summary Card */
    .order-summary-glass {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.8) 100%);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 1);
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.05), inset 0 0 0 1px rgba(255,255,255,0.5);
        position: sticky;
        top: 120px;
    }
</style>

<div class="relative pt-32 pb-24 min-h-screen overflow-hidden">
    <!-- Ambient glowing backgrounds -->
    <div class="absolute top-20 left-10 w-[400px] h-[400px] bg-emerald-400/20 rounded-full blur-3xl pointer-events-none -z-10 animate-pulse-soft"></div>
    <div class="absolute bottom-20 right-10 w-[500px] h-[500px] bg-cyan-400/15 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-teal-300/10 rounded-full blur-2xl pointer-events-none -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- STEPPER SECTION -->
        <div class="max-w-3xl mx-auto mb-16 px-4">
            <div class="relative flex justify-between items-center">
                <!-- Lines ->
                <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-[3px] bg-slate-200 rounded-full z-0"></div>
                <div class="absolute left-0 top-1/2 -translate-y-1/2 h-[3px] bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full z-0 transition-all duration-700 w-[50%] sm:w-[35%]"></div>

                <!-- Step 1 -->
                <div class="flex flex-col items-center relative z-10 group">
                    <div class="step-active-ring relative w-12 h-12 rounded-full bg-gradient-to-tr from-emerald-500 to-teal-400 text-white flex items-center justify-center font-bold shadow-lg shadow-emerald-500/30">
                        <i class="fa-solid fa-1"></i>
                    </div>
                    <span class="text-[11px] font-extrabold uppercase mt-3 text-emerald-600 tracking-wide drop-shadow-sm">Thông tin</span>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center relative z-10">
                    <div class="w-12 h-12 rounded-full bg-white border-2 border-slate-200 text-slate-400 flex items-center justify-center font-bold shadow-sm transition-colors group-hover:border-teal-200">
                        <i class="fa-solid fa-2"></i>
                    </div>
                    <span class="text-[11px] font-bold uppercase mt-3 text-slate-400 tracking-wide">Thanh toán</span>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center relative z-10">
                    <div class="w-12 h-12 rounded-full bg-white border-2 border-slate-200 text-slate-400 flex items-center justify-center font-bold shadow-sm transition-colors">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <span class="text-[11px] font-bold uppercase mt-3 text-slate-400 tracking-wide">Xác nhận</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 xl:gap-12">
            
            <!-- LEFT: FORM SECTION -->
            <div class="xl:col-span-7">
                <div class="bg-white/70 backdrop-blur-xl p-6 sm:p-10 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/80 relative overflow-hidden">
                    
                    <!-- Decorative element -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-emerald-200/40 to-transparent rounded-bl-full pointer-events-none"></div>

                    <div class="flex items-center gap-4 mb-8 relative z-10">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-400 rounded-2xl flex items-center justify-center text-white shadow-md shadow-emerald-500/20">
                            <i class="fa-solid fa-user-astronaut text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Người đặt <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-500">hành trình</span></h2>
                    </div>

                    @if (auth()->check())
                        <div class="mb-10 group/profile">
                            <div id="profileCard" class="cursor-pointer bg-white border border-slate-100/80 hover:border-emerald-300 rounded-[1.5rem] p-5 transition-all duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm hover:shadow-xl hover:shadow-emerald-500/10 active:scale-[0.98]">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=10b981&color=fff' }}"
                                             class="w-16 h-16 rounded-full object-cover border-4 border-emerald-50 shadow-md">
                                        <div class="absolute bottom-0 right-0 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></div>
                                    </div>
                                    <div>
                                        <p class="text-lg font-bold text-slate-800 tracking-tight">{{ auth()->user()->name }}</p>
                                        <p class="text-sm text-slate-500 font-medium">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                                <button type="button" id="profileStatus" class="shrink-0 px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 bg-emerald-50 hover:bg-emerald-500 text-emerald-600 hover:text-white border border-emerald-100 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/25">
                                    <i class="fa-solid fa-wand-magic-sparkles mr-1"></i> Tự động điền
                                </button>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('user.order.store') }}" method="POST" class="space-y-6 relative z-10">
                        @csrf

                        <!-- Họ tên -->
                        <div class="group">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block ml-1">Họ và tên khách hàng <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-regular fa-user text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                </div>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="VD: Nguyễn Văn A"
                                       class="w-full glass-input rounded-2xl py-3.5 pl-11 pr-4 text-sm font-semibold text-slate-800 placeholder-slate-400" required>
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-6">
                            <!-- Email -->
                            <div class="group">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block ml-1">Email <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fa-regular fa-envelope text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                    </div>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="example@gmail.com"
                                           class="w-full glass-input rounded-2xl py-3.5 pl-11 pr-4 text-sm font-semibold text-slate-800 placeholder-slate-400" required>
                                </div>
                            </div>
                            
                            <!-- Phone -->
                            <div class="group">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block ml-1">Số điện thoại <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-phone text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                    </div>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="09xx xxx xxx"
                                           class="w-full glass-input rounded-2xl py-3.5 pl-11 pr-4 text-sm font-semibold text-slate-800 placeholder-slate-400" required>
                                </div>
                            </div>
                        </div>

                        <!-- Địa chỉ -->
                        <div class="group">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block ml-1">Địa chỉ thường trú <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-map-location-dot text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                </div>
                                <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Số nhà, tên đường, phường/xã, quận/huyện..."
                                       class="w-full glass-input rounded-2xl py-3.5 pl-11 pr-4 text-sm font-semibold text-slate-800 placeholder-slate-400" required>
                            </div>
                        </div>

                        <!-- Ghi chú -->
                        <div class="group">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block ml-1">Ghi chú thêm</label>
                            <div class="relative">
                                <div class="absolute top-3.5 left-0 pl-4 flex items-start pointer-events-none">
                                    <i class="fa-regular fa-comment-dots text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                </div>
                                <textarea name="note" rows="3" placeholder="Yêu cầu về ăn uống, chỗ ngồi, thời gian đón..."
                                          class="w-full glass-input rounded-2xl py-3.5 pl-11 pr-4 text-sm font-semibold text-slate-800 placeholder-slate-400 resize-none">{{ old('note') }}</textarea>
                            </div>
                        </div>

                        <!-- Hidden Fields -->
                        <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                        <input type="hidden" name="status" value="0">
                        <input type="hidden" name="user_id" value="{{ auth()->id() ?? 0 }}">

                        @foreach ($cart->getItems() as $key => $item)
                            <input type="hidden" name="tours[{{ $key }}][tour_id]" value="{{ $item['tour_id'] }}">
                            <input type="hidden" name="tours[{{ $key }}][quantity]" value="{{ $item['quantity'] }}">
                            <input type="hidden" name="tours[{{ $key }}][transport]" value="{{ $item['transport'] }}">
                            <input type="hidden" name="tours[{{ $key }}][tour_type]" value="{{ $item['tour_type'] }}">
                        @endforeach

                        <div class="pt-6">
                            <button type="submit" class="w-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white py-4 rounded-2xl font-extrabold text-base transition-all duration-300 shadow-lg shadow-emerald-500/30 flex items-center justify-center gap-3 hover:-translate-y-1">
                                Tiếp tục thanh toán <i class="fa-solid fa-arrow-right-long text-sm"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- RIGHT: SUMMARY SECTION -->
            <div class="xl:col-span-5">
                <div class="order-summary-glass p-6 sm:p-8 rounded-[2rem]">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold text-slate-900 tracking-tight">Tóm tắt <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-500">đơn hàng</span></h3>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-500 shadow-sm">
                            <i class="fa-solid fa-basket-shopping text-xl"></i>
                        </div>
                    </div>

                    @php $items = $cart->getItems(); @endphp

                    @if ($items && count($items) > 0)
                        <div class="space-y-4 mb-8">
                            @foreach ($items as $item)
                                @php $tour = \App\Models\Tour::find($item['tour_id']); @endphp
                                @if ($tour)
                                    <div class="group relative flex gap-4 p-3 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-300">
                                        <img src="{{ asset($tour->image) }}" class="w-20 h-20 rounded-xl object-cover shrink-0" alt="{{ $tour->name }}">
                                        <div class="flex flex-col justify-center flex-1">
                                            <h4 class="text-sm font-bold text-slate-800 line-clamp-2 leading-tight group-hover:text-emerald-600 transition-colors">{{ $tour->name }}</h4>
                                            <div class="flex items-center gap-3 mt-2">
                                                <p class="text-[10px] text-slate-500 font-semibold flex items-center gap-1">
                                                    <i class="fa-regular fa-calendar text-emerald-500"></i> {{ \Carbon\Carbon::parse($tour->start_date)->format('d/m/Y') }}
                                                </p>
                                                <p class="text-[10px] text-slate-500 font-semibold flex items-center gap-1">
                                                    <i class="fa-solid fa-user-group text-emerald-500"></i> {{ $item['quantity'] }} KH
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="space-y-4 pt-6 border-t border-slate-200 border-dashed">
                            <div class="flex justify-between items-center text-sm font-semibold text-slate-500">
                                <span>Tạm tính</span>
                                <span class="text-slate-800 font-bold">{{ number_format($totalPrice) }}₫</span>
                            </div>

                            @if (!empty($voucher))
                                <div class="flex justify-between items-center bg-gradient-to-r from-emerald-50 to-teal-50 p-4 rounded-xl border border-emerald-100">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                            <i class="fa-solid fa-ticket text-xs"></i>
                                        </div>
                                        <span class="text-xs font-bold uppercase text-emerald-700 tracking-wider">{{ $voucher['code'] }}</span>
                                    </div>
                                    <span class="text-sm font-bold text-emerald-600">-{{ number_format($discount) }}₫</span>
                                </div>
                            @endif

                            <div class="pt-5 mt-2 border-t border-slate-200 flex flex-col gap-1">
                                <p class="text-[11px] font-bold uppercase text-slate-500 tracking-wider">Tổng thanh toán</p>
                                <div class="flex justify-between items-end mt-1">
                                    <span class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-600 drop-shadow-sm">{{ number_format($finalTotal) }}₫</span>
                                    <span class="text-[10px] text-slate-400 font-semibold mb-1 relative top-[-6px]">Đã bao gồm VAT</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12 bg-white/50 rounded-3xl border border-dashed border-slate-200">
                            <div class="w-16 h-16 bg-white rounded-full shadow-sm flex items-center justify-center mx-auto mb-3">
                                <i class="fa-solid fa-cart-flatbed-empty text-2xl text-slate-300"></i>
                            </div>
                            <p class="text-sm font-extrabold text-slate-400">Giỏ hàng trống</p>
                        </div>
                    @endif

                    <!-- Trust Badge -->
                    <div class="mt-8 p-4 rounded-2xl bg-white/80 border border-emerald-100 flex items-start gap-4 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <div class="shrink-0 w-10 h-10 rounded-[10px] bg-gradient-to-br from-emerald-100 to-teal-50 flex items-center justify-center text-emerald-600 shadow-inner group-hover:scale-105 transition-transform duration-300">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <p class="text-[11px] text-slate-600 font-medium leading-relaxed pt-0.5">
                            <strong class="text-emerald-700">TravelGo</strong> cam kết bảo mật thông tin khách hàng tuyệt đối theo tiêu chuẩn quốc tế.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (auth()->check())
    <script>
        const profileCard = document.getElementById('profileCard');
        const profileStatus = document.getElementById('profileStatus');
        let isUsingProfile = false;

        profileCard?.addEventListener('click', function() {
            const user = @json(auth()->user());
            isUsingProfile = !isUsingProfile;

            if (isUsingProfile) {
                document.getElementById('name').value = user.name ?? '';
                document.getElementById('email').value = user.email ?? '';
                document.getElementById('phone').value = user.phone ?? '';
                document.getElementById('address').value = user.address ?? '';

                profileStatus.innerHTML = `<i class="fa-solid fa-check mr-1"></i> Đã điền`;
                profileStatus.classList.remove('bg-emerald-50', 'text-emerald-600');
                profileStatus.classList.add('bg-emerald-500', 'text-white', 'shadow-lg', 'shadow-emerald-500/25');
                profileCard.classList.add('border-emerald-400', 'shadow-xl', 'shadow-emerald-500/10');
            } else {
                document.getElementById('name').value = '';
                document.getElementById('email').value = '';
                document.getElementById('phone').value = '';
                document.getElementById('address').value = '';

                profileStatus.innerHTML = `<i class="fa-solid fa-wand-magic-sparkles mr-1"></i> Tự động điền`;
                profileStatus.classList.remove('bg-emerald-500', 'text-white', 'shadow-lg', 'shadow-emerald-500/25');
                profileStatus.classList.add('bg-emerald-50', 'text-emerald-600');
                profileCard.classList.remove('border-emerald-400', 'shadow-xl', 'shadow-emerald-500/10');
            }
        });
    </script>
@endif
@endsection
