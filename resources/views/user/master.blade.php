<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wanderlust - Đặt Tour Du Lịch Cao Cấp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
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
        /* Custom Styles for extra smoothness */
        .glass-effect {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .hero-bg {
            background-image: linear-gradient(rgba(15, 23, 42, 0.4), rgba(15, 23, 42, 0.6)), url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            /* Parallax effect */
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15);
        }

        /* Slider Styles */
        .hero-slide {
            opacity: 0;
            visibility: hidden;
            transition: opacity 1.5s ease-in-out, transform 8s ease-out, visibility 1.5s;
            transform: scale(1);
        }

        .hero-slide.active {
            opacity: 1;
            visibility: visible;
            transform: scale(1.08);
            /* Cinematic zoom effect */
            z-index: 1;
        }

        /* Hide scrollbar for horizontal scrolling lists */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="font-sans text-gray-700 bg-gray-50 antialiased selection:bg-primary selection:text-white">

    <!-- Header -->
    <header class="fixed w-full top-0 z-50 glass-effect border-b border-gray-100 transition-all duration-300"
        id="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ route('user.home') }}" class="flex-shrink-0 flex items-center cursor-pointer">
                    <i class="fa-solid fa-plane-departure text-primary text-3xl mr-2"></i>
                    <span class="font-bold text-2xl text-dark tracking-tight">Wander<span
                            class="text-primary">lust</span></span>
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('user.home') }}"
                        class="text-dark font-medium hover:text-primary transition-colors duration-200">Trang chủ</a>
                    <a href="{{ route('user.home') }}#tours"
                        class="text-gray-600 font-medium hover:text-primary transition-colors duration-200">Điểm đến</a>
                    <a href="{{ route('user.home') }}#hot-tours"
                        class="text-gray-600 font-medium hover:text-primary transition-colors duration-200">Tour Ưu
                        đãi</a>
                    <a href="{{ route('user.home') }}#reviews"
                        class="text-gray-600 font-medium hover:text-primary transition-colors duration-200">Cẩm nang</a>
                    <a href="{{ route('user.home') }}#footer"
                        class="text-gray-600 font-medium hover:text-primary transition-colors duration-200">Liên hệ</a>
                </nav>

                <!-- Action Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Giỏ hàng -->
                    <a href="{{ route('user.cart') }}" class="relative text-gray-600 hover:text-primary transition-colors p-2" title="Giỏ hàng">
                        <i class="fa-solid fa-cart-shopping text-xl"></i>
                        @php
                            $cartCount = count(session('cart', []));
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>

                    @auth
                        <div class="relative group cursor-pointer pt-4 pb-4">
                            <div class="flex items-center space-x-2 text-gray-600 hover:text-primary transition-colors">
                                <i class="fa-regular fa-user text-xl"></i>
                                <span class="font-medium text-sm">{{ Auth::user()->name }}</span>
                            </div>
                            <!-- Dropdown -->
                            <div class="absolute right-0 top-full mt-0 w-48 bg-white border border-gray-100 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                <a href="{{ route('user.home') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-sky-50 hover:text-primary transition-colors rounded-t-xl">Trang chủ</a>
                                <a href="{{ route('user.cart') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-sky-50 hover:text-primary transition-colors">Giỏ hàng của tôi</a>
                                <div class="border-t border-gray-100"></div>
                                <form action="{{ route('user.logout') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors rounded-b-xl">Đăng xuất</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('account') }}" class="text-gray-600 hover:text-primary transition-colors" title="Đăng nhập / Đăng ký">
                            <i class="fa-regular fa-user text-xl"></i>
                        </a>
                    @endauth
                    <a href="{{ route('user.home') }}#tours"
                        class="bg-primary hover:bg-sky-600 text-white px-6 py-2.5 rounded-full font-medium transition-all duration-300 shadow-lg shadow-sky-500/30 hover:shadow-sky-500/50">
                        Đặt Tour Ngay
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-gray-600 hover:text-primary focus:outline-none">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 absolute w-full shadow-lg">
            <div class="px-4 pt-2 pb-6 space-y-1">
                <a href="#" class="block px-3 py-3 text-base font-medium text-primary bg-sky-50 rounded-lg">Trang
                    chủ</a>
                <a href="#tours"
                    class="block px-3 py-3 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-primary rounded-lg">Điểm
                    đến</a>
                <a href="#hot-tours"
                    class="block px-3 py-3 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-primary rounded-lg">Tour
                    Ưu đãi</a>
                <a href="#reviews"
                    class="block px-3 py-3 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-primary rounded-lg">Cẩm
                    nang</a>
                <a href="#"
                    class="block px-3 py-3 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-primary rounded-lg">Liên
                    hệ</a>
            </div>
        </div>
    </header>

    <main class="w-full relative">
        @if(session('success'))
            <div id="toast-success" class="fixed top-24 right-4 z-[100] flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-xl shadow-lg border-l-4 border-green-500 transition-opacity duration-300" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="ml-3 text-sm font-normal text-gray-700">{{ session('success') }}</div>
                <button type="button" onclick="document.getElementById('toast-success').remove()" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toast-success');
                    if(toast) {
                        toast.style.opacity = '0';
                        setTimeout(() => toast.remove(), 300);
                    }
                }, 4000);
            </script>
        @endif

        @if(session('error'))
            <div id="toast-error" class="fixed top-24 right-4 z-[100] flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-xl shadow-lg border-l-4 border-red-500 transition-opacity duration-300" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="ml-3 text-sm font-normal text-gray-700">{{ session('error') }}</div>
                <button type="button" onclick="document.getElementById('toast-error').remove()" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toast-error');
                    if(toast) {
                        toast.style.opacity = '0';
                        setTimeout(() => toast.remove(), 300);
                    }
                }, 4000);
            </script>
        @endif

        <section class="w-full">
            @yield('home')
        </section>
    </main>

    <footer class="bg-dark text-gray-300 pt-16 pb-8 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">

                <!-- Brand Info -->
                <div>
                    <div class="flex items-center mb-6">
                        <i class="fa-solid fa-plane-departure text-primary text-2xl mr-2"></i>
                        <span class="font-bold text-2xl text-white tracking-tight">Wander<span
                                class="text-primary">lust</span></span>
                    </div>
                    <p class="text-sm text-gray-400 mb-6 line-height-loose">
                        Chúng tôi cam kết mang đến cho bạn những trải nghiệm du lịch tuyệt vời nhất, khám phá thế giới
                        với chi phí hợp lý và dịch vụ đẳng cấp.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-white font-bold text-lg mb-6">Về Chúng Tôi</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-primary transition-colors">Giới thiệu Wanderlust</a>
                        </li>
                        <li><a href="#" class="hover:text-primary transition-colors">Tuyển dụng</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Chính sách bảo mật</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Điều khoản sử dụng</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-white font-bold text-lg mb-6">Liên Hệ</h4>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start">
                            <i class="fa-solid fa-location-dot text-primary mt-1 mr-3"></i>
                            <span>123 Đường Du Lịch, Quận Trung Tâm, TP. Hà Nội</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fa-solid fa-phone text-primary mr-3"></i>
                            <span>1900 1234 (Hotline 24/7)</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fa-solid fa-envelope text-primary mr-3"></i>
                            <span>contact@wanderlust.com</span>
                        </li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="text-white font-bold text-lg mb-6">Đăng Ký Nhận Tin</h4>
                    <p class="text-sm text-gray-400 mb-4">Nhận ngay thông tin ưu đãi tour mới nhất qua email.</p>
                    <form class="flex">
                        <input type="email" placeholder="Email của bạn"
                            class="bg-gray-800 text-white px-4 py-2 rounded-l-lg focus:outline-none w-full text-sm border border-gray-700 focus:border-primary">
                        <button type="submit"
                            class="bg-primary hover:bg-sky-600 px-4 py-2 rounded-r-lg transition-colors">
                            <i class="fa-solid fa-paper-plane text-white"></i>
                        </button>
                    </form>
                </div>

            </div>

            <div
                class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
                <p>&copy; 2026 Wanderlust Travel. All rights reserved.</p>
                <div class="mt-4 md:mt-0 flex space-x-4">
                    <i class="fa-brands fa-cc-visa text-2xl"></i>
                    <i class="fa-brands fa-cc-mastercard text-2xl"></i>
                    <i class="fa-brands fa-cc-paypal text-2xl"></i>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
