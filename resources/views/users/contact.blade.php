@extends('users.master')

@section('home')
<style>
    .text-gradient {
        background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .premium-card {
        background: white;
        border-radius: 2.5rem;
        border: 1px solid rgba(241, 245, 249, 1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .premium-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -15px rgba(59, 130, 246, 0.1);
    }

    .hero-gradient {
        background: radial-gradient(circle at 10% 20%, rgba(16, 185, 129, 0.15), transparent 50%),
                    radial-gradient(circle at 90% 80%, rgba(6, 182, 212, 0.10), transparent 50%);
    }

    .input-modern {
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
    }

    .input-modern:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        outline: none;
    }

    .btn-gradient {
        background: linear-gradient(to right, #10b981, #0d9488);
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        filter: brightness(1.1);
        box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
    }

    .icon-box {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
</style>

<div class="contact-container min-h-screen bg-slate-50 dark:bg-[#0b1120] text-slate-800 dark:text-slate-100 transition-colors duration-300">
    {{-- HERO SECTION --}}
    <section class="relative pt-40 pb-24 overflow-hidden hero-gradient">
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 px-4 py-2 rounded-full border border-emerald-200/80 dark:border-emerald-800/80 mb-8 font-bold text-xs uppercase tracking-wider shadow-sm">
                <i class="fa-solid fa-headset text-emerald-500"></i>
                Hỗ Trợ Tận Tâm 24/7
            </div>
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-6">
                Kết Nối Với <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-400">WanderVibe</span>
            </h1>
            <p class="text-slate-600 dark:text-slate-300 font-normal text-base md:text-lg max-w-2xl mx-auto leading-relaxed">
                Chúng tôi luôn sẵn sàng lắng nghe và đồng hành cùng bạn trong mọi chuyến hành trình khám phá thế giới.
            </p>
        </div>

        {{-- Decorative Elements --}}
        <div class="absolute top-1/4 -left-20 w-64 h-64 bg-blue-400/10 blur-[100px] rounded-full"></div>
        <div class="absolute bottom-0 -right-20 w-80 h-80 bg-violet-400/10 blur-[120px] rounded-full"></div>
    </section>

    <main class="max-w-7xl mx-auto px-6 -mt-16 pb-24 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- LEFT: CONTACT INFO (BENTO STYLE) -->
            <div class="lg:col-span-4 space-y-6">
                {{-- Address --}}
                <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-7 border border-slate-100 dark:border-slate-700/80 shadow-sm hover:shadow-xl transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl mb-5 shadow-sm group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white mb-1.5">Trụ Sở Chính</h3>
                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed font-medium">
                        Tòa nhà Landmark 81, P. 22, Q. Bình Thạnh, TP. Hồ Chí Minh
                    </p>
                    <p class="text-xs text-slate-400 dark:text-slate-400 mt-2 font-normal pt-2 border-t border-slate-100 dark:border-slate-700/60">
                        Chi nhánh HN: 98 phố Dương Quảng Hàm, Q. Cầu Giấy, Hà Nội
                    </p>
                </div>

                {{-- Phone --}}
                <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-7 border border-slate-100 dark:border-slate-700/80 shadow-sm hover:shadow-xl transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl mb-5 shadow-sm group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                        <i class="fa-solid fa-phone-volume"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white mb-1">Hotline Đặt Tour 24/7</h3>
                    <p class="text-emerald-600 dark:text-emerald-400 text-xs font-bold uppercase tracking-wider mb-2">Tư vấn miễn phí 24/7</p>
                    <a href="tel:1900888999" class="text-2xl font-black text-slate-900 dark:text-white hover:text-emerald-500 transition-colors block">
                        1900 888 999
                    </a>
                </div>

                {{-- Email --}}
                <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-7 border border-slate-100 dark:border-slate-700/80 shadow-sm hover:shadow-xl transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl mb-5 shadow-sm group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white mb-1">Email Tư Vấn & Báo Giá</h3>
                    <p class="text-emerald-600 dark:text-emerald-400 text-xs font-bold uppercase tracking-wider mb-2">Phản hồi trong 10 phút</p>
                    <a href="mailto:hello@wandervibe.me" class="text-base font-extrabold text-slate-900 dark:text-white hover:text-emerald-500 transition-colors block">
                        hello@wandervibe.me
                    </a>
                </div>
            </div>

            <!-- RIGHT: CONTACT FORM -->
            <div class="lg:col-span-8">
                <div class="bg-white dark:bg-slate-800/95 rounded-3xl p-8 sm:p-12 shadow-xl dark:shadow-2xl border border-slate-200 dark:border-slate-700/80 relative overflow-hidden backdrop-blur-xl">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-emerald-500/10 dark:bg-emerald-500/5 blur-[80px] rounded-full pointer-events-none"></div>

                    <div class="relative z-10">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mb-2 tracking-tight">
                            Gửi Yêu Cầu <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-400">Tư Vấn Tour</span>
                        </h2>
                        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-8">
                            Chuyên viên của WanderVibe sẽ liên hệ lại qua SĐT/Zalo trong vòng 10 phút
                        </p>

                        <form id="contactForm" method="POST" action="{{ route('consultation.send') }}" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2 block">
                                        Họ và tên <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="name" required placeholder="VD: Nguyễn Văn A"
                                        class="w-full px-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:outline-none focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-emerald-500/10 transition-all">
                                </div>
                                <div>
                                    <label class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2 block">
                                        Số điện thoại / Zalo <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="tel" name="phone" required placeholder="09xx xxx xxx"
                                        class="w-full px-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:outline-none focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-emerald-500/10 transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2 block">
                                        Địa chỉ Email
                                    </label>
                                    <input type="email" name="email" placeholder="example@email.com"
                                        class="w-full px-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:outline-none focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-emerald-500/10 transition-all">
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2 block">
                                        Loại hình Tour quan tâm
                                    </label>
                                    <div class="relative">
                                        <select name="tour_type" class="w-full px-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-900 dark:text-white appearance-none cursor-pointer focus:outline-none focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-emerald-500/10 transition-all">
                                            <option value="">-- Chọn loại hình tour --</option>
                                            <option value="Tour Biển đảo nghỉ dưỡng">Tour Biển đảo nghỉ dưỡng</option>
                                            <option value="Tour Khám phá vùng núi & săn mây">Tour Khám phá vùng núi & săn mây</option>
                                            <option value="Tour Di sản văn hóa & danh thắng">Tour Di sản văn hóa & danh thắng</option>
                                            <option value="Tour Thiết kế riêng cho gia đình / nhóm">Tour Thiết kế riêng cho gia đình / nhóm</option>
                                        </select>
                                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2 block">
                                    Lời nhắn hoặc yêu cầu đặc biệt
                                </label>
                                <textarea name="message" rows="4" placeholder="Hãy cho chúng tôi biết điểm đến mong muốn, số lượng người, thời gian khởi hành..."
                                    class="w-full px-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:outline-none focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-emerald-500/10 transition-all resize-none"></textarea>
                            </div>

                            <div id="formStatus" class="hidden p-4 rounded-xl text-xs sm:text-sm font-semibold transition-all"></div>

                            <button type="submit" id="contactSubmitBtn"
                                class="w-full py-4 rounded-xl bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600 hover:from-emerald-600 hover:to-teal-600 text-white font-extrabold text-sm sm:text-base uppercase tracking-wider shadow-lg shadow-emerald-500/25 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-2">
                                <span>Gửi Yêu Cầu Tư Vấn Ngay</span>
                                <i class="fa-solid fa-paper-plane text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Map / Social Support --}}
        <div class="mt-16 rounded-3xl p-8 sm:p-10 flex flex-col md:flex-row items-center justify-between gap-6 bg-gradient-to-br from-slate-900 via-slate-850 to-slate-900 border border-slate-800 shadow-2xl text-white">
            <div>
                <h4 class="text-2xl font-extrabold text-white mb-2">
                    Theo Dõi Hành Trình Cùng <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-400">WanderVibe</span>
                </h4>
                <p class="text-slate-300 text-sm font-medium">Cập nhật những điểm đến mới nhất và ưu đãi độc quyền hàng ngày.</p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="#" class="w-12 h-12 rounded-2xl bg-white/10 hover:bg-emerald-500 text-white border border-white/10 hover:border-emerald-400 flex items-center justify-center text-lg transition-all duration-300 shadow-sm" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="w-12 h-12 rounded-2xl bg-white/10 hover:bg-pink-600 text-white border border-white/10 hover:border-pink-500 flex items-center justify-center text-lg transition-all duration-300 shadow-sm" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="w-12 h-12 rounded-2xl bg-white/10 hover:bg-slate-700 text-white border border-white/10 hover:border-white/20 flex items-center justify-center text-lg transition-all duration-300 shadow-sm" title="TikTok">
                    <i class="fab fa-tiktok"></i>
                </a>
                <a href="https://zalo.me" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-2xl bg-white/10 hover:bg-emerald-600 text-white border border-white/10 hover:border-emerald-400 flex items-center justify-center text-lg transition-all duration-300 shadow-sm" title="Zalo">
                    <i class="fa-solid fa-comment-dots"></i>
                </a>
            </div>
        </div>
    </main>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('contactForm');
        const formStatus = document.getElementById('formStatus');
        const submitBtn = document.getElementById('contactSubmitBtn');

        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                if (!submitBtn) return;

                const origHtml = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Đang gửi yêu cầu...';

                if (formStatus) {
                    formStatus.classList.add('hidden');
                    formStatus.className = 'hidden p-4 rounded-xl text-xs sm:text-sm font-semibold transition-all';
                }

                try {
                    const formData = new FormData(form);
                    const res = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await res.json();
                    if (res.ok && data.success) {
                        if (formStatus) {
                            formStatus.innerHTML = '<i class="fa-solid fa-circle-check text-base mr-1.5"></i> ' + (data.message || 'Cảm ơn bạn! Yêu cầu tư vấn đã được gửi thành công. Chuyên viên WanderVibe sẽ liên hệ lại qua SĐT/Zalo trong ít phút!');
                            formStatus.className = 'block p-4 rounded-xl text-xs sm:text-sm font-semibold bg-emerald-50 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 animate-fade-in';
                        }
                        form.reset();
                    } else {
                        let errMsg = data.message || 'Không thể gửi yêu cầu lúc này.';
                        if (data.errors) {
                            errMsg = Object.values(data.errors).flat().join('<br>');
                        }
                        throw new Error(errMsg);
                    }
                } catch (err) {
                    if (formStatus) {
                        formStatus.innerHTML = '<i class="fa-solid fa-triangle-exclamation text-base mr-1.5"></i> ' + (err.message || 'Có lỗi xảy ra khi gửi. Vui lòng liên hệ hotline 1900 888 999!');
                        formStatus.className = 'block p-4 rounded-xl text-xs sm:text-sm font-semibold bg-rose-50 dark:bg-rose-950/80 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800 animate-fade-in';
                    }
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = origHtml;
                }
            });
        }
    });
</script>

@endsection
