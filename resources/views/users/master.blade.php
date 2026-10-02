<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ================= SEO META TAGS ================= --}}
    <title>@yield('meta_title', 'WanderVibe - Tour Du Lịch Việt Nam Uy Tín & Giá Tốt Nhất 2026')</title>
    <meta name="description" content="@yield('meta_description', 'Khám phá hơn 200+ tour du lịch trọn gói cao cấp khắp Việt Nam: Hạ Long, Sapa, Đà Nẵng, Hội An, Phú Quốc, Đà Lạt cùng WanderVibe. Giữ chỗ tức thì, bảo hiểm 100tr, cam kết giá tốt.')">
    <meta name="keywords" content="@yield('meta_keywords', 'tour du lich, du lich viet nam, tour ha long, tour sapa, tour da nang, tour phu quoc, tour da lat, dat tour gia re, tour cao cap, wandervibe')">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="author" content="WanderVibe Travel Vietnam">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <link rel="alternate" hreflang="vi-VN" href="@yield('canonical', url()->current())">

    {{-- ================= GEO META TAGS (VIETNAM) ================= --}}
    <meta name="geo.region" content="VN">
    <meta name="geo.placename" content="Vietnam">
    <meta name="geo.position" content="16.0544;107.5459">
    <meta name="ICBM" content="16.0544, 107.5459">

    {{-- ================= OPEN GRAPH / SOCIAL ================= --}}
    <meta property="og:locale" content="vi_VN">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="WanderVibe">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:title" content="@yield('meta_title', 'WanderVibe - Đặt Tour Du Lịch Trọn Gói Uy Tín')">
    <meta property="og:description" content="@yield('meta_description', 'Khám phá 200+ tour du lịch khắp Việt Nam với giá ưu đãi, hành trình hấp dẫn và dịch vụ chuẩn 5 sao.')">
    <meta property="og:image" content="@yield('og_image', asset('assets/img/logo_title.svg'))">

    {{-- ================= TWITTER CARDS ================= --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('meta_title', 'WanderVibe - Tour Du Lịch Việt Nam')">
    <meta name="twitter:description" content="@yield('meta_description', 'Khám phá 200+ tour du lịch khắp Việt Nam với giá ưu đãi cùng WanderVibe.')">
    <meta name="twitter:image" content="@yield('og_image', asset('assets/img/logo_title.svg'))">

    {{-- ================= STRUCTURED DATA SCHEMA (JSON-LD) ================= --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "WebSite",
          "@id": "{{ url('/') }}#website",
          "url": "{{ url('/') }}",
          "name": "WanderVibe",
          "description": "Nền tảng đặt tour du lịch trực tuyến số 1 Việt Nam",
          "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ route('user.search') }}?keyword={search_term_string}",
            "query-input": "required name=search_term_string"
          }
        },
        {
          "@type": "TravelAgency",
          "@id": "{{ url('/') }}#agency",
          "name": "WanderVibe Travel Vietnam",
          "url": "{{ url('/') }}",
          "logo": "{{ asset('assets/img/logo_title.svg') }}",
          "telephone": "+8419006868",
          "email": "cskh@wandervibe.vn",
          "priceRange": "1.000.000 - 25.000.000 VND",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "Tràng Tiền, Hoàn Kiếm",
            "addressLocality": "Hà Nội",
            "addressRegion": "Hà Nội",
            "addressCountry": "VN"
          }
        }
      ]
    }
    </script>
    @yield('schema')

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logo_title.svg') }}">
    <script>
      if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

     <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
          },
          colors: {
            ocean: {
              50: '#f0f9ff',
              100: '#e0f2fe',
              200: '#bae6fd',
              500: '#0284c7',
              600: '#0369a1',
              700: '#075985',
              800: '#0c4a6e',
              900: '#0f172a',
            },
            coral: {
              50: '#fff7ed',
              100: '#ffedd5',
              500: '#f97316',
              600: '#ea580c',
              700: '#c2410c',
            },
            jade: {
              50: '#ecfdf5',
              100: '#d1fae5',
              500: '#10b981',
              600: '#059669',
              700: '#047857',
            },
            brand: {
              50: '#f0f9ff',
              100: '#e0f2fe',
              400: '#38bdf8',
              500: '#0284c7',
              600: '#0369a1',
              700: '#075985',
            }
          },
          animation: {
            'pulse-soft': 'pulseSoft 3s ease-in-out infinite',
            'float-slow': 'floatSlow 4s ease-in-out infinite alternate',
            'shimmer': 'shimmer 2.5s linear infinite',
          },
          keyframes: {
            pulseSoft: {
              '0%, 100%': { opacity: 0.85, transform: 'scale(1)' },
              '50%': { opacity: 1, transform: 'scale(1.03)' },
            },
            floatSlow: {
              '0%': { transform: 'translateY(0px)' },
              '100%': { transform: 'translateY(-6px)' },
            },
            shimmer: {
              '0%': { transform: 'translateX(-100%)' },
              '100%': { transform: 'translateX(100%)' }
            }
          }
        }
      }
    }
  </script>

  <style>
    /* Luminous Clean Slate Travel Background */
    body {
      background-color: #f8fafc;
      background-image: 
        radial-gradient(at 10% 12%, rgba(2, 132, 199, 0.05) 0px, transparent 40%),
        radial-gradient(at 90% 20%, rgba(249, 115, 22, 0.04) 0px, transparent 45%),
        radial-gradient(at 50% 65%, rgba(16, 185, 129, 0.04) 0px, transparent 50%),
        radial-gradient(at 85% 85%, rgba(2, 132, 199, 0.05) 0px, transparent 45%);
      background-attachment: fixed;
    }

    /* Modern Light Glass Panel */
    .glass-panel-light {
      background: rgba(255, 255, 255, 0.88);
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      border: 1px solid rgba(226, 232, 240, 0.9);
      box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.06), 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    /* Interactive Light Card */
    .glass-card-interactive {
      background: rgba(255, 255, 255, 0.82);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      border: 1px solid rgba(226, 232, 240, 0.85);
      box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.04), 0 1px 3px rgba(0, 0, 0, 0.03);
      transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .glass-card-interactive:hover {
      transform: translateY(-7px);
      border-color: rgba(16, 185, 129, 0.45);
      background: rgba(255, 255, 255, 0.98);
      box-shadow: 0 22px 45px -10px rgba(16, 185, 129, 0.15), 0 4px 6px -1px rgba(0, 0, 0, 0.04);
    }

    /* Cinematic Banner Vignette for crisp text contrast */
    .hero-cinematic-overlay {
      background: linear-gradient(
        180deg, 
        rgba(15, 23, 42, 0.48) 0%, 
        rgba(15, 23, 42, 0.22) 35%, 
        rgba(15, 23, 42, 0.55) 70%, 
        rgba(248, 250, 252, 1) 100%
      );
    }

    /* Sound Wave Bar Animation */
    .sound-wave-bar {
      animation: soundWave 1.1s ease-in-out infinite alternate;
    }
    .sound-wave-bar:nth-child(2) { animation-delay: 0.15s; }
    .sound-wave-bar:nth-child(3) { animation-delay: 0.35s; }
    .sound-wave-bar:nth-child(4) { animation-delay: 0.2s; }
    @keyframes soundWave {
      0% { height: 4px; }
      100% { height: 18px; }
    }

    /* Hide scrollbars */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* Luminous Search Aura Effect for Light Theme */
    .search-aura-light {
      position: relative;
    }
    .search-aura-light::before {
      content: '';
      position: absolute;
      inset: -2px;
      border-radius: 1.85rem;
      background: linear-gradient(90deg, #10b981, #06b6d4, #f59e0b, #10b981);
      background-size: 300% 300%;
      animation: gradientX 7s linear infinite;
      z-index: -1;
      opacity: 0.55;
      filter: blur(14px);
      transition: opacity 0.3s ease;
    }
    .search-aura-light:focus-within::before {
      opacity: 0.9;
      filter: blur(18px);
    }
    @keyframes gradientX {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .nav-link {
      white-space: nowrap !important;
      word-break: keep-all !important;
      flex-shrink: 0 !important;
    }

    /* Dark Theme Core Styles */
    html.dark {
      color-scheme: dark;
    }
    html.dark body {
      background-color: #0b1120 !important;
      background-image: 
        radial-gradient(at 10% 12%, rgba(16, 185, 129, 0.12) 0px, transparent 40%),
        radial-gradient(at 90% 20%, rgba(6, 182, 212, 0.10) 0px, transparent 45%),
        radial-gradient(at 50% 65%, rgba(245, 158, 11, 0.08) 0px, transparent 50%),
        radial-gradient(at 85% 85%, rgba(16, 185, 129, 0.10) 0px, transparent 45%) !important;
      color: #f1f5f9 !important;
    }
    html.dark .glass-panel-light {
      background: rgba(15, 23, 42, 0.88) !important;
      border-color: rgba(51, 65, 85, 0.8) !important;
      box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.4) !important;
    }
    html.dark .glass-card-interactive {
      background: rgba(30, 41, 59, 0.85) !important;
      border-color: rgba(51, 65, 85, 0.85) !important;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3) !important;
      color: #f1f5f9 !important;
    }
    html.dark .glass-card-interactive:hover {
      background: rgba(30, 41, 59, 0.98) !important;
      border-color: rgba(16, 185, 129, 0.6) !important;
      box-shadow: 0 22px 45px -10px rgba(16, 185, 129, 0.25) !important;
    }
    html.dark .bg-white {
      background-color: #1e293b !important;
      color: #f1f5f9;
    }
    html.dark .bg-slate-50, html.dark .bg-gray-50, html.dark .bg-\[\#f8fafc\] {
      background-color: #0b1120 !important;
    }
    html.dark .bg-slate-100, html.dark .bg-gray-100 {
      background-color: #334155 !important;
      color: #f1f5f9;
    }
    html.dark .text-slate-900, html.dark .text-slate-800, html.dark .text-gray-900, html.dark .text-gray-800 {
      color: #f8fafc !important;
    }
    html.dark .text-slate-700, html.dark .text-gray-700, html.dark .text-slate-600 {
      color: #cbd5e1 !important;
    }
    html.dark .text-slate-500, html.dark .text-gray-500 {
      color: #94a3b8 !important;
    }
    html.dark .border-slate-100, html.dark .border-slate-200, html.dark .border-gray-200, html.dark .border-gray-100 {
      border-color: #334155 !important;
    }
    html.dark #mainHeader:not(.bg-transparent) {
      background-color: rgba(15, 23, 42, 0.95) !important;
      border-color: #1e293b !important;
    }
    html.dark #mobileDrawer {
      background-color: rgba(15, 23, 42, 0.98) !important;
      border-color: #334155 !important;
      color: #f1f5f9 !important;
    }
    html.dark footer {
      background-color: #0b1120 !important;
      border-color: #1e293b !important;
      color: #94a3b8 !important;
    }
    html.dark footer .text-slate-900 {
      color: #f8fafc !important;
    }
    html.dark input:not([type="checkbox"]):not([type="radio"]), 
    html.dark select, 
    html.dark textarea {
      background-color: #1e293b !important;
      color: #f8fafc !important;
      border-color: #475569 !important;
    }
    html.dark input::placeholder,
    html.dark textarea::placeholder {
      color: #94a3b8 !important;
      opacity: 1 !important;
    }
    html.dark #contact .text-slate-500 {
      color: #34d399 !important;
    }
  </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 font-sans antialiased overflow-x-hidden relative selection:bg-emerald-500 selection:text-white">

  <!-- Ambient Light Globs -->
  <div class="fixed top-1/4 -left-36 w-96 h-96 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none -z-10 animate-pulse-soft"></div>
  <div class="fixed top-2/3 -right-36 w-[480px] h-[480px] bg-cyan-400/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
  <div class="fixed bottom-10 left-1/3 w-[400px] h-[400px] bg-amber-400/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <!-- Header -->
    @php
        $isHomePage = request()->routeIs('user.home');
    @endphp
    <header id="mainHeader" class="fixed top-0 left-0 right-0 z-50 {{ $isHomePage ? 'bg-transparent border-b border-white/10' : 'bg-white shadow-md border-b border-slate-200' }} transition-colors duration-300">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 h-[84px] flex items-center justify-between gap-4">
            
            <!-- LOGO AREA -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0 group">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-gradient-to-tr from-emerald-500 to-teal-500 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 group-hover:rotate-12 transition-all duration-300">
                    <i class="fa-solid fa-compass text-xl md:text-2xl"></i>
                </div>
                <div class="flex flex-col hidden sm:flex">
                    <span id="logoText" class="text-xl md:text-2xl font-bold tracking-tight {{ $isHomePage ? 'text-white' : 'text-slate-900' }} transition-colors duration-300">
                        Wander<span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-400">Vibe</span>
                    </span>
                    <span id="logoSubtext" class="text-[9px] md:text-[10px] tracking-widest uppercase {{ $isHomePage ? 'text-slate-300' : 'text-slate-500' }} font-bold -mt-0.5 transition-colors duration-300">Vietnam Travel</span>
                </div>
            </a>

            <!-- NAVIGATION MAIN (More spaced out, no heavy pill background) -->
            <nav id="mainNav" class="hidden xl:flex flex-1 items-center justify-center gap-1 2xl:gap-2 flex-nowrap shrink-0">
                <a href="{{ url('/') }}" class="nav-link whitespace-nowrap px-3 2xl:px-4 py-2 rounded-full text-[14px] 2xl:text-[15px] font-bold {{ $isHomePage ? 'text-white hover:bg-white/15' : 'text-slate-700 hover:text-emerald-600 hover:bg-emerald-50' }} transition-all">Trang chủ</a>
                
                @php
                    $navCategories = \App\Models\Category::where('status', 1)
                        ->whereNull('parent_id')
                        ->with('children')
                        ->take(4)
                        ->get();
                @endphp
                @foreach ($navCategories as $cat)
                    @if($cat->children->count() > 0)
                        <div class="relative group shrink-0">
                            <button class="nav-link whitespace-nowrap px-3 2xl:px-4 py-2 rounded-full text-[14px] 2xl:text-[15px] font-bold {{ $isHomePage ? 'text-slate-200 hover:text-white hover:bg-white/15' : 'text-slate-700 hover:text-emerald-600 hover:bg-emerald-50' }} transition-all flex items-center gap-1.5 focus:outline-none">
                                <span>{{ $cat->name }}</span>
                                <i class="fa-solid fa-angle-down text-[10px] opacity-70 group-hover:-rotate-180 transition-transform duration-300"></i>
                            </button>
                            <!-- Dropdown -->
                            <div class="absolute left-1/2 -translate-x-1/2 top-full pt-3 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-100 p-2 transform scale-95 group-hover:scale-100 transition-all origin-top">
                                    @foreach($cat->children as $child)
                                        <a href="{{ route('user.category', $child->id) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors whitespace-nowrap">
                                            <i class="fa-solid fa-hashtag text-emerald-400/50 text-xs"></i> {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Filter out exact duplicates if data is messy, otherwise render normally -->
                        @if(strtolower($cat->name) !== 'trang chủ' && strtolower($cat->name) !== 'liên hệ')
                            <a href="{{ route('user.category', $cat->id) }}" class="nav-link whitespace-nowrap px-3 2xl:px-4 py-2 rounded-full text-[14px] 2xl:text-[15px] font-bold {{ $isHomePage ? 'text-slate-200 hover:text-white hover:bg-white/15' : 'text-slate-700 hover:text-emerald-600 hover:bg-emerald-50' }} transition-all shrink-0">
                                {{ $cat->name }}
                            </a>
                        @endif
                    @endif
                @endforeach
                <a href="{{ route('contact') }}" class="nav-link whitespace-nowrap px-3 2xl:px-4 py-2 rounded-full text-[14px] 2xl:text-[15px] font-bold {{ $isHomePage ? 'text-slate-200 hover:text-white hover:bg-white/15' : 'text-slate-700 hover:text-emerald-600 hover:bg-emerald-50' }} transition-all shrink-0">Liên hệ</a>
            </nav>

            <!-- RIGHT ACTIONS -->
            <div class="flex items-center gap-3 md:gap-5 shrink-0 justify-end">
                
                <!-- Hotline (Hidden on very small screens) -->
                <a href="tel:1900888999" id="hotlineBadge" class="hidden lg:flex items-center gap-2 group {{ $isHomePage ? 'text-white' : 'text-slate-700' }} hover:text-emerald-500 transition-colors">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center {{ $isHomePage ? 'bg-white/15' : 'bg-slate-100 group-hover:bg-emerald-50' }} transition-colors pointer-events-none">
                        <i class="fa-solid fa-phone-volume text-[13px] {{ $isHomePage ? '' : 'text-emerald-500' }}"></i>
                    </div>
                    <div class="flex flex-col hidden xl:flex">
                        <span class="text-[10px] font-bold uppercase tracking-wider opacity-70">Tổng đài CSKH</span>
                        <span class="text-sm font-extrabold leading-tight">1900 888 999</span>
                    </div>
                </a>

                <!-- Cart Button -->
                @php
                    $cartSession = session('cart') ?? [];
                    $cartBadgeCount = 0;
                    foreach ($cartSession as $cItem) {
                        $cartBadgeCount += (int)($cItem['quantity'] ?? 1);
                    }
                @endphp
                <a href="{{ route('user.cart') }}" class="relative w-10 h-10 md:w-11 md:h-11 rounded-full border {{ $isHomePage ? 'bg-white/10 border-white/20 text-white hover:bg-white/25' : 'bg-white border-slate-200 shadow-sm text-slate-700 hover:bg-slate-50 hover:border-emerald-200 hover:text-emerald-600' }} flex items-center justify-center transition-all cursor-pointer" title="Giỏ hàng">
                    <i class="fa-solid fa-cart-shopping text-[15px] md:text-base pointer-events-none"></i>
                    @if($cartBadgeCount > 0)
                        <span class="absolute -top-1 -right-1 w-4 h-4 md:w-5 md:h-5 rounded-full bg-emerald-500 text-[10px] md:text-xs font-bold flex items-center justify-center text-white pointer-events-none border-2 border-transparent">
                            {{ $cartBadgeCount }}
                        </span>
                    @endif
                </a>

                <!-- Dark / Light Mode Toggle Button -->
                <button type="button" class="theme-toggle-btn relative w-10 h-10 md:w-11 md:h-11 rounded-full border {{ $isHomePage ? 'bg-white/10 border-white/20 text-white hover:bg-white/25' : 'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 shadow-sm text-slate-700 dark:text-amber-400 hover:bg-slate-50 dark:hover:bg-slate-700' }} flex items-center justify-center transition-all cursor-pointer" title="Chuyển đổi giao diện Sáng / Tối" aria-label="Toggle Dark Mode">
                    <i class="fa-solid fa-moon text-[15px] md:text-base dark:hidden pointer-events-none"></i>
                    <i class="fa-solid fa-sun text-[15px] md:text-base hidden dark:inline-block pointer-events-none text-amber-400"></i>
                </button>

                <!-- Notifications Bell -->
                @if(isset($notifications))
                    <div class="relative inline-block z-20" id="notificationDropdownTrigger">
                        <button id="notificationBtn" class="relative w-10 h-10 md:w-11 md:h-11 rounded-full border {{ $isHomePage ? 'bg-white/10 border-white/20 text-white hover:bg-white/25' : 'bg-white border-slate-200 shadow-sm text-slate-700 hover:bg-slate-50 hover:border-emerald-200 hover:text-emerald-600' }} flex items-center justify-center transition-all cursor-pointer">
                            <i class="fa-regular fa-bell text-[15px] md:text-base pointer-events-none"></i>
                            @if(isset($unreadCount) && $unreadCount > 0)
                                <span class="absolute -top-1 -right-1 w-4 h-4 md:w-5 md:h-5 rounded-full bg-rose-500 text-[10px] md:text-xs font-bold flex items-center justify-center text-white pointer-events-none border-2 border-transparent">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </button>
                        
                        <!-- Notifications Dropdown -->
                        <div id="notificationDropdownMenu" class="absolute right-0 top-[120%] w-80 bg-white/95 backdrop-blur-xl border border-slate-200 rounded-3xl shadow-2xl opacity-0 invisible transition-all duration-300 transform origin-top translate-y-2 z-50 text-slate-800">
                            <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/80 rounded-t-3xl">
                                <h4 class="text-sm font-bold text-slate-800">Thông báo</h4>
                                @if(isset($unreadCount) && $unreadCount > 0)
                                    <span class="text-[11px] font-bold text-rose-600 bg-rose-100 px-2.5 py-1 rounded-full">{{ $unreadCount }} chưa đọc</span>
                                @endif
                            </div>
                            <div class="max-h-[320px] overflow-y-auto no-scrollbar pb-2">
                                @forelse($notifications as $notification)
                                    <a href="{{ route('user.notifications.read', $notification->id) }}" class="block p-4 border-b border-slate-50/50 hover:bg-emerald-50/50 transition-colors {{ $notification->status === 'unread' ? 'bg-emerald-50/30' : '' }}">
                                        <div class="flex gap-3.5">
                                            <div class="w-10 h-10 rounded-full {{ $notification->status === 'unread' ? 'bg-emerald-500 shadow-md shadow-emerald-500/20 text-white' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-bell text-sm"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm text-slate-800 {{ $notification->status === 'unread' ? 'font-bold' : 'font-medium' }}">
                                                    {{ $notification->title }}
                                                </p>
                                                <p class="text-[13px] text-slate-500 mt-1 line-clamp-2 leading-snug">
                                                    {{ $notification->message }}
                                                </p>
                                                <span class="text-[10px] text-slate-400 mt-1.5 block font-medium">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="py-12 flex flex-col items-center justify-center text-slate-400">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                            <i class="fa-regular fa-bell-slash text-2xl"></i>
                                        </div>
                                        <p class="text-sm font-medium text-slate-500">Chưa có thông báo nào</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Authentication UI -->
                @guest('web')
                    <div class="pl-1 border-l border-white/20 ml-1 flex items-center">
                        <a href="{{ route('account') }}" class="px-5 py-2.5 md:px-6 md:py-2.5 rounded-full bg-white text-emerald-600 hover:bg-emerald-50 hover:text-emerald-700 font-extrabold text-[13px] md:text-sm shadow-xl shadow-emerald-900/10 hover:shadow-emerald-900/20 hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center gap-2 border border-slate-100 uppercase tracking-wide">
                            <i class="fa-solid fa-user-circle text-lg hidden sm:inline"></i> 
                            <span class="inline">Đăng Nhập</span>
                        </a>
                    </div>
                @endguest

                @auth('web')
                    <div class="relative group cursor-pointer inline-block z-10" id="userDropdownTrigger">
                        <div class="w-10 h-10 md:w-11 md:h-11 rounded-full overflow-hidden border-2 border-emerald-400 hover:border-white transition-colors shadow-lg">
                            <img src="{{ Auth::user()->avatar_url }}" 
                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=10b981&color=fff';" 
                                 alt="User Avatar" class="w-full h-full object-cover">
                        </div>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 top-[110%] w-60 bg-white/95 backdrop-blur-xl border border-slate-200 rounded-3xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top group-hover:translate-y-0 translate-y-3 z-50 overflow-hidden">
                            <div class="p-5 border-b border-slate-100 bg-slate-50/80">
                                <p class="text-sm font-extrabold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs font-medium text-slate-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="p-3 flex flex-col gap-1">
                                <a href="{{ route('user.profile', Auth::id()) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors">
                                    <div class="w-6 h-6 flex items-center justify-center bg-white rounded-md shadow-sm border border-slate-100 text-slate-400"><i class="fa-solid fa-user"></i></div> Thông tin cá nhân
                                </a>
                                <a href="{{ route('user.cart') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors">
                                    <div class="w-6 h-6 flex items-center justify-center bg-white rounded-md shadow-sm border border-slate-100 text-slate-400"><i class="fa-solid fa-cart-shopping"></i></div> Giỏ hàng của tôi
                                </a>
                                <a href="{{ route('user.tours.booked') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors">
                                    <div class="w-6 h-6 flex items-center justify-center bg-white rounded-md shadow-sm border border-slate-100 text-slate-400"><i class="fa-solid fa-clock-rotate-left"></i></div> Lịch sử đặt tour
                                </a>
                                <a href="{{ route('password.request') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors">
                                    <div class="w-6 h-6 flex items-center justify-center bg-white rounded-md shadow-sm border border-slate-100 text-slate-400"><i class="fa-solid fa-shield-halved"></i></div> Đổi mật khẩu
                                </a>
                            </div>
                            <div class="p-3 border-t border-slate-100 bg-slate-50/50">
                                <form action="{{ route('user.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-rose-500 hover:text-white hover:bg-rose-500 rounded-xl transition-all border border-rose-100 hover:border-transparent">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
                
                <button id="mobileMenuBtn" class="xl:hidden w-10 h-10 md:w-11 md:h-11 rounded-full border {{ $isHomePage ? 'bg-white/10 border-white/20 text-white hover:bg-white/25' : 'bg-white border-slate-200 text-slate-800 hover:bg-slate-50 hover:text-emerald-600' }} flex items-center justify-center transition-all shadow-sm">
                    <i class="fa-solid fa-bars text-[15px] md:text-base" id="mobileMenuIcon"></i>
                </button>
            </div>
        </div>

        <div id="mobileDrawer" class="hidden xl:hidden bg-white/95 backdrop-blur-2xl border-b border-slate-200 px-6 py-6 space-y-4 shadow-2xl text-slate-800 max-h-[80vh] overflow-y-auto">
            @auth('web')
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-100 mb-2">
                    <img src="{{ Auth::user()->avatar_url }}" 
                         onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=10b981&color=fff';" 
                         class="w-12 h-12 rounded-full object-cover border-2 border-emerald-500/20 shadow-sm" alt="Avatar">
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-slate-800 truncate text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            @endauth
            <a href="{{ url('/') }}" class="mobile-nav-link block text-base font-extrabold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-4 py-3 rounded-xl border border-emerald-100">
                <i class="fa-solid fa-house w-6 text-center mr-2"></i> Trang chủ
            </a>
            
            @foreach ($navCategories as $cat)
                @if($cat->children->count() > 0)
                    <div class="flex flex-col gap-1 border border-slate-100 bg-white rounded-xl overflow-hidden shadow-sm">
                        <div class="block text-base font-bold text-slate-700 hover:text-emerald-600 flex justify-between items-center px-4 py-3 bg-slate-50">
                            <span><i class="fa-solid fa-layer-group w-6 text-center text-slate-400 mr-2"></i> {{ $cat->name }}</span>
                            <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                        </div>
                        <div class="pl-12 pr-4 py-2 flex flex-col gap-3">
                            @foreach($cat->children as $child)
                                <a href="{{ route('user.category', $child->id) }}" class="mobile-nav-link block text-sm font-semibold text-slate-600 hover:text-emerald-600">
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    @if(strtolower($cat->name) !== 'trang chủ' && strtolower($cat->name) !== 'liên hệ')
                        <a href="{{ route('user.category', $cat->id) }}" class="mobile-nav-link block text-base font-bold text-slate-700 hover:text-emerald-600 px-4 py-3 bg-white rounded-xl border border-slate-100 shadow-sm">
                            <i class="fa-solid fa-cube w-6 text-center text-slate-400 mr-2"></i> {{ $cat->name }}
                        </a>
                    @endif
                @endif
            @endforeach
            
            <a href="{{ route('contact') }}" class="mobile-nav-link block text-base font-bold text-slate-700 hover:text-emerald-600 px-4 py-3 bg-white rounded-xl border border-slate-100 shadow-sm">
                <i class="fa-solid fa-headset w-6 text-center text-slate-400 mr-2"></i> Tư Vấn & Liên Hệ
            </a>

            <!-- Mobile Theme Switcher -->
            <button type="button" class="theme-toggle-btn w-full text-left text-base font-bold text-slate-700 dark:text-slate-200 hover:text-emerald-600 px-4 py-3 bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm flex items-center justify-between transition-colors">
                <span class="flex items-center"><i class="fa-solid fa-circle-half-stroke w-6 text-center text-emerald-500 mr-2"></i> Giao diện Sáng / Tối</span>
                <span class="text-xs px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-semibold">Chuyển đổi</span>
            </button>
        </div>
    </header>

    <main class="w-full">
        @yield('home')
    </main>

    <footer class="bg-white text-slate-600 pt-16 pb-8 border-t border-slate-200 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-slate-100">
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white shadow-lg shadow-emerald-500/25">
                            <i class="fa-solid fa-compass text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold tracking-tight text-slate-900">WanderVibe</span>
                    </div>
                    <p class="text-sm text-slate-500 max-w-sm leading-relaxed">
                        Hệ sinh thái du lịch và trải nghiệm phong cách mới dành cho thế hệ trẻ. Khám phá cảnh sắc Việt Nam qua những góc nhìn chân thực, giàu cảm xúc và gắn kết cộng đồng.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="#" class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 hover:bg-emerald-500 hover:text-white flex items-center justify-center transition-all"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 hover:bg-emerald-500 hover:text-white flex items-center justify-center transition-all"><i class="fa-brands fa-instagram text-sm"></i></a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 hover:bg-emerald-500 hover:text-white flex items-center justify-center transition-all"><i class="fa-brands fa-tiktok text-sm"></i></a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 hover:bg-emerald-500 hover:text-white flex items-center justify-center transition-all"><i class="fa-brands fa-youtube text-sm"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="text-slate-900 text-sm font-bold uppercase tracking-wider mb-4">Tour Nổi Bật</h4>
                    <ul class="space-y-2.5 text-sm">
                        @if(isset($hotTours) && $hotTours->count())
                            @foreach($hotTours->take(4) as $item)
                                <li><a href="#tours" class="hover:text-emerald-600 transition-colors">{{ Str::limit($item->name, 28) }}</a></li>
                            @endforeach
                        @else
                            <li><a href="#tours" class="hover:text-emerald-600 transition-colors">Tour Hà Giang Xe Máy</a></li>
                            <li><a href="#tours" class="hover:text-emerald-600 transition-colors">Du Thuyền Vịnh Hạ Long</a></li>
                        @endif
                    </ul>
                </div>

                <div>
                    <h4 class="text-slate-900 text-sm font-bold uppercase tracking-wider mb-4">Điểm Đến Hot</h4>
                    <ul class="space-y-2.5 text-sm">
                        @if(isset($destinations) && $destinations->count())
                            @foreach($destinations->take(4) as $dest)
                                <li><a href="#destinations" class="hover:text-emerald-600 transition-colors">{{ $dest->end_location }}</a></li>
                            @endforeach
                        @else
                            <li><a href="#destinations" class="hover:text-emerald-600 transition-colors">Đà Lạt Mộng Mơ</a></li>
                            <li><a href="#destinations" class="hover:text-emerald-600 transition-colors">Phố Cổ Hội An</a></li>
                        @endif
                    </ul>
                </div>

                <div>
                    <h4 class="text-slate-900 text-sm font-bold uppercase tracking-wider mb-4">Nhận Voucher 200k</h4>
                    <p class="text-xs text-slate-500 mb-3">Đăng ký email để nhận ưu đãi tour hè và cẩm nang phượt độc quyền hàng tuần.</p>
                    <form id="newsletterForm" class="space-y-2">
                        <input type="email" required placeholder="Nhập email của bạn..." class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:bg-white transition-all">
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs transition-all shadow-md shadow-emerald-500/20">
                            Đăng Ký Ngay
                        </button>
                    </form>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
                <p>© {{ date('Y') }} WanderVibe Vietnam Travel Co., Ltd. Giấy phép Lữ hành Quốc tế số 79-0128/TCDL-GP LHQT.</p>
                <div class="flex items-center gap-4">
                    <span class="hover:text-slate-600 cursor-pointer">Chính sách bảo mật</span>
                    <span>•</span>
                    <span class="hover:text-slate-600 cursor-pointer">Điều khoản sử dụng</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Quick Tour Booking Modal -->
    <div id="quickBookModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full mx-4 shadow-2xl transform scale-95 transition-transform duration-300 border border-slate-200 text-slate-800">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-base">Đặt Tour Thần Tốc</h4>
                </div>
                <button onclick="closeBookModal()" class="w-8 h-8 rounded-full hover:bg-slate-100 text-slate-400 hover:text-slate-600 flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="py-4">
                <p class="text-xs text-slate-500 mb-1 font-medium">Tour đã chọn:</p>
                <div id="modalTourName" class="font-bold text-emerald-700 text-sm bg-emerald-50 border border-emerald-200 px-3.5 py-2.5 rounded-xl mb-4">
                    Tour Hà Giang 3N2Đ
                </div>
                <form id="modalQuickForm" class="space-y-3">
                    <input type="hidden" id="quickTourInput" name="tour_name" value="">
                    <div>
                        <label for="quickUserName" class="text-xs font-bold text-slate-700 block mb-1">Tên khách hàng</label>
                        <input type="text" id="quickUserName" required placeholder="Họ và tên của bạn" value="{{ $user->name ?? '' }}"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-800 placeholder-slate-400 focus:border-emerald-500 focus:bg-white focus:outline-none">
                    </div>
                    <div>
                        <label for="quickUserPhone" class="text-xs font-bold text-slate-700 block mb-1">Số điện thoại / Zalo</label>
                        <input type="tel" id="quickUserPhone" required placeholder="09xx xxx xxx" value="{{ $user->phone ?? '' }}"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-800 placeholder-slate-400 focus:border-emerald-500 focus:bg-white focus:outline-none">
                    </div>
                    <div>
                        <label for="quickTravelDate" class="text-xs font-bold text-slate-700 block mb-1">Dự kiến ngày khởi hành</label>
                        <input type="date" id="quickTravelDate" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-800 focus:border-emerald-500 focus:bg-white focus:outline-none">
                    </div>
                    <button type="submit" class="w-full py-3.5 mt-2 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-extrabold text-sm shadow-lg shadow-emerald-500/25 transition-all">
                        Xác Nhận Giữ Chỗ & Nhận Báo Giá
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toastContainer" class="fixed bottom-6 right-6 z-50 flex flex-col gap-3 pointer-events-none"></div>

    <script>
        const heroVideos = {
            hagiang: {
                title: 'Chạm Vào Cực Bắc Kỳ Vĩ <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-400">Hà Giang</span>',
                subtitle: 'Lướt trên cung đèo Mã Pí Lèng huyền thoại, dong thuyền ngắm dòng Nho Quế màu ngọc bích và đắm chìm trong vẻ đẹp bất tận của non nước.',
                videoUrl: 'https://assets.mixkit.co/videos/preview/mixkit-aerial-view-of-waves-crashing-on-a-rocky-shore-41484-large.mp4',
                poster: 'https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=1920&q=80'
            },
            phuquoc: {
                title: 'Đắm Mình Trong Biển Xanh <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-teal-300 to-emerald-400">Phú Quốc</span>',
                subtitle: 'Tận hưởng làn nước pha lê tại An Thới, lặn ngắm rạn san hô tự nhiên và ngắm quả cầu lửa hoàng hôn chìm vào lòng đại dương.',
                videoUrl: 'https://assets.mixkit.co/videos/preview/mixkit-aerial-view-of-waves-crashing-on-a-rocky-shore-41484-large.mp4',
                poster: 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1920&q=80'
            },
            dalat: {
                title: 'Săn Mây Lãng Mạn <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-300 via-emerald-400 to-amber-300">Đà Lạt</span>',
                subtitle: 'Đón ánh bình minh xuyên qua ngàn thông Cầu Đất, nhâm nhi ly cà phê ấm và trải nghiệm đêm tiệc glamping acoustic cực chill.',
                videoUrl: 'https://assets.mixkit.co/videos/preview/mixkit-aerial-view-of-waves-crashing-on-a-rocky-shore-41484-large.mp4',
                poster: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1920&q=80'
            },
            halong: {
                title: 'Kỳ Quan Du Thuyền 5 Sao <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-cyan-400 to-teal-300">Hạ Long</span>',
                subtitle: 'Ngắm hàng nghìn đảo đá vôi kỳ vĩ soi bóng mặt vịnh xanh thẳm, trải nghiệm chèo kayak qua hang luồn và ngắm hoàng hôn vịnh biển.',
                videoUrl: 'https://assets.mixkit.co/videos/preview/mixkit-aerial-view-of-waves-crashing-on-a-rocky-shore-41484-large.mp4',
                poster: 'https://images.unsplash.com/photo-1559592413-7cec4d0cae2b?auto=format&fit=crop&w=1920&q=80'
            }
        };

        function switchHeroVideo(key) {
            const data = heroVideos[key];
            if (!data) return;

            const titleEl = document.getElementById('heroTitle');
            const subEl = document.getElementById('heroSubtitle');
            const videoEl = document.getElementById('heroVideo');

            document.querySelectorAll('.hero-switcher-btn').forEach(btn => {
                btn.classList.remove('active', 'bg-emerald-500', 'text-white', 'shadow-lg', 'shadow-emerald-500/30');
                btn.classList.add('bg-white/5', 'text-slate-300');
            });

            if (window.event && window.event.currentTarget) {
                const activeBtn = window.event.currentTarget;
                activeBtn.classList.add('active', 'bg-emerald-500', 'text-white', 'shadow-lg', 'shadow-emerald-500/30');
                activeBtn.classList.remove('bg-white/5', 'text-slate-300');
            }

            if (titleEl) {
                titleEl.style.opacity = '0';
                titleEl.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    titleEl.innerHTML = data.title;
                    titleEl.style.opacity = '1';
                    titleEl.style.transform = 'translateY(0)';
                }, 250);
            }

            if (subEl) {
                subEl.style.opacity = '0';
                subEl.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    subEl.textContent = data.subtitle;
                    subEl.style.opacity = '1';
                    subEl.style.transform = 'translateY(0)';
                }, 250);
            }

            if (videoEl) {
                videoEl.poster = data.poster;
                videoEl.play().catch(() => {});
            }
        }

        const toggleVideoPlayBtn = document.getElementById('toggleVideoPlayBtn');
        if (toggleVideoPlayBtn) {
            const video = document.getElementById('heroVideo');
            const icon = document.getElementById('playIcon');
            const text = document.getElementById('playText');

            function syncVideoBtn() {
                if (!video) return;
                if (video.paused) {
                    if (icon) icon.className = 'fa-solid fa-play';
                    if (text) text.textContent = 'Phát video';
                } else {
                    if (icon) icon.className = 'fa-solid fa-pause';
                    if (text) text.textContent = 'Dừng video';
                }
            }

            if (video) {
                video.addEventListener('play', syncVideoBtn);
                video.addEventListener('pause', syncVideoBtn);
                video.addEventListener('loadeddata', syncVideoBtn);
            }

            toggleVideoPlayBtn.addEventListener('click', () => {
                if (!video) return;
                if (video.paused) {
                    video.play().catch(() => {});
                } else {
                    video.pause();
                }
            });
        }

        window.addEventListener('scroll', () => {
            const isHomePage = {{ request()->routeIs('user.home') ? 'true' : 'false' }};
            if (!isHomePage) return;

            const header = document.getElementById('mainHeader');
            const logoText = document.getElementById('logoText');
            const logoSubtext = document.getElementById('logoSubtext');
            const mainNav = document.getElementById('mainNav');
            const hotlineBadge = document.getElementById('hotlineBadge');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const notificationBtn = document.getElementById('notificationBtn');
            if (!header) return;
      
            if (window.scrollY > 60) {
              header.classList.remove('bg-transparent', 'border-white/10');
              header.classList.add('bg-white', 'shadow-md', 'border-slate-200');
      
              if (logoText) {
                logoText.classList.remove('text-white');
                logoText.classList.add('text-slate-900');
              }
              if (logoSubtext) {
                logoSubtext.classList.remove('text-slate-300');
                logoSubtext.classList.add('text-slate-500');
              }
              if (mainNav) {
                mainNav.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('text-slate-200', 'text-white', 'hover:text-white', 'hover:bg-white/15');
                    link.classList.add('text-slate-700', 'hover:text-emerald-600', 'hover:bg-emerald-50');
                });
              }
              if (hotlineBadge) {
                hotlineBadge.classList.remove('text-white');
                hotlineBadge.classList.add('text-slate-700');
                const iconBox = hotlineBadge.firstElementChild;
                if(iconBox) {
                    iconBox.classList.remove('bg-white/15');
                    iconBox.classList.add('bg-slate-100', 'group-hover:bg-emerald-50');
                    const icon = iconBox.firstElementChild;
                    if(icon) icon.classList.add('text-emerald-500');
                }
              }
              if (mobileMenuBtn) {
                mobileMenuBtn.classList.remove('text-white', 'bg-white/10', 'border-white/20', 'hover:bg-white/25');
                mobileMenuBtn.classList.add('text-slate-800', 'bg-white', 'border-slate-200', 'hover:bg-slate-50', 'hover:text-emerald-600');
              }
              if (notificationBtn) {
                notificationBtn.classList.remove('text-white', 'bg-white/10', 'border-white/20', 'hover:bg-white/25');
                notificationBtn.classList.add('text-slate-700', 'bg-white', 'border-slate-200', 'hover:bg-slate-50', 'hover:border-emerald-200', 'hover:text-emerald-600');
              }
            } else {
              header.classList.add('bg-transparent', 'border-white/10');
              header.classList.remove('bg-white', 'shadow-md', 'border-slate-200');
      
              if (logoText) {
                logoText.classList.add('text-white');
                logoText.classList.remove('text-slate-900');
              }
              if (logoSubtext) {
                logoSubtext.classList.add('text-slate-300');
                logoSubtext.classList.remove('text-slate-500');
              }
              if (mainNav) {
                mainNav.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.add('text-slate-200', 'hover:text-white', 'hover:bg-white/15');
                    link.classList.remove('text-slate-700', 'hover:text-emerald-600', 'hover:bg-emerald-50');
                });
              }
              if (hotlineBadge) {
                hotlineBadge.classList.add('text-white');
                hotlineBadge.classList.remove('text-slate-700');
                const iconBox = hotlineBadge.firstElementChild;
                if(iconBox) {
                    iconBox.classList.add('bg-white/15');
                    iconBox.classList.remove('bg-slate-100', 'group-hover:bg-emerald-50');
                    const icon = iconBox.firstElementChild;
                    if(icon) icon.classList.remove('text-emerald-500');
                }
              }
              if (mobileMenuBtn) {
                mobileMenuBtn.classList.add('text-white', 'bg-white/10', 'border-white/20', 'hover:bg-white/25');
                mobileMenuBtn.classList.remove('text-slate-800', 'bg-white', 'border-slate-200', 'hover:bg-slate-50', 'hover:text-emerald-600');
              }
              if (notificationBtn) {
                notificationBtn.classList.add('text-white', 'bg-white/10', 'border-white/20', 'hover:bg-white/25');
                notificationBtn.classList.remove('text-slate-700', 'bg-white', 'border-slate-200', 'hover:bg-slate-50', 'hover:border-emerald-200', 'hover:text-emerald-600');
              }
            }
        });

        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileDrawer = document.getElementById('mobileDrawer');
        const mobileMenuIcon = document.getElementById('mobileMenuIcon');
        if (mobileMenuBtn && mobileDrawer) {
            mobileMenuBtn.addEventListener('click', () => {
                const isHidden = mobileDrawer.classList.contains('hidden');
                if (isHidden) {
                    mobileDrawer.classList.remove('hidden');
                    if (mobileMenuIcon) mobileMenuIcon.className = 'fa-solid fa-xmark text-lg';
                } else {
                    mobileDrawer.classList.add('hidden');
                    if (mobileMenuIcon) mobileMenuIcon.className = 'fa-solid fa-bars text-lg';
                }
            });

            document.querySelectorAll('.mobile-nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    mobileDrawer.classList.add('hidden');
                    if (mobileMenuIcon) mobileMenuIcon.className = 'fa-solid fa-bars text-lg';
                });
            });
        }

        async function fetchWeather(city, activeButton = null) {
            try {
                const response = await fetch(`/weather/ajax?city=${encodeURIComponent(city)}`);
                if (!response.ok) {
                    showToast('Không tìm thấy thông tin thời tiết cho điểm đến này', 'warning');
                    return;
                }
                const data = await response.json();

                // Update active tab buttons if present
                if (activeButton) {
                    document.querySelectorAll('.weather-tab-btn').forEach(b => {
                        b.classList.remove('active', 'bg-emerald-500', 'text-white', 'shadow-md', 'shadow-emerald-500/30');
                        b.classList.add('bg-transparent', 'text-slate-600');
                    });
                    activeButton.classList.add('active', 'bg-emerald-500', 'text-white', 'shadow-md', 'shadow-emerald-500/30');
                    activeButton.classList.remove('bg-transparent', 'text-slate-600');
                } else {
                    document.querySelectorAll('.weather-tab-btn').forEach(b => {
                        b.classList.remove('active', 'bg-emerald-500', 'text-white', 'shadow-md', 'shadow-emerald-500/30');
                        b.classList.add('bg-transparent', 'text-slate-600');
                    });
                }

                // Update DOM elements using data.current
                if (data.current) {
                    document.getElementById('weatherTemp').textContent = (data.current.temp || 0) + '°C';
                    document.getElementById('weatherCity').textContent = data.current.city + ', Việt Nam';
                    document.getElementById('weatherStatusText').textContent = data.current.desc || '';
                    document.getElementById('weatherIconContainer').innerHTML = `<img src="https://openweathermap.org/img/wn/${data.current.icon}@2x.png" alt="icon" class="w-20 h-20 scale-125 drop-shadow-md pb-1">`;
                    
                    // Update advice and score
                    if (data.current.advice) {
                        const adviceEl = document.getElementById('weatherAdvice');
                        if (adviceEl) adviceEl.textContent = data.current.advice;
                    }

                    if (data.current.scoreText) {
                        const scoreEl = document.getElementById('weatherScore');
                        if (scoreEl) {
                            scoreEl.textContent = data.current.scoreText;
                            scoreEl.className = `text-[11px] font-bold px-3 py-1 rounded-full ${data.current.scoreBg} ${data.current.scoreColor}`;
                        }
                    }
                }

                // Update forecast
                if (data.forecast && data.forecast.length > 0) {
                    const forecastContainer = document.getElementById('forecastContainer');
                    if (forecastContainer) {
                        forecastContainer.innerHTML = '';
                        data.forecast.forEach(day => {
                            forecastContainer.innerHTML += `
                                <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm text-center hover:-translate-y-1 transition-transform">
                                    <p class="text-xs font-bold text-slate-500 mb-2">${day.date}</p>
                                    <div class="w-14 h-14 mx-auto bg-gradient-to-br from-indigo-400 to-sky-400 rounded-full flex items-center justify-center mb-3 shadow-md border border-indigo-300 overflow-hidden">
                                        <img src="https://openweathermap.org/img/wn/${day.icon}@2x.png" alt="icon" class="w-16 h-16 object-contain scale-110 drop-shadow-md pb-1">
                                    </div>
                                    <p class="text-lg font-bold text-slate-800">${day.temp}°C</p>
                                </div>
                            `;
                        });
                        const visibilityEl = document.getElementById('weatherVisibility');
                        if (visibilityEl) visibilityEl.textContent = data.forecast.length + ' mốc dự báo';
                    }
                }
            } catch (error) {
                console.error("Lỗi lấy thời tiết:", error);
                showToast('Lỗi kết nối khi lấy dữ liệu thời tiết', 'warning');
            }
        }

        document.querySelectorAll('.weather-tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const loc = btn.getAttribute('data-loc');
                fetchWeather(loc, btn);
            });
        });

        const weatherForm = document.getElementById('weatherSearchForm');
        if (weatherForm) {
            weatherForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const city = document.getElementById('weatherCityInput').value.trim();
                const submitBtn = weatherForm.querySelector('button[type="submit"]');
                const icon = submitBtn.innerHTML;
                
                if (city) {
                    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
                    submitBtn.disabled = true;
                    
                    fetchWeather(city).finally(() => {
                        submitBtn.innerHTML = icon;
                        submitBtn.disabled = false;
                    });
                }
            });
        }

        const searchInput = document.getElementById('searchDestination');
        const clearSearchBtn = document.getElementById('clearSearchBtn');

        if (searchInput && clearSearchBtn) {
            searchInput.addEventListener('input', () => {
                clearSearchBtn.classList.toggle('hidden', searchInput.value.trim().length === 0);
            });
            clearSearchBtn.addEventListener('click', () => {
                searchInput.value = '';
                clearSearchBtn.classList.add('hidden');
                searchInput.focus();
            });
        }

        document.querySelectorAll('.quick-tag').forEach(tag => {
            tag.addEventListener('click', () => {
                const query = tag.getAttribute('data-query');
                if (searchInput) {
                    searchInput.value = query;
                    if (clearSearchBtn) clearSearchBtn.classList.remove('hidden');
                    const form = document.getElementById('tourSearchForm');
                    if (form) form.submit();
                }
            });
        });

        function bookTourQuick(tourName) {
            const modal = document.getElementById('quickBookModal');
            const nameEl = document.getElementById('modalTourName');
            const inputEl = document.getElementById('quickTourInput');
            if (nameEl) nameEl.textContent = tourName;
            if (inputEl) inputEl.value = tourName;
            if (modal) {
                modal.classList.remove('opacity-0', 'pointer-events-none');
                modal.querySelector('.transform')?.classList.replace('scale-95', 'scale-100');
            }
        }

        function closeBookModal() {
            const modal = document.getElementById('quickBookModal');
            if (modal) {
                modal.classList.add('opacity-0', 'pointer-events-none');
                modal.querySelector('.transform')?.classList.replace('scale-100', 'scale-95');
            }
        }

        const modalQuickForm = document.getElementById('modalQuickForm');
        if (modalQuickForm) {
            modalQuickForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const userName = document.getElementById('quickUserName')?.value || '';
                closeBookModal();
                showToast(`Cảm ơn ${userName}! Chuyên viên sẽ gọi báo giá ưu đãi trong 5 phút.`, 'success');
                modalQuickForm.reset();
            });
        }

        const newsletterForm = document.getElementById('newsletterForm');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', (e) => {
                e.preventDefault();
                showToast('🎉 Đăng ký thành công! Mã voucher 200k đã được gửi về email của bạn.', 'success');
                newsletterForm.reset();
            });
        }

        function showToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            if (!container) return;
            const toast = document.createElement('div');
            toast.className = 'pointer-events-auto px-4 py-3 rounded-2xl bg-white/95 backdrop-blur-xl border border-slate-200 text-slate-800 text-xs font-semibold shadow-xl flex items-center gap-3 transform translate-y-3 opacity-0 transition-all duration-300';
            const icon = type === 'success' 
                ? '<i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>' 
                : (type === 'warning' ? '<i class="fa-solid fa-triangle-exclamation text-amber-500 text-sm"></i>' : '<i class="fa-solid fa-circle-info text-cyan-600 text-sm"></i>');
            toast.innerHTML = `${icon}<span>${message}</span>`;
            container.appendChild(toast);
            requestAnimationFrame(() => toast.classList.remove('translate-y-3', 'opacity-0'));
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }

        // Notification Toggle Logic
        document.addEventListener('DOMContentLoaded', () => {
            const trigger = document.getElementById('notificationDropdownTrigger');
            const menu = document.getElementById('notificationDropdownMenu');
            if (trigger && menu) {
                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isHidden = menu.classList.contains('opacity-0');
                    if (isHidden) {
                        menu.classList.remove('opacity-0', 'invisible', 'translate-y-2');
                        menu.classList.add('opacity-100', 'translate-y-0');
                    } else {
                        menu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                        menu.classList.remove('opacity-100', 'translate-y-0');
                    }
                });

                document.addEventListener('click', (e) => {
                    if (!trigger.contains(e.target)) {
                        menu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                        menu.classList.remove('opacity-100', 'translate-y-0');
                    }
                });
            }
        });
    </script>

    <!-- Global Floating Theme Toggle Button -->
    <button type="button" class="theme-toggle-btn fixed bottom-6 left-6 z-50 w-12 h-12 rounded-full bg-white dark:bg-slate-800 text-slate-700 dark:text-amber-400 shadow-2xl border border-slate-200 dark:border-slate-700 flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 group focus:outline-none" title="Chuyển đổi giao diện Sáng / Tối" aria-label="Toggle Theme">
        <i class="fa-solid fa-moon text-lg dark:hidden group-hover:rotate-12 transition-transform"></i>
        <i class="fa-solid fa-sun text-lg hidden dark:inline-block text-amber-400 group-hover:rotate-45 transition-transform"></i>
    </button>

    <!-- Quick Hotline Floating Button -->
    <a href="tel:19006868" class="fixed bottom-24 right-7 lg:right-9 z-40 w-12 h-12 rounded-full bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-xl shadow-orange-500/30 flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 group" title="Gọi Hotline Tư Vấn 1900 6868" aria-label="Hotline Tư Vấn">
        <i class="fa-solid fa-phone-volume text-lg group-hover:rotate-12 transition-transform"></i>
        <div class="absolute right-[125%] whitespace-nowrap bg-slate-900 text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-xl opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
            Hotline 24/7: 1900 6868
            <div class="absolute top-1/2 -translate-y-1/2 -right-1 w-2 h-2 bg-slate-900 rotate-45"></div>
        </div>
    </a>

    <!-- AI Chatbot Widget -->
    <div id="aiChatbotWidget" class="fixed bottom-6 right-6 lg:right-8 z-50 font-sans">
        <!-- Chatbot Avatar/Button -->
        <button id="chatbotToggleBtn" class="relative group outline-none focus:outline-none transition-transform hover:scale-105" aria-label="Open AI Assistant">
            <div class="relative w-16 h-16 md:w-20 md:h-20 rounded-full shadow-2xl overflow-hidden bg-gradient-to-tr from-emerald-100 to-teal-50 border-2 border-white shadow-emerald-500/40 flex items-center justify-center animate-float-slow cursor-pointer">
                <!-- Hình AI 3D -->
                <img src="https://cdn-icons-png.flaticon.com/512/8943/8943377.png" alt="AI Agent" class="w-[75%] h-[75%] object-contain pointer-events-none">
            </div>
            <!-- Notification dot -->
            <span class="absolute top-1 right-1 w-4 h-4 bg-rose-500 border-2 border-white rounded-full flex items-center justify-center pointer-events-none">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
            </span>
            <!-- Tooltip -->
            <div class="absolute right-[120%] bottom-1/2 translate-y-1/2 whitespace-nowrap bg-white text-slate-700 text-xs font-bold px-3 py-1.5 rounded-lg shadow-lg shadow-slate-200 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                WanderBot AI
                <div class="absolute top-1/2 -translate-y-1/2 -right-1 w-2 h-2 bg-white rotate-45"></div>
            </div>
        </button>

        <!-- Chat Window -->
        <div id="chatbotWindow" class="absolute bottom-[85px] md:bottom-[95px] right-0 w-[340px] md:w-[380px] h-[520px] max-h-[75vh] bg-white border border-slate-200 rounded-3xl shadow-2xl flex flex-col overflow-hidden opacity-0 translate-y-10 scale-95 pointer-events-none transition-all duration-300 origin-bottom-right z-50">
            <!-- Header -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-4 text-white flex items-center justify-between shrink-0 shadow-sm relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-white/20 rounded-full flex items-center justify-center p-1.5 shadow-inner">
                        <img src="https://cdn-icons-png.flaticon.com/512/8943/8943377.png" alt="Bot Face" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h4 class="font-extrabold text-[15px] leading-tight">WanderBot AI</h4>
                        <p class="text-[11px] font-medium text-emerald-100 flex items-center gap-1 mt-0.5">
                            <span class="w-2 h-2 rounded-full bg-green-300 relative block">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-200 opacity-75"></span>
                            </span> <span class="opacity-90">Đang trực tuyến</span>
                        </p>
                    </div>
                </div>
                <button id="chatbotCloseBtn" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-chevron-down text-sm"></i>
                </button>
            </div>

            <!-- Chat Messages Area -->
            <div id="chatbotMessages" class="flex-1 overflow-y-auto p-4 bg-[#f8fafc] space-y-4 text-[13px] md:text-sm no-scrollbar scroll-smooth">
                <!-- Bot Greeting Message -->
                <div class="flex gap-2.5 max-w-[92%]">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 border border-emerald-200 shadow-sm mt-0.5">
                        <i class="fa-solid fa-robot text-xs text-emerald-600"></i>
                    </div>
                    <div class="bg-white px-4 py-2.5 rounded-2xl rounded-tl-none border border-slate-200 shadow-sm text-slate-700 leading-relaxed">
                        Chào bạn! 👋 Mình là <span class="font-bold text-emerald-600">WanderBot</span> - Trợ lý siêu AI của <b>WanderVibe</b>. Mình có thể tư vấn lịch trình, gợi ý tour du lịch hoặc giải đáp thông tin cho bạn hôm nay nhé!
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="bg-white p-3 border-t border-slate-100 shrink-0 relative z-10 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.02)]">
                <form id="chatbotForm" class="flex items-center gap-2 relative">
                    <input type="text" id="chatbotInput" placeholder="Nhập câu hỏi tại đây..." autocomplete="off"
                        class="flex-1 bg-slate-50 border border-slate-200 px-4 py-2.5 rounded-full text-[13px] md:text-sm text-slate-800 placeholder-slate-400 focus:border-emerald-500 focus:bg-white focus:outline-none transition-colors pr-12">
                    <button type="submit" class="absolute right-1 top-1 bottom-1 w-9 h-9 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white flex items-center justify-center transition-all shadow-md shadow-emerald-500/20 active:scale-95">
                        <i class="fa-solid fa-paper-plane text-xs pr-0.5 pt-0.5"></i>
                    </button>
                </form>
                <div class="text-[9px] text-center text-slate-400 mt-2.5 font-semibold flex flex-col items-center justify-center gap-0.5">
                    <span>Cung cấp bởi WanderVibe AI & Gemini</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Chatbot Javascript Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('chatbotToggleBtn');
            const closeBtn = document.getElementById('chatbotCloseBtn');
            const chatWindow = document.getElementById('chatbotWindow');
            const chatForm = document.getElementById('chatbotForm');
            const chatInput = document.getElementById('chatbotInput');
            const messagesContainer = document.getElementById('chatbotMessages');

            let isOpen = false;

            // Mở / Đóng cửa sổ Chat
            function toggleChat() {
                isOpen = !isOpen;
                if(isOpen) {
                    chatWindow.classList.remove('opacity-0', 'translate-y-10', 'scale-95', 'pointer-events-none');
                    chatWindow.classList.add('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                    // Tắt dấu chấm đỏ thông báo
                    const dot = toggleBtn.querySelector('.bg-rose-500');
                    if(dot) dot.style.display = 'none';
                    // Focus input sau khi anim xong
                    setTimeout(() => chatInput.focus(), 300);
                } else {
                    chatWindow.classList.add('opacity-0', 'translate-y-10', 'scale-95', 'pointer-events-none');
                    chatWindow.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                }
            }

            toggleBtn.addEventListener('click', toggleChat);
            closeBtn.addEventListener('click', toggleChat);

            // Hàm tạo render HTML cho tin nhắn UI
            function appendMessage(text, sender = 'user') {
                const msgDiv = document.createElement('div');
                
                if (sender === 'user') {
                    msgDiv.className = 'flex gap-2.5 max-w-[92%] ml-auto justify-end';
                    msgDiv.innerHTML = `
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-500 px-4 py-2.5 rounded-2xl rounded-tr-none shadow-md shadow-emerald-500/20 text-white leading-relaxed break-words">
                            ${text}
                        </div>
                    `;
                } else if (sender === 'bot') {
                    msgDiv.className = 'flex gap-2.5 max-w-[92%]';
                    // Format text from bot (bold, line breaks)
                    const formattedText = text.replace(/\\n/g, '<br>').replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');
                    msgDiv.innerHTML = `
                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 border border-emerald-200 shadow-sm mt-0.5">
                            <i class="fa-solid fa-robot text-xs text-emerald-600"></i>
                        </div>
                        <div class="bg-white px-4 py-2.5 rounded-2xl rounded-tl-none border border-slate-200 shadow-sm text-slate-700 leading-relaxed break-words">
                            ${formattedText}
                        </div>
                    `;
                } else if (sender === 'loading') {
                    msgDiv.className = 'flex gap-2.5 max-w-[92%] bot-typing';
                    msgDiv.innerHTML = `
                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 border border-emerald-200 shadow-sm mt-0.5">
                            <i class="fa-solid fa-robot text-xs text-emerald-600"></i>
                        </div>
                        <div class="bg-white px-4 py-3.5 rounded-2xl rounded-tl-none border border-slate-200 shadow-sm flex items-center gap-1.5">
                            <div class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce [animation-delay:-0.3s]"></div>
                            <div class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce [animation-delay:-0.15s]"></div>
                            <div class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce"></div>
                        </div>
                    `;
                }

                messagesContainer.appendChild(msgDiv);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                return msgDiv;
            }

            // Bắt sự kiện Gửi tin nhắn
            chatForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const text = chatInput.value.trim();
                if(!text) return;

                // 1. Gắn tin nhắn User
                appendMessage(text, 'user');
                chatInput.value = '';

                // 2. Gắn icon Loading của Bot chờ
                const loadingDiv = appendMessage('', 'loading');

                // 3. Gửi request REST API tới route chat hiện tại của Laravel
                try {
                    const token = document.querySelector('meta[name="csrf-token"]');
                    const headers = { 'Content-Type': 'application/json' };
                    if(token) headers['X-CSRF-TOKEN'] = token.getAttribute('content');

                    const response = await fetch('/api/chat', {
                        method: 'POST',
                        headers: headers,
                        body: JSON.stringify({ message: text }) // Payload text
                    });
                    
                    loadingDiv.remove();

                    if (!response.ok) throw new Error('API Request Failed');
                    
                    // Parse Response 
                    try {
                        const data = await response.json();
                        // Trích xuất reply hoặc message
                        const botReply = data.reply || data.message || data.response || "Rất tiếc hệ thống AI gặp lỗi trả về nội dung trống.";
                        appendMessage(botReply, 'bot');
                    } catch(jsonError) {
                         // Nếu API không trả về json (bị lỗi server html)
                         console.error(jsonError);
                         appendMessage("WanderBot AI hiện đang bảo trì và nâng cấp. Phiền bạn liên hệ Tổng đài CSKH nhé!", 'bot');
                    }

                } catch (error) {
                    loadingDiv.remove();
                    console.error("Chat Error:", error);
                    appendMessage("WanderBot AI hiện đang không thể kết nối tới máy chủ. Xin vui lòng thử lại sau!", 'bot');
                }
            });
        });

        // Global Theme Switcher
        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }
        document.querySelectorAll('.theme-toggle-btn').forEach(btn => {
            btn.addEventListener('click', toggleTheme);
        });
    </script>
</body>
</html>