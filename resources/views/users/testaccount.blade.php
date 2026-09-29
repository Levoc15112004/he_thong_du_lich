<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hành Trình Mới - TravelGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            overflow-x: hidden;
        }

        .auth-wrapper {
            transition: all 0.7s cubic-bezier(0.645, 0.045, 0.355, 1);
        }

        /* Hiệu ứng trượt cho Desktop */
        @media (min-width: 1024px) {
            .state-register .image-side {
                transform: translateX(100%);
            }

            .state-register .form-side {
                transform: translateX(-100%);
            }
        }

        .input-focus:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center lg:p-0">

    <!-- Container Chính -->
    <div id="main-container"
        class="relative w-full min-h-screen lg:h-[700px] lg:min-h-[700px] lg:max-w-[1100px] lg:rounded-[2.5rem] lg:shadow-2xl lg:overflow-hidden bg-white flex flex-col lg:flex-row transition-all duration-700">

        <!-- SIDE 1: HÌNH ẢNH (Mặc định bên trái) -->
        <div
            class="image-side hidden lg:flex lg:w-1/2 relative bg-blue-900 overflow-hidden z-20 transition-transform duration-700 ease-in-out order-1">
            <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&q=80&w=1920"
                class="absolute inset-0 w-full h-full object-cover opacity-70" alt="Travel background">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/40 to-black/70"></div>

            <div class="relative z-10 w-full p-16 flex flex-col justify-between text-white">
                <div>
                    <div class="flex items-center gap-2 mb-8 animate-float">
                        <div class="bg-white/20 backdrop-blur-md p-2 rounded-xl">
                            <i data-lucide="palmtree" class="w-8 h-8 text-white"></i>
                        </div>
                        <span class="text-2xl font-extrabold ">TravelGo</span>
                    </div>
                    <div id="image-content">
                        <h2 class="text-5xl font-bold leading-tight mb-6">Khám phá <br> những chân trời.</h2>
                        <p class="text-blue-100 text-lg max-w-md leading-relaxed">
                            Cùng TravelGo viết nên câu chuyện du lịch tuyệt vời nhất của bạn tại những vùng đất mới.
                        </p>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-lg p-6 rounded-2xl border border-white/10">
                    <div class="flex items-center gap-4">
                        <div class="flex -space-x-3">
                            <img src="https://i.pravatar.cc/40?img=11"
                                class="w-10 h-10 rounded-full border-2 border-white shadow-sm" alt="User">
                            <img src="https://i.pravatar.cc/40?img=12"
                                class="w-10 h-10 rounded-full border-2 border-white shadow-sm" alt="User">
                            <img src="https://i.pravatar.cc/40?img=13"
                                class="w-10 h-10 rounded-full border-2 border-white shadow-sm" alt="User">
                        </div>
                        <p class="text-sm font-medium text-blue-50">Hơn 2,000 khách hàng hài lòng mỗi tháng</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SIDE 2: FORM (Mặc định bên phải) -->
        <div
            class="form-side w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 bg-white z-10 transition-transform duration-700 ease-in-out order-2">
            <div class="w-full max-w-md">

                <!-- Logo Mobile -->
                <div class="lg:hidden flex items-center justify-center gap-2 mb-8">
                    <div class="bg-blue-600 p-2 rounded-xl">
                        <i data-lucide="palmtree" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="text-2xl font-bold text-slate-900 ">TravelGo</span>
                </div>

                <!-- LOGIN FORM SECTION -->
                <div id="login-section" class="fade-in">
                    <div class="mb-8">
                        <h3 class="text-3xl font-extrabold text-slate-900 mb-2">Đăng nhập</h3>
                        <p class="text-slate-500 font-medium">Chào mừng bạn trở lại với những chuyến đi.</p>
                    </div>

                    <a href="{{ route('google.login') }}"  onclick="handleGoogleLogin()"
                        class="w-full flex items-center justify-center gap-3 bg-white border border-slate-200 py-3.5 px-4 rounded-2xl font-semibold text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-all mb-6 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                            <path fill="#4285F4"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        Google
                    </a>

                    <div class="relative mb-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-100"></div>
                        </div>
                        <div class="relative flex justify-center text-xs "><span
                                class="px-3 bg-white text-slate-400 font-bold">Hoặc Email</span></div>
                    </div>

                    <form class="space-y-5"action="{{ route('user.login') }}" method="POST">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Email</label>
                            <div class="relative group">
                                <i data-lucide="mail"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                                <input type="email" name="email" placeholder="email@gmail.com"
                                    class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none input-focus text-slate-900 font-medium">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Mật khẩu</label>
                            <div class="relative group">
                                <i data-lucide="lock"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                                <input id="login-pass" type="password" name="password" placeholder="********"
                                    class="w-full pl-12 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none input-focus text-slate-900 font-medium">
                                <button type="button" onclick="togglePassword('login-pass', this)"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 transition-colors">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center justify-between px-1">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" name="remember"
                                    class="w-5 h-5 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500/20 cursor-pointer">
                                <span
                                    class="text-sm font-semibold text-slate-600 group-hover:text-slate-900 transition-colors">Ghi
                                    nhớ</span>
                            </label>
                            <a href="{{ route('password.request') }}"
                                class="text-sm font-bold text-blue-600 hover:text-blue-700 underline decoration-2 underline-offset-4 transition-all">Quên
                                mật khẩu?</a>
                        </div>
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center justify-center gap-2 mt-4">
                            <span>Đăng nhập</span>
                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </button>
                    </form>

                    <p class="text-center mt-10 text-sm font-semibold text-slate-500">
                        Chưa có tài khoản?
                        <button onclick="switchState('register')"
                            class="text-blue-600 font-extrabold hover:text-blue-700 ml-1 transition-colors">Đăng ký
                            ngay</button>
                    </p>
                </div>

                <!-- REGISTER FORM SECTION -->
                <div id="register-section" class="hidden fade-in">
                    <div class="mb-8">
                        <h3 class="text-3xl font-extrabold text-slate-900 mb-2">Tạo tài khoản</h3>
                        <p class="text-slate-500 font-medium">Bắt đầu những hành trình mới cùng chúng tôi.</p>
                    </div>

                    <form class="space-y-4"action="{{ route('user.register') }}" method="POST">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Họ và tên</label>
                            <div class="relative group">
                                <i data-lucide="user"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                                <input type="text" name="name" placeholder="Nguyễn Văn A"
                                    class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl outline-none input-focus text-slate-900 font-medium">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Email</label>
                            <div class="relative group">
                                <i data-lucide="mail"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                                <input type="email" name="email" placeholder="name@email.com"
                                    class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl outline-none input-focus text-slate-900 font-medium">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Mật khẩu</label>
                            <div class="relative group">
                                <i data-lucide="lock"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                                <input id="reg-pass" type="password" name="password" placeholder="Tối thiểu 8 ký tự"
                                    class="w-full pl-12 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-2xl outline-none input-focus text-slate-900 font-medium">
                                <button type="button" onclick="togglePassword('reg-pass', this)"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <input type="checkbox" id="terms"
                                class="mt-1 w-5 h-5 rounded-lg border-slate-300 text-blue-600 cursor-pointer">
                            <label for="terms"
                                class="text-xs font-semibold text-slate-500 leading-relaxed cursor-pointer">
                                Tôi đồng ý với <a href="#" class="text-blue-600 underline">Điều khoản</a> & <a
                                    href="#" class="text-blue-600 underline">Chính sách bảo mật</a>.
                            </label>
                        </div>
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 active:translate-y-0 transition-all mt-2">
                            Đăng ký tài khoản
                        </button>
                    </form>

                    <p class="text-center mt-8 text-sm font-semibold text-slate-500">
                        Đã có tài khoản?
                        <button onclick="switchState('login')"
                            class="text-blue-600 font-extrabold hover:text-blue-700 ml-1 transition-colors">Đăng nhập
                            ngay</button>
                    </p>
                </div>

            </div>
        </div>

    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-8 right-8 translate-x-32 opacity-0 transition-all duration-500 z-50">
        <div class="bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-blue-400"></i>
            <p id="toast-msg" class="text-sm font-bold"></p>
        </div>
    </div>

    <script>
        lucide.createIcons();

        const container = document.getElementById('main-container');
        const loginSec = document.getElementById('login-section');
        const registerSec = document.getElementById('register-section');
        const imgContent = document.getElementById('image-content');

        function switchState(state) {
            if (state === 'register') {
                container.classList.add('state-register');

                // Hiệu ứng mờ dần nội dung form
                loginSec.classList.add('hidden');
                registerSec.classList.remove('hidden');

                // Thay đổi nội dung bên ảnh
                imgContent.innerHTML = `
                    <h2 class="text-5xl font-bold leading-tight mb-6">Trải nghiệm <br> mới đang chờ.</h2>
                    <p class="text-blue-100 text-lg max-w-md leading-relaxed">
                        Chỉ mất 30 giây để bắt đầu một hành trình thay đổi cuộc đời bạn. Đăng ký ngay hôm nay!
                    </p>
                `;
            } else {
                container.classList.remove('state-register');

                registerSec.classList.add('hidden');
                loginSec.classList.remove('hidden');

                // Quay lại nội dung cũ bên ảnh
                imgContent.innerHTML = `
                    <h2 class="text-5xl font-bold leading-tight mb-6">Khám phá <br> những chân trời.</h2>
                    <p class="text-blue-100 text-lg max-w-md leading-relaxed">
                        Cùng TravelGo viết nên câu chuyện du lịch tuyệt vời nhất của bạn tại những vùng đất mới.
                    </p>
                `;
            }
            lucide.createIcons();
        }

        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-msg').innerText = msg;
            toast.classList.replace('translate-x-32', 'translate-x-0');
            toast.classList.replace('opacity-0', 'opacity-100');
            setTimeout(() => {
                toast.classList.replace('translate-x-0', 'translate-x-32');
                toast.classList.replace('opacity-100', 'opacity-0');
            }, 3000);
        }

        function handleGoogleLogin() {
            showToast('Đang kết nối với Google...');
        }

        // Chặn submit mặc định để demo toast
        document.querySelectorAll('form').forEach(form => {
            form.onsubmit = (e) => {
                e.preventDefault();
                showToast('Hệ thống đang xử lý yêu cầu...');
            }
        });
    </script>
</body>

</html>
