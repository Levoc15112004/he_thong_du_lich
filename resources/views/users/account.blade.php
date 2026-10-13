<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WanderVibe - Đăng Nhập / Đăng Ký</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'blob': "blob 7s infinite",
                    }
                }
            }
        }
    </script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }

        .auth-wrapper {
            transition: all 0.7s cubic-bezier(0.645, 0.045, 0.355, 1);
        }

        @media (min-width: 1024px) {
            .state-register .image-side { transform: translateX(100%); }
            .state-register .form-side { transform: translateX(-100%); }
            .state-register .image-overlay {
                background: linear-gradient(135deg, rgba(16, 185, 129, 0.8), rgba(15, 23, 42, 0.9));
            }
        }

        .input-focus:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .fade-in {
            animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .bg-scenic {
            background-image: url('https://images.unsplash.com/photo-1599423300746-b62533397364?auto=format&fit=crop&q=80&w=2070');
            background-size: cover;
            background-position: center;
        }

        .glass-morphism {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</head>

<body class="bg-scenic min-h-screen relative flex items-center justify-center p-4 sm:p-8">

    <!-- Abstract Background Overlays -->
    <div class="absolute inset-0 bg-slate-900/40"></div>

    <!-- Back to Home Button -->
    <a href="{{ url('/') }}" class="absolute top-6 left-6 lg:top-8 lg:left-8 z-50 flex items-center gap-2 bg-white/20 hover:bg-white/30 backdrop-blur-md px-4 py-2 rounded-full text-white font-medium transition-all group">
        <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
        <span>Về trang chủ</span>
    </a>

    <!-- Container Chính -->
    <div id="main-container" class="relative z-10 w-full max-w-[1200px] min-h-[680px] lg:h-[720px] rounded-[2.5rem] shadow-2xl overflow-hidden glass-morphism flex flex-col lg:flex-row transition-all duration-700">

        <!-- SIDE 1: HÌNH ẢNH (Mặc định bên trái) -->
        <div class="image-side hidden lg:flex lg:w-[55%] relative overflow-hidden z-20 transition-all duration-700 ease-in-out order-1">
            <img src="https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&q=80&w=2070" 
                 class="absolute inset-0 w-full h-full object-cover" alt="Travel Vibes">
                 
            <div class="image-overlay absolute inset-0 bg-gradient-to-tr from-slate-900/90 to-orange-950/70 transition-colors duration-700"></div>

            <div class="relative z-10 w-full p-16 flex flex-col justify-between text-white">
                <div>
                    <div class="flex items-center gap-3 mb-10 animate-float">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-lg flex items-center justify-center border border-white/20 shadow-xl">
                            <i class="fa-solid fa-compass text-2xl text-orange-400"></i>
                        </div>
                        <span class="text-3xl font-bold tracking-tight">WanderVibe</span>
                    </div>
                    
                    <div id="image-content" class="transition-all duration-500">
                        <h2 class="text-5xl font-bold leading-tight mb-6">Mở khóa <br><span class="text-orange-400">cửa sổ</span> thế giới.</h2>
                        <p class="text-slate-200 text-lg max-w-md leading-relaxed font-medium">
                            Hệ sinh thái du lịch dành cho thế hệ trẻ. Trải nghiệm những chuyến đi cảm xúc, gắn kết và mang đậm dấu ấn cá nhân.
                        </p>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-xl p-6 rounded-3xl border border-white/20 shadow-2xl">
                    <div class="flex items-center gap-5">
                        <div class="flex -space-x-4">
                            <img src="https://i.pravatar.cc/100?img=11" class="w-12 h-12 rounded-full border-2 border-slate-900 shadow-sm" alt="User">
                            <img src="https://i.pravatar.cc/100?img=12" class="w-12 h-12 rounded-full border-2 border-slate-900 shadow-sm" alt="User">
                            <img src="https://i.pravatar.cc/100?img=13" class="w-12 h-12 rounded-full border-2 border-slate-900 shadow-sm" alt="User">
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white mb-0.5">Tham gia cùng cộng đồng</p>
                            <p class="text-xs font-semibold text-orange-300">+2,000 khách hàng hài lòng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SIDE 2: FORM (Mặc định bên phải) -->
        <div class="form-side w-full lg:w-[45%] flex flex-col items-center justify-center p-8 lg:p-14 z-10 transition-transform duration-700 ease-in-out order-2 relative bg-white">
            
            <div class="w-full max-w-[380px]">
                
                <!-- Logo Mobile -->
                <div class="lg:hidden flex items-center justify-center gap-2.5 mb-10">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-orange-500 to-rose-500 flex items-center justify-center text-white shadow-lg">
                        <i class="fa-solid fa-compass text-lg"></i>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-slate-900">WanderVibe</span>
                </div>

                <!-- ======== LOGIN SECTION ======== -->
                <div id="login-section" class="fade-in">
                    <div class="mb-8 text-left">
                        <h3 class="text-3xl font-bold text-slate-900 mb-2">Đăng nhập</h3>
                        <p class="text-slate-500 font-medium">Chào mừng bạn trở lại! Bắt đầu chuyến đi mới.</p>
                    </div>

                    {{-- ALERTS --}}
                    @if (session('error'))
                        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 flex items-start gap-3 shadow-sm text-sm font-semibold">
                            <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5 text-base shrink-0"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                    @elseif (session('success'))
                        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-start gap-3 shadow-sm text-sm font-semibold">
                            <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 text-base shrink-0"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @elseif ($errors->has('login_error'))
                        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 flex items-start gap-3 shadow-sm text-sm font-semibold">
                            <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5 text-base shrink-0"></i>
                            <div>{{ $errors->first('login_error') }}</div>
                        </div>
                    @endif

                    <a href="{{ route('google.login') }}"
                        class="w-full flex items-center justify-center gap-3 bg-white border-2 border-slate-100 py-3.5 px-4 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 hover:border-slate-200 hover:-translate-y-0.5 transition-all mb-8 shadow-sm">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        Tiếp tục với tài khoản Google
                    </a>

                    <div class="relative mb-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="px-4 bg-white text-slate-400 font-bold uppercase tracking-wider">Hoặc Email</span>
                        </div>
                    </div>

                    <form action="{{ route('user.login') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="space-y-1.5">
                            <label class="text-sm font-bold text-slate-700 block">Địa chỉ Email</label>
                            <div class="relative group">
                                <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-orange-500 transition-colors"></i>
                                <input type="email" name="email" placeholder="Nhập email của bạn" required
                                    class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none input-focus text-slate-900 font-semibold focus:bg-white transition-colors">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-sm font-bold text-slate-700 block">Mật khẩu</label>
                            <div class="relative group">
                                <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-orange-500 transition-colors"></i>
                                <input id="login-pass" type="password" name="password" placeholder="••••••••" required
                                    class="w-full pl-11 pr-11 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl outline-none input-focus text-slate-900 font-semibold focus:bg-white transition-colors">
                                <button type="button" onclick="togglePassword('login-pass', this)"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-orange-600 transition-colors cursor-pointer">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-1 pb-2">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-orange-500 focus:ring-orange-500/20 cursor-pointer">
                                <span class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">Ghi nhớ đăng nhập</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="text-sm font-bold text-orange-600 hover:text-orange-700 transition-all">Quên mật khẩu?</a>
                        </div>
                        
                        <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-rose-500 text-white py-4 rounded-2xl font-bold shadow-lg shadow-orange-500/30 hover:from-orange-600 hover:to-rose-600 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                            <span>Đăng Nhập</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </form>

                    <p class="text-center mt-10 text-sm font-semibold text-slate-500">
                        Bạn chưa có tài khoản?
                        <button onclick="switchState('register')" class="text-orange-600 font-extrabold hover:text-orange-700 ml-1 transition-colors underline decoration-2 underline-offset-4">Đăng ký ngay</button>
                    </p>
                </div>

                <!-- ======== REGISTER SECTION ======== -->
                <div id="register-section" class="hidden fade-in">
                    <div class="mb-6 text-left">
                        <h3 class="text-3xl font-bold text-slate-900 mb-2">Tạo tài khoản</h3>
                        <p class="text-slate-500 font-medium">Gia nhập cộng đồng WanderVibe ngay hôm nay.</p>
                    </div>

                    {{-- ALERTS CHO ĐĂNG KÝ --}}
                    @if ($errors->any() && !$errors->has('login_error'))
                        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 flex items-start gap-3 shadow-sm text-sm font-semibold">
                            <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5 text-base shrink-0"></i>
                            <div>{{ $errors->first() }}</div>
                        </div>
                    @endif

                    <a href="{{ route('google.login') }}"
                        class="w-full flex items-center justify-center gap-3 bg-white border-2 border-slate-100 py-3 px-4 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 hover:border-slate-200 hover:-translate-y-0.5 transition-all mb-5 shadow-sm text-sm">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        Đăng ký nhanh với Google
                    </a>

                    <div class="relative mb-5">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="px-4 bg-white text-slate-400 font-bold uppercase tracking-wider">Hoặc điền thông tin</span>
                        </div>
                    </div>

                    <form action="{{ route('user.register') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="space-y-1.5">
                            <label class="text-sm font-bold text-slate-700 block">Họ và tên</label>
                            <div class="relative group">
                                <i class="fa-regular fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-orange-500 transition-colors"></i>
                                <input type="text" name="name" placeholder="Ví dụ: Nguyễn Văn A" required
                                    class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl outline-none input-focus text-slate-900 font-semibold focus:bg-white transition-colors">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-sm font-bold text-slate-700 block">Địa chỉ Email</label>
                            <div class="relative group">
                                <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-orange-500 transition-colors"></i>
                                <input type="email" name="email" placeholder="example@gmail.com" required
                                    class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl outline-none input-focus text-slate-900 font-semibold focus:bg-white transition-colors">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-sm font-bold text-slate-700 block">Mật khẩu</label>
                            <div class="relative group">
                                <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-orange-500 transition-colors"></i>
                                <input id="reg-pass" type="password" name="password" placeholder="Tối thiểu 8 ký tự" required
                                    class="w-full pl-11 pr-11 py-3 bg-slate-50 border border-slate-200 rounded-2xl outline-none input-focus text-slate-900 font-semibold focus:bg-white transition-colors">
                                <button type="button" onclick="togglePassword('reg-pass', this)"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-orange-500 transition-colors">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3.5 bg-orange-50 rounded-xl border border-orange-100">
                            <input type="checkbox" id="terms" required class="mt-0.5 w-4 h-4 rounded border-orange-300 text-orange-600 cursor-pointer focus:ring-orange-500">
                            <label for="terms" class="text-xs font-semibold text-orange-900 leading-relaxed cursor-pointer">
                                Tôi đồng ý với <a href="#" class="text-orange-600 hover:underline">Điều khoản Dịch vụ</a> & <a href="#" class="text-orange-600 hover:underline">Chính sách bảo mật</a>.
                            </label>
                        </div>
                        
                        <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold shadow-lg shadow-slate-900/20 hover:bg-slate-800 hover:-translate-y-0.5 transition-all mt-4 flex items-center justify-center gap-2">
                            <span>Tạo Tài Khoản Mới</span>
                            <i class="fa-solid fa-user-plus text-xs"></i>
                        </button>
                    </form>

                    <p class="text-center mt-8 text-sm font-semibold text-slate-500">
                        Đã có tài khoản?
                        <button onclick="switchState('login')" class="text-orange-600 font-extrabold hover:text-orange-700 ml-1 transition-colors underline decoration-2 underline-offset-4">Đăng nhập ngay</button>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- UI Scripts -->
    <script>
        const container = document.getElementById('main-container');
        const loginSec = document.getElementById('login-section');
        const registerSec = document.getElementById('register-section');
        const imgContent = document.getElementById('image-content');

        function switchState(state) {
            if (state === 'register') {
                container.classList.add('state-register');
                loginSec.classList.add('hidden');
                registerSec.classList.remove('hidden');

                // Animate text transition
                imgContent.style.opacity = '0';
                setTimeout(() => {
                    imgContent.innerHTML = `
                        <h2 class="text-5xl font-bold leading-tight mb-6">Trải nghiệm <br><span class="text-orange-400">mới</span> chờ bạn.</h2>
                        <p class="text-slate-100 text-lg max-w-md leading-relaxed font-medium">
                            Chỉ mất 30 giây để bắt đầu. Hãy để chúng tôi đồng hành cùng bạn trên mọi nẻo đường xinh đẹp nhất!
                        </p>
                    `;
                    imgContent.style.opacity = '1';
                }, 300);

            } else {
                container.classList.remove('state-register');
                registerSec.classList.add('hidden');
                loginSec.classList.remove('hidden');

                imgContent.style.opacity = '0';
                setTimeout(() => {
                    imgContent.innerHTML = `
                        <h2 class="text-5xl font-bold leading-tight mb-6">Mở khóa <br><span class="text-orange-400">cửa sổ</span> thế giới.</h2>
                        <p class="text-slate-200 text-lg max-w-md leading-relaxed font-medium">
                            Hệ sinh thái du lịch dành cho thế hệ trẻ. Trải nghiệm những chuyến đi cảm xúc, gắn kết và mang đậm dấu ấn cá nhân.
                        </p>
                    `;
                    imgContent.style.opacity = '1';
                }, 300);
            }
        }

        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        @if ($errors->any() && !$errors->has('login_error'))
            document.addEventListener('DOMContentLoaded', () => switchState('register'));
        @endif
    </script>
</body>
</html>
