<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wanderlust Admin | Đăng nhập</title>
    <!-- Tailwind CSS & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: '#0ea5e9',
                        secondary: '#10b981',
                        dark: '#0f172a',
                        surface: '#ffffff',
                        background: '#f8fafc',
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0,0,0,0.05)',
                        'card': '0 10px 40px -10px rgba(0,0,0,0.08)',
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans text-gray-700 bg-background antialiased min-h-screen flex items-center justify-center relative overflow-hidden selection:bg-primary selection:text-white">

    <!-- Background Decoration Elements -->
    <div class="absolute top-[-15%] left-[-10%] w-[500px] h-[500px] bg-primary/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-[-15%] right-[-10%] w-[500px] h-[500px] bg-secondary/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-5xl flex rounded-[2rem] shadow-card bg-surface z-10 overflow-hidden mx-4 min-h-[600px] border border-white/50 backdrop-blur-sm">
        <!-- Left Side: Branding / Image -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-dark items-center justify-center p-12 overflow-hidden group">
            <!-- Background Image overlay -->
            <div class="absolute inset-0 block group-hover:scale-105 transition-transform duration-[1000ms] ease-in-out">
                <img src="https://images.unsplash.com/photo-1507608616759-54f48f0af0ee?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Travel Background" class="w-full h-full object-cover opacity-40">
            </div>
            <!-- Overlay Gradient -->
            <div class="absolute inset-0 bg-gradient-to-t from-dark via-dark/50 to-transparent"></div>
            
            <div class="relative z-10 text-white flex flex-col justify-end h-full hover:-translate-y-2 transition-transform duration-500 w-full">
                <!-- Branding Icon -->
                <div class="w-16 h-16 bg-primary/30 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6 shadow-lg border border-white/20">
                    <i class="fa-solid fa-plane-departure text-3xl text-white"></i>
                </div>
                
                <h1 class="text-4xl font-bold mb-4 leading-tight">Khám phá thế giới cùng <span class="text-primary font-extrabold">Wanderlust.</span></h1>
                <p class="text-gray-300 text-base leading-relaxed mb-8 max-w-md">Hệ thống quản trị nền tảng du lịch hàng đầu, cấp quyền truy cập để quản lý dịch vụ và giám sát hoạt động hệ thống.</p>
                
                <div class="flex items-center space-x-4 border-t border-white/10 pt-6 mt-auto">
                    <div class="flex -space-x-3">
                        <img class="w-10 h-10 rounded-full border-2 border-dark" src="https://i.pravatar.cc/100?img=68" alt="User Avatar">
                        <img class="w-10 h-10 rounded-full border-2 border-dark" src="https://i.pravatar.cc/100?img=32" alt="User Avatar">
                        <img class="w-10 h-10 rounded-full border-2 border-dark" src="https://i.pravatar.cc/100?img=12" alt="User Avatar">
                        <div class="w-10 h-10 rounded-full border-2 border-dark bg-gray-800 flex items-center justify-center text-xs font-semibold">+99</div>
                    </div>
                    <p class="text-sm text-gray-400 font-medium">Hơn <span class="text-white font-semibold">1,000+</span> đối tác tin dùng</p>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 py-12 bg-surface">
            <!-- Mobile Logo -->
            <div class="lg:hidden flex items-center justify-start mb-8">
                <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center shadow-sm">
                    <i class="fa-solid fa-plane-departure text-2xl text-primary"></i>
                </div>
            </div>

            <div class="mb-10 lg:text-left text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-2 font-sans tracking-tight">Đăng Nhập Quản Trị</h2>
                <p class="text-gray-500 text-sm font-medium">Chào mừng trở lại! Vui lòng nhập thông tin để tiếp tục.</p>
            </div>

            <form action="{{ route('postLogin.admin') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email / Tên đăng nhập</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-regular fa-envelope text-gray-400 group-focus-within:text-primary transition-colors"></i>
                        </div>
                        <input type="email" name="email" id="email" class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-[14px] bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium" placeholder="admin@wanderlust.com" required>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-semibold text-gray-700">Mật khẩu</label>
                        <a href="#" class="text-sm font-semibold text-primary hover:text-primary/80 transition-colors">Quên mật khẩu?</a>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400 group-focus-within:text-primary transition-colors"></i>
                        </div>
                        <input type="password" name="password" id="password" class="block w-full pl-11 pr-12 py-3.5 border border-gray-200 rounded-[14px] bg-gray-50/50 text-gray-900 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium" placeholder="••••••••••••" required>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-gray-400 hover:text-gray-600 transition-colors group-focus-within:text-primary" id="togglePasswordBtn">
                            <i class="fa-regular fa-eye-slash" id="togglePasswordIcon"></i>
                        </div>
                    </div>
                </div>

                <div class="flex items-center pt-2">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4.5 w-4.5 text-primary focus:ring-primary border-gray-300 rounded cursor-pointer accent-primary">
                    <label for="remember-me" class="ml-2.5 block text-sm font-medium text-gray-600 cursor-pointer select-none">
                        Ghi nhớ thiết bị này
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 rounded-[14px] shadow-[0_8px_20px_-6px_rgba(14,165,233,0.4)] text-sm font-bold text-white bg-primary hover:bg-[#0284c7] focus:outline-none focus:ring-4 focus:ring-primary/30 transition-all duration-300 transform hover:-translate-y-0.5">
                        <span class="mr-2">Đăng Nhập Quản Trị</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </form>
            
            <!-- Divider -->
            <div class="mt-8 mb-6 relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-xs text-gray-400 font-medium uppercase tracking-wider">
                    <span class="px-4 bg-surface">Hoặc tiếp tục với</span>
                </div>
            </div>
            
            <!-- Social Login -->
            <div class="grid grid-cols-2 gap-4">
                <button type="button" class="flex items-center justify-center py-3 border border-gray-200 rounded-[14px] hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5 mr-2.5" alt="Google">
                    <span class="text-sm font-semibold text-gray-700">Google</span>
                </button>
                <button type="button" class="flex items-center justify-center py-3 border border-gray-200 rounded-[14px] hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm">
                    <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" class="w-5 h-5 mr-2.5" alt="Facebook">
                    <span class="text-sm font-semibold text-gray-700">Facebook</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Password visibility toggle script -->
    <script>
        const togglePasswordBtn = document.querySelector('#togglePasswordBtn');
        const passwordInput = document.querySelector('#password');
        const togglePasswordIcon = document.querySelector('#togglePasswordIcon');

        togglePasswordBtn.addEventListener('click', function () {
            // Toggle type
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            // Toggle icon
            togglePasswordIcon.classList.toggle('fa-eye');
            togglePasswordIcon.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
