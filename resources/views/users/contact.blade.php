@extends('users.master')

@section('home')
<style>
    .contact-container {
        font-family: 'Roboto', sans-serif;
    }

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
                <div class="premium-card p-8 group">
                    <div class="icon-box bg-blue-50 text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white group-hover:rotate-6">
                        <i class="fas fa-map-location-dot text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-3 ">Văn phòng chính</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">
                        98 phố Dương Quảng Hàm, Nghĩa Đô, Cầu Giấy, Hà Nội
                    </p>
                </div>

                {{-- Phone --}}
                <div class="premium-card p-8 group">
                    <div class="icon-box bg-emerald-50 text-emerald-600 mb-6 group-hover:bg-emerald-600 group-hover:text-white group-hover:rotate-6">
                        <i class="fas fa-phone-volume text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 ">Hotline Tư vấn</h3>
                    <p class="text-slate-400 text-xs font-bold   mb-2">Miễn phí 24/7</p>
                    <a href="tel:1900123456" class="text-2xl font-bold text-slate-900 hover:text-blue-600 transition-colors er">
                        1900 123 456
                    </a>
                </div>

                {{-- Email --}}
                <div class="premium-card p-8 group">
                    <div class="icon-box bg-violet-50 text-violet-600 mb-6 group-hover:bg-violet-600 group-hover:text-white group-hover:rotate-6">
                        <i class="fas fa-envelope-open-text text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 ">Email tư vấn & hỗ trợ</h3>
                    <p class="text-slate-400 text-xs font-bold   mb-2">Phản hồi nhanh</p>
                    <a href="mailto:hello@wandervibe.me" class="text-lg font-bold text-slate-900 hover:text-emerald-600 transition-colors">
                        hello@wandervibe.me
                    </a>
                </div>
            </div>

            <!-- RIGHT: CONTACT FORM -->
            <div class="lg:col-span-8">
                <div class="premium-card p-10 md:p-14 bg-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-blue-500/5 blur-[80px] rounded-full"></div>

                    <div class="relative z-10">
                        <h2 class="text-3xl font-bold text-slate-900 mb-2  ">Gửi yêu cầu <span class="text-blue-600">tư vấn</span></h2>
                        <p class="text-slate-400 text-sm font-medium mb-12  ">Chúng tôi sẽ liên hệ lại trong vòng 30 phút</p>

                        <form id="contactForm" method="POST" action="{{ route('consultation.send') }}" class="space-y-8">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="group">
                                    <label class="text-sm font-bold   text-slate-400 mb-3 block ml-2">Họ và tên *</label>
                                    <input type="text" name="name" required placeholder="VD: Nguyễn Văn A"
                                        class="w-full bg-slate-50 input-modern rounded-2xl py-4 px-6 text-sm font-bold text-slate-900 placeholder:text-slate-300 placeholder:font-medium">
                                </div>
                                <div class="group">
                                    <label class="text-sm font-bold   text-slate-400 mb-3 block ml-2">Số điện thoại *</label>
                                    <input type="tel" name="phone" required placeholder="09xx xxx xxx"
                                        class="w-full bg-slate-50 input-modern rounded-2xl py-4 px-6 text-sm font-bold text-slate-900 placeholder:text-slate-300 placeholder:font-medium">
                                </div>
                            </div>

                            <div class="group">
                                <label class="text-sm font-bold   text-slate-400 mb-3 block ml-2">Địa chỉ Email</label>
                                <input type="email" name="email" placeholder="example@email.com"
                                    class="w-full bg-slate-50 input-modern rounded-2xl py-4 px-6 text-sm font-bold text-slate-900 placeholder:text-slate-300 placeholder:font-medium">
                            </div>

                            <div class="group">
                                <label class="text-sm font-bold   text-slate-400 mb-3 block ml-2">Loại hình Tour quan tâm</label>
                                <div class="relative">
                                    <select name="tour_type" class="w-full bg-slate-50 input-modern rounded-2xl py-4 px-6 text-sm font-bold text-slate-900 appearance-none cursor-pointer">
                                        <option value="">Chọn loại tour</option>
                                        <option value="Du lịch Trong nước">Du lịch Trong nước</option>
                                        <option value="Du lịch Nước ngoài">Du lịch Nước ngoài</option>
                                        <option value="Tour thiết kế riêng">Tour thiết kế riêng </option>
                                        <option value="Tour ghép theo đoàn">Tour ghép theo đoàn </option>
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                                </div>
                            </div>

                            <div class="group">
                                <label class="text-sm font-bold   text-slate-400 mb-3 block ml-2">Lời nhắn của bạn</label>
                                <textarea name="message" rows="5" placeholder="Hãy cho chúng tôi biết nhu cầu hoặc thắc mắc của bạn..."
                                    class="w-full bg-slate-50 input-modern rounded-[2rem] py-5 px-6 text-sm font-bold text-slate-900 placeholder:text-slate-300 placeholder:font-medium resize-none"></textarea>
                            </div>

                            <div id="formStatus" class="hidden p-5 rounded-2xl text-sm font-bold animate-fade-in"></div>

                            <button type="submit" id="contactSubmitBtn"
                                class="btn-gradient w-full text-white font-bold py-5 rounded-[2rem] text-lg shadow-xl shadow-blue-100 flex items-center justify-center gap-3">
                                Gửi yêu cầu ngay <i class="fas fa-paper-plane text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Map / Social Support --}}
        <div class="mt-20 premium-card p-10 flex flex-col md:flex-row items-center justify-between gap-8 bg-gradient-to-br from-slate-900 to-slate-800 text-white">
            <div>
                <h4 class="text-2xl font-bold text-white mb-2">Theo dõi hành trình của <span class="text-emerald-400">WanderVibe</span></h4>
                <p class="text-slate-400 text-sm font-medium">Cập nhật những điểm đến mới nhất và ưu đãi độc quyền hàng ngày.</p>
            </div>
            <div class="flex gap-4 text-slate-900">
                <a href="#" class="w-14 h-14 bg-white/5 rounded-2xl flex items-center justify-center text-xl hover:bg-blue-600 transition-all duration-500 border border-white/5 hover:border-blue-500">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="w-14 h-14 bg-white/5 rounded-2xl flex items-center justify-center text-xl hover:bg-pink-600 transition-all duration-500 border border-white/5 hover:border-pink-500">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="w-14 h-14 bg-white/5 rounded-2xl flex items-center justify-center text-xl hover:bg-slate-700 transition-all duration-500 border border-white/5 hover:border-white/20">
                    <i class="fab fa-tiktok"></i>
                </a>
                <a href="#" class="w-14 h-14 bg-white/5 rounded-2xl flex items-center justify-center text-xl hover:bg-emerald-600 transition-all duration-500 border border-white/5 hover:border-emerald-500">
                    <i class="fab fa-whatsapp"></i>
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
                submitBtn.innerHTML = 'Đang gửi yêu cầu... <i class="fas fa-spinner fa-spin text-sm"></i>';

                if (formStatus) {
                    formStatus.classList.add('hidden');
                    formStatus.className = 'hidden p-5 rounded-2xl text-sm font-bold animate-fade-in';
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
                            formStatus.textContent = data.message || 'Cảm ơn bạn! Yêu cầu tư vấn đã được gửi thành công. Chuyên viên WanderVibe sẽ liên hệ lại trong vòng 30 phút!';
                            formStatus.className = 'block p-5 rounded-2xl text-sm font-bold animate-fade-in bg-emerald-50 text-emerald-700 border border-emerald-200';
                        }
                        form.reset();
                    } else {
                        throw new Error(data.message || 'Không thể gửi yêu cầu lúc này.');
                    }
                } catch (err) {
                    if (formStatus) {
                        formStatus.textContent = err.message || 'Có lỗi xảy ra khi gửi. Vui lòng liên hệ hotline 1900 123 456!';
                        formStatus.className = 'block p-5 rounded-2xl text-sm font-bold animate-fade-in bg-rose-50 text-rose-700 border border-rose-200';
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
