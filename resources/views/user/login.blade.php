<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký & Đăng nhập | Wanderlust</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: '#0ea5e9', // Sky blue
                        secondary: '#10b981', // Emerald green
                        dark: '#0f172a',
                    },
                    boxShadow: {
                        'soft': '0 10px 40px -10px rgba(0,0,0,0.08)',
                    }
                }
            }
        }
    </script>
    <style>
        /* Hiệu ứng focus cho input */
        .input-field:focus-within {
            box-shadow: 0 0 0 2px rgba(14, 165, 233, 0.2);
            border-color: #0ea5e9;
            background-color: #ffffff;
        }

        /* Tùy chỉnh thanh cuộn */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Grid layout để ép 2 form nằm chồng lên nhau ở cùng 1 vị trí */
        .form-grid-container {
            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: 1fr;
        }
        .form-panel {
            grid-area: 1 / 1;
        }
    </style>
</head>
<body class="font-sans text-gray-700 antialiased selection:bg-primary selection:text-white min-h-screen flex items-center justify-center relative bg-dark py-10 md:py-16">

    <!-- Background Image với hiệu ứng mờ -->
    <div class="fixed inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" alt="Travel Background" class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-b from-dark/90 via-dark/70 to-dark/90"></div>
    </div>

    <!-- Nút quay lại trang chủ -->
    <a href="{{ route('user.home') }}" class="absolute top-6 left-6 z-20 text-white/70 hover:text-white flex items-center transition-colors font-medium">
        <div class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center mr-3 hover:bg-white/20 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </div>
        Về trang chủ
    </a>

    <!-- Khung Card Main -->
    <div class="w-full max-w-5xl bg-white rounded-[2rem] shadow-2xl flex flex-col md:flex-row overflow-hidden z-10 mx-4 relative min-h-[600px]">

        <!-- CỘT TRÁI: Hình ảnh minh họa (Chỉ hiện trên Desktop) -->
        <div class="hidden md:block md:w-5/12 relative bg-dark">
            <img src="{{ asset('assets/images/user/login.jpeg') }}" alt="Hội An" class="w-full h-full object-cover opacity-80">
            <div class="absolute inset-0 bg-gradient-to-t from-dark/90 via-dark/20 to-transparent"></div>

            <div class="absolute bottom-12 left-10 right-10">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center mr-3">
                        <i class="fa-solid fa-plane-departure text-white text-xl"></i>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-white">Wander<span class="text-primary">lust</span></span>
                </div>
                <h3 class="text-3xl font-bold text-white mb-2 leading-tight">Bắt đầu hành trình của bạn</h3>
                <p class="text-gray-300 text-sm">Khám phá những điểm đến tuyệt vời với hàng ngàn ưu đãi độc quyền dành riêng cho thành viên.</p>
            </div>
        </div>

        <!-- CỘT PHẢI: Khu vực Form Động -->
        <div class="w-full md:w-7/12 p-8 md:p-12 flex flex-col relative bg-white">

            <!-- Logo cho Mobile -->
            <div class="flex items-center mb-8 md:hidden justify-center">
                <i class="fa-solid fa-plane-departure text-primary text-3xl mr-3"></i>
                <span class="font-bold text-3xl tracking-tight text-dark">Wander<span class="text-primary">lust</span></span>
            </div>

            <!-- Thanh Toggle Chuyển Đổi (Đăng nhập / Đăng ký) -->
            <div class="bg-gray-100 p-1.5 rounded-2xl flex relative mb-8 max-w-sm mx-auto w-full">
                <!-- Cục trượt background -->
                <div id="tab-slider" class="absolute h-[calc(100%-12px)] w-[calc(50%-6px)] bg-white rounded-xl shadow-sm transition-transform duration-300 ease-in-out top-1.5 left-1.5"></div>

                <button onclick="switchTab('login')" id="btn-login" class="flex-1 py-2.5 text-sm font-bold text-dark relative z-10 transition-colors">Đăng Nhập</button>
                <button onclick="switchTab('register')" id="btn-register" class="flex-1 py-2.5 text-sm font-bold text-gray-500 relative z-10 transition-colors">Tạo Tài Khoản</button>
            </div>

            <!-- Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 max-w-sm mx-auto w-full" role="alert">
                    <span class="block sm:inline text-sm">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 max-w-sm mx-auto w-full" role="alert">
                    <span class="block sm:inline text-sm">{{ session('error') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 max-w-sm mx-auto w-full" role="alert">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Vùng chứa các Form (Dùng CSS Grid để đè lên nhau) -->
            <div class="form-grid-container flex-grow relative items-start">

                <!-- ================= FORM ĐĂNG NHẬP (Mặc định hiển thị) ================= -->
                <div id="form-login" class="form-panel transition-all duration-500 ease-in-out transform opacity-100 translate-x-0 scale-100 z-10 pointer-events-auto">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-dark mb-2">Chào mừng trở lại!</h2>
                        <p class="text-gray-500 text-sm">Đăng nhập để quản lý các chuyến đi của bạn.</p>
                    </div>

                    <form action="{{ route('user.login') }}" method="POST" class="space-y-5 max-w-sm mx-auto">
                        @csrf
                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-bold text-dark mb-1.5 uppercase tracking-wide">Email</label>
                            <div class="relative flex items-center input-field border border-gray-200 rounded-xl bg-gray-50 transition-all overflow-hidden">
                                <i class="fa-regular fa-envelope absolute left-4 text-gray-400"></i>
                                <input type="email" name="email" value="{{ old('email') ?? '' }}" required placeholder="Nhập địa chỉ email" class="w-full bg-transparent py-3.5 pl-11 pr-4 text-sm text-dark focus:outline-none">
                            </div>
                        </div>

                        <!-- Mật khẩu -->
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <label class="block text-xs font-bold text-dark uppercase tracking-wide">Mật khẩu</label>
                                <a href="#" class="text-xs font-semibold text-primary hover:underline">Quên mật khẩu?</a>
                            </div>
                            <div class="relative flex items-center input-field border border-gray-200 rounded-xl bg-gray-50 transition-all overflow-hidden">
                                <i class="fa-solid fa-lock absolute left-4 text-gray-400"></i>
                                <input type="password" name="password" id="login-password" required placeholder="Nhập mật khẩu" class="w-full bg-transparent py-3.5 pl-11 pr-10 text-sm text-dark focus:outline-none">
                                <button type="button" onclick="togglePassword('login-password', 'login-eye-icon')" class="absolute right-4 text-gray-400 hover:text-primary transition-colors">
                                    <i class="fa-regular fa-eye-slash" id="login-eye-icon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Ghi nhớ đăng nhập -->
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary cursor-pointer">
                            <label for="remember" class="ml-2 text-sm text-gray-600 cursor-pointer">Ghi nhớ đăng nhập</label>
                        </div>

                        <!-- Nút Submit -->
                        <button type="submit" class="w-full bg-primary hover:bg-sky-600 text-white font-bold py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-sky-500/30 hover:shadow-sky-500/50 transform hover:-translate-y-0.5 mt-2">
                            Đăng Nhập
                        </button>
                    </form>

                    <!-- Hoặc đăng nhập bằng -->
                    <div class="mt-8 max-w-sm mx-auto">
                        <div class="relative flex py-3 items-center">
                            <div class="flex-grow border-t border-gray-100"></div>
                            <span class="flex-shrink-0 mx-4 text-gray-400 text-xs font-medium uppercase tracking-wider">Hoặc tiếp tục với</span>
                            <div class="flex-grow border-t border-gray-100"></div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <button type="button" class="flex items-center justify-center py-2.5 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                                <img src="https://cdn-icons-png.flaticon.com/512/3002/3002219.png" alt="Google" class="w-5 h-5 mr-2">
                                <span class="text-sm font-semibold text-gray-700">Google</span>
                            </button>
                            <button type="button" class="flex items-center justify-center py-2.5 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                                <img src="https://cdn-icons-png.flaticon.com/512/5968/5968764.png" alt="Facebook" class="w-5 h-5 mr-2">
                                <span class="text-sm font-semibold text-gray-700">Facebook</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ================= FORM ĐĂNG KÝ (Mặc định ẩn) ================= -->
                <div id="form-register" class="form-panel transition-all duration-500 ease-in-out transform opacity-0 translate-x-8 scale-95 z-0 pointer-events-none">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-dark mb-2">Tạo tài khoản mới</h2>
                        <p class="text-gray-500 text-sm">Nhận ngay voucher giảm giá 10% khi đăng ký thành viên.</p>
                    </div>

                    <form action="{{ route('user.register') }}" method="POST" class="space-y-4 max-w-sm mx-auto">
                        @csrf
                        <!-- Họ Tên -->
                        <div>
                            <label class="block text-xs font-bold text-dark mb-1.5 uppercase tracking-wide">Họ và tên</label>
                            <div class="relative flex items-center input-field border border-gray-200 rounded-xl bg-gray-50 transition-all overflow-hidden">
                                <i class="fa-regular fa-user absolute left-4 text-gray-400"></i>
                                <input type="text" name="name" value="{{ old('name') ?? '' }}" required placeholder="Nhập họ và tên" class="w-full bg-transparent py-3 pl-11 pr-4 text-sm text-dark focus:outline-none">
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-bold text-dark mb-1.5 uppercase tracking-wide">Email</label>
                            <div class="relative flex items-center input-field border border-gray-200 rounded-xl bg-gray-50 transition-all overflow-hidden">
                                <i class="fa-regular fa-envelope absolute left-4 text-gray-400"></i>
                                <input type="email" name="email" value="{{ old('email') ?? '' }}" required placeholder="email@domain.com" class="w-full bg-transparent py-3 pl-11 pr-4 text-sm text-dark focus:outline-none">
                            </div>
                        </div>

                        <!-- Số điện thoại -->
                        <div>
                            <label class="block text-xs font-bold text-dark mb-1.5 uppercase tracking-wide">Số điện thoại</label>
                            <div class="relative flex items-center input-field border border-gray-200 rounded-xl bg-gray-50 transition-all overflow-hidden">
                                <i class="fa-solid fa-phone absolute left-4 text-gray-400"></i>
                                <input type="tel" name="phone" value="{{ old('phone') ?? '' }}" required pattern="[0-9]{10}" placeholder="Nhập số điện thoại" class="w-full bg-transparent py-3 pl-11 pr-4 text-sm text-dark focus:outline-none">
                            </div>
                        </div>

                        <!-- Mật khẩu -->
                        <div>
                            <label class="block text-xs font-bold text-dark mb-1.5 uppercase tracking-wide">Mật khẩu</label>
                            <div class="relative flex items-center input-field border border-gray-200 rounded-xl bg-gray-50 transition-all overflow-hidden">
                                <i class="fa-solid fa-lock absolute left-4 text-gray-400"></i>
                                <input type="password" name="password" id="reg-password" required placeholder="Tạo mật khẩu (> 8 ký tự)" class="w-full bg-transparent py-3 pl-11 pr-10 text-sm text-dark focus:outline-none">
                                <button type="button" onclick="togglePassword('reg-password', 'reg-eye-icon')" class="absolute right-4 text-gray-400 hover:text-dark transition-colors">
                                    <i class="fa-regular fa-eye-slash" id="reg-eye-icon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Checkbox Điều khoản -->
                        <div class="flex items-start pt-2">
                            <input type="checkbox" id="terms" required class="mt-1 w-4 h-4 text-dark bg-gray-100 border-gray-300 rounded focus:ring-dark cursor-pointer">
                            <label for="terms" class="ml-2 text-xs text-gray-500 cursor-pointer">
                                Tôi đồng ý với các <a href="#" class="text-dark font-bold hover:underline">Điều khoản dịch vụ</a> và <a href="#" class="text-dark font-bold hover:underline">Chính sách bảo mật</a>.
                            </label>
                        </div>

                        <!-- Nút Submit -->
                        <button type="submit" class="w-full bg-dark hover:bg-gray-800 text-white font-bold py-3.5 rounded-xl transition-all duration-300 shadow-lg transform hover:-translate-y-0.5 mt-4">
                            Đăng Ký Tài Khoản
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any() && old('name'))
                // Nếu có lỗi và có trường name đã gửi -> form đăng ký lỗi
                switchTab('register');
            @else
                switchTab('login');
            @endif
        });

        // --- Logic Chuyển Đổi Tab (Đăng nhập / Đăng ký) ---
        function switchTab(tab) {
            const slider = document.getElementById('tab-slider');
            const btnLogin = document.getElementById('btn-login');
            const btnRegister = document.getElementById('btn-register');

            const formLogin = document.getElementById('form-login');
            const formRegister = document.getElementById('form-register');

            // Khai báo các trạng thái animation mượt mà (Slide + Scale + Fade)
            const activeState = ['opacity-100', 'translate-x-0', 'scale-100', 'z-10', 'pointer-events-auto'];
            const hiddenRightState = ['opacity-0', 'translate-x-8', 'scale-95', 'z-0', 'pointer-events-none'];
            const hiddenLeftState = ['opacity-0', '-translate-x-8', 'scale-95', 'z-0', 'pointer-events-none'];

            // Hàm reset toàn bộ class trạng thái để tránh xung đột
            const removeAllStates = (element) => {
                element.classList.remove(
                    'opacity-100', 'translate-x-0', 'scale-100', 'z-10', 'pointer-events-auto',
                    'opacity-0', 'translate-x-8', '-translate-x-8', 'scale-95', 'z-0', 'pointer-events-none'
                );
            };

            if (tab === 'login') {
                // Di chuyển slider background
                slider.style.transform = 'translateX(0)';

                // Đổi màu text tab
                btnLogin.classList.replace('text-gray-500', 'text-dark');
                btnRegister.classList.replace('text-dark', 'text-gray-500');

                // Kích hoạt form Đăng nhập (từ từ tiến lên và rõ dần)
                removeAllStates(formLogin);
                formLogin.classList.add(...activeState);

                // Ẩn form Đăng ký (thu nhỏ và trượt sang phải)
                removeAllStates(formRegister);
                formRegister.classList.add(...hiddenRightState);

            } else if (tab === 'register') {
                // Di chuyển slider background sang phải
                slider.style.transform = 'translateX(100%)';

                // Đổi màu text tab
                btnRegister.classList.replace('text-gray-500', 'text-dark');
                btnLogin.classList.replace('text-dark', 'text-gray-500');

                // Kích hoạt form Đăng ký (từ từ tiến lên và rõ dần)
                removeAllStates(formRegister);
                formRegister.classList.add(...activeState);

                // Ẩn form Đăng nhập (thu nhỏ và trượt sang trái)
                removeAllStates(formLogin);
                formLogin.classList.add(...hiddenLeftState);
            }
        }

        // --- Hàm Ẩn/Hiện mật khẩu dùng chung cho cả 2 form ---
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                icon.style.color = '#0ea5e9'; // Màu xanh primary
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                icon.style.color = '';
            }
        }
    </script>
</body>
</html>
