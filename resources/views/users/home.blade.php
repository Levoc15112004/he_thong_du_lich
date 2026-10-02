@extends('users.master')

@section('home')
    {{-- ================= HERO SECTION ================= --}}
    @php
        $firstBanner = $banners->first();
    @endphp
    <section id="hero" class="relative w-full h-[100dvh] min-h-[640px] flex items-center justify-center overflow-hidden">
        <video id="heroVideo" autoplay muted loop playsinline
            poster="{{ $firstBanner && $firstBanner->image ? (Str::startsWith($firstBanner->image, ['http://', 'https://']) ? $firstBanner->image : asset($firstBanner->image)) : 'https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=1920&q=80' }}"
            class="absolute inset-0 w-full h-full object-cover object-center scale-105 transition-all duration-1000 filter brightness-95">
            <source src="https://assets.mixkit.co/videos/preview/mixkit-aerial-view-of-waves-crashing-on-a-rocky-shore-41484-large.mp4" type="video/mp4">
            Trình duyệt của bạn không hỗ trợ video HTML5.
        </video>
        
        <div class="absolute inset-0 hero-cinematic-overlay pointer-events-none"></div>

        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-16 sm:pt-20 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-xl border border-white/30 text-slate-100 text-xs sm:text-sm font-bold shadow-2xl mb-5 animate-pulse-soft">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                <i class="fa-solid fa-crown text-amber-300"></i>
                <span>Khám Phá Việt Nam Cùng Thế Hệ Trẻ</span>
            </div>

            <h1 id="heroTitle" class="text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight leading-[1.15] max-w-4xl transition-all duration-500 drop-shadow-2xl">
                {!! $firstBanner->name ?? $firstBanner->title ?? 'Chạm Vào Cực Bắc Kỳ Vĩ <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-orange-300 to-amber-200">Hà Giang</span>' !!}
            </h1>

            <p id="heroSubtitle" class="mt-4 sm:mt-6 text-sm sm:text-lg md:text-xl text-slate-100 max-w-2xl font-normal leading-relaxed transition-all duration-500 drop-shadow">
                {{ $firstBanner->description ?? 'Lướt trên cung đèo Mã Pí Lèng huyền thoại, dong thuyền ngắm dòng Nho Quế màu ngọc bích và đắm chìm trong vẻ đẹp bất tận của non nước.' }}
            </p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <a href="#tours" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:to-amber-600 text-white font-extrabold text-sm sm:text-base shadow-2xl shadow-orange-500/30 hover:scale-105 active:scale-95 transition-all duration-300 flex items-center gap-3 group">
                    <i class="fa-solid fa-compass group-hover:rotate-45 transition-transform duration-300 text-lg"></i>
                    <span>Khám Phá Tour Ngay</span>
                    <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1.5 transition-transform"></i>
                </a>
                <a href="#destinations" class="px-7 py-4 rounded-2xl bg-white/20 hover:bg-white/30 backdrop-blur-xl border border-white/35 text-white font-bold text-sm sm:text-base transition-all duration-300 hover:scale-105 active:scale-95 flex items-center gap-2">
                    <i class="fa-solid fa-map-location-dot text-amber-300"></i>
                    <span>Xem Điểm Đến Hot</span>
                </a>
            </div>

            <!-- Quick Destination Switcher -->
            <div class="mt-10 sm:mt-12 flex items-center gap-2 overflow-x-auto no-scrollbar max-w-full p-1.5 bg-white/20 backdrop-blur-2xl rounded-2xl border border-white/35">
                <button onclick="switchHeroVideo('hagiang')" class="hero-switcher-btn active px-4 sm:px-5 py-2 rounded-xl text-xs sm:text-sm font-extrabold transition-all bg-white text-emerald-600 shadow-lg shadow-black/5 flex items-center gap-1.5">
                    <span>Hà Giang</span>
                </button>
                <button onclick="switchHeroVideo('phuquoc')" class="hero-switcher-btn px-4 sm:px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all bg-transparent text-slate-100 hover:bg-white/20 hover:text-white flex items-center gap-1.5">
                    <span>Phú Quốc</span>
                </button>
                <button onclick="switchHeroVideo('dalat')" class="hero-switcher-btn px-4 sm:px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all bg-transparent text-slate-100 hover:bg-white/20 hover:text-white flex items-center gap-1.5">
                    <span>Đà Lạt</span>
                </button>
                <button onclick="switchHeroVideo('halong')" class="hero-switcher-btn px-4 sm:px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all bg-transparent text-slate-100 hover:bg-white/20 hover:text-white flex items-center gap-1.5">
                    <span>Vịnh Hạ Long</span>
                </button>
            </div>

            <div class="absolute bottom-6 right-6 z-30 hidden sm:flex items-center gap-2.5">
                <button id="toggleVideoPlayBtn" class="px-3.5 py-2 rounded-xl bg-white/20 backdrop-blur-xl border border-white/30 text-white hover:bg-white/30 text-xs font-bold transition-all flex items-center gap-2">
                    <i class="fa-solid fa-pause" id="playIcon"></i>
                    <span id="playText">Dừng video</span>
                </button>
                <div class="flex items-center gap-1 px-3 py-2 rounded-xl bg-white/20 backdrop-blur-xl border border-white/30 text-white text-xs">
                    <div class="w-1 bg-white rounded-full sound-wave-bar"></div>
                    <div class="w-1 bg-white rounded-full sound-wave-bar"></div>
                    <div class="w-1 bg-white rounded-full sound-wave-bar"></div>
                    <div class="w-1 bg-white rounded-full sound-wave-bar"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= SEARCH SECTION ================= --}}
    <section id="searchSection" class="relative z-30 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 sm:-mt-16">
        <div class="search-aura-light rounded-3xl p-1 text-left">
            <div class="glass-panel-light rounded-[22px] p-5 sm:p-7 shadow-xl relative">
                <!-- Background effects -->
                <div class="absolute inset-0 overflow-hidden pointer-events-none rounded-[22px]">
                    <div class="absolute -right-16 -bottom-16 w-52 h-52 bg-emerald-100 rounded-full blur-2xl"></div>
                </div>
                <form id="tourSearchForm" action="{{ route('user.home.search') }}" method="POST" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 relative z-20">
                    @csrf
                    <div class="relative flex-1 group">
                        <div class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-emerald-500 z-10">
                            <i class="fa-solid fa-location-dot text-xl"></i>
                        </div>
                        <input type="text" name="keyword" id="searchDestination" value="{{ request('keyword') }}"
                            placeholder="Bạn muốn xách balo đến đâu? (VD: Hà Giang, Sa Pa...)" autocomplete="off"
                            class="w-full pl-12 sm:pl-14 pr-11 py-4 rounded-2xl bg-white border border-slate-200 text-slate-800 placeholder-slate-400 text-sm sm:text-base focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all duration-300 shadow-sm relative z-20">
                        <button type="button" id="clearSearchBtn" class="hidden absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors z-20" title="Xóa tìm kiếm">
                            <i class="fa-solid fa-circle-xmark text-lg"></i>
                        </button>

                        <!-- Auto-suggest Dropdown -->
                        <div id="searchSuggestions" class="hidden absolute top-[calc(100%+8px)] left-0 right-0 bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50 max-h-72 overflow-y-auto w-full transition-all duration-300">
                            <!-- JS will populate suggestions here -->
                        </div>
                    </div>
                    <button type="submit" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600 hover:from-emerald-600 hover:to-teal-600 text-white font-extrabold text-sm sm:text-base shadow-lg shadow-emerald-500/25 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2.5 group/btn whitespace-nowrap z-10">
                        <i class="fa-solid fa-magnifying-glass text-base group-hover/btn:rotate-12 transition-transform"></i>
                        <span>Tìm Điểm Đến</span>
                        <i class="fa-solid fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform"></i>
                    </button>
                </form>

                <!-- Trending Tags from Database Destinations -->
                <div class="mt-4 pt-3.5 border-t border-slate-100 flex flex-wrap items-center gap-2 text-xs relative z-10">
                    <span class="inline-flex items-center gap-1.5 text-rose-500 font-extrabold text-[11px] tracking-wide uppercase mr-1">
                        <i class="fa-solid fa-fire text-rose-500"></i> Xu Hướng:
                    </span>
                    @forelse($destinations->take(6) as $dest)
                        <button type="button" class="quick-tag px-3.5 py-1.5 rounded-full bg-slate-50 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 text-slate-600 font-semibold border border-slate-200 transition-all flex items-center gap-1.5 hover:scale-105 active:scale-95"
                            data-query="{{ $dest->end_location }}">
                            <span>📍 {{ $dest->end_location }}</span>
                        </button>
                    @empty
                        <button type="button" class="quick-tag px-3.5 py-1.5 rounded-full bg-slate-50 text-slate-600 border border-slate-200" data-query="Hà Giang">Hà Giang</button>
                        <button type="button" class="quick-tag px-3.5 py-1.5 rounded-full bg-slate-50 text-slate-600 border border-slate-200" data-query="Đà Lạt">Đà Lạt</button>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- ================= CEO / CRO / TRUST SIGNALS ================= --}}
    <section class="mt-8 mb-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl p-4 sm:p-5 flex items-center gap-3.5 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-shield-halved text-xl"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-slate-800 dark:text-slate-100 text-sm">Bảo Hiểm 100 Tr</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Bảo hiểm du lịch toàn diện</p>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl p-4 sm:p-5 flex items-center gap-3.5 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-11 h-11 rounded-xl bg-orange-50 dark:bg-orange-950 text-orange-600 dark:text-orange-400 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-hand-holding-dollar text-xl"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-slate-800 dark:text-slate-100 text-sm">Cam Kết Giá Tốt</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Hoàn tiền nếu sai dịch vụ</p>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl p-4 sm:p-5 flex items-center gap-3.5 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-headset text-xl"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-slate-800 dark:text-slate-100 text-sm">Hỗ Trợ 24/7</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Đội ngũ bản địa tận tâm</p>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl p-4 sm:p-5 flex items-center gap-3.5 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-11 h-11 rounded-xl bg-indigo-50 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-bolt text-xl"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-slate-800 dark:text-slate-100 text-sm">Xác Nhận Tức Thì</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Mã giữ chỗ gửi sau 30s</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= WEATHER FORECAST SECTION ================= --}}
    <section id="weather" class="pt-24 pb-14 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 border border-emerald-200/80 px-3.5 py-1.5 rounded-full mb-3 shadow-sm">
                        <i class="fa-solid fa-cloud-sun-rain text-emerald-600"></i> Trạm thời tiết trực tiếp
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">Dự Báo Thời Tiết Điểm Đến</h2>
                    <p class="text-slate-500 text-sm mt-1">Cập nhật thời tiết OpenWeather và các gợi ý trang phục khám phá</p>
                </div>
                <div class="flex flex-col xl:flex-row items-center gap-3">
                    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar p-1.5 bg-white/60 backdrop-blur-xl rounded-2xl border border-slate-200 shadow-sm" id="weatherTabs">
                        <button data-loc="Đà Lạt" class="weather-tab-btn active px-4 py-2 rounded-xl text-xs font-bold transition-all bg-emerald-500 text-white shadow-md shadow-emerald-500/20">Đà Lạt</button>
                        <button data-loc="Sa Pa" class="weather-tab-btn px-4 py-2 rounded-xl text-xs font-bold transition-all bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900">Sa Pa</button>
                        <button data-loc="Phú Quốc" class="weather-tab-btn px-4 py-2 rounded-xl text-xs font-bold transition-all bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900">Phú Quốc</button>
                        <button data-loc="Đà Nẵng" class="weather-tab-btn px-4 py-2 rounded-xl text-xs font-bold transition-all bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900">Đà Nẵng</button>
                    </div>
                    <form id="weatherSearchForm" class="flex items-center gap-2 w-full xl:w-auto">
                        <input type="text" id="weatherCityInput" placeholder="Nhập tên thành phố..." class="flex-1 xl:flex-none px-4 py-2 text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 xl:min-w-[200px]" required>
                        <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-700 transition-colors shrink-0">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div id="weatherContent" class="glass-panel-light rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all duration-500 border border-slate-200 dark:border-slate-800 shadow-xl">
                <div class="absolute -right-20 -top-20 w-80 h-80 bg-teal-200/50 dark:bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-emerald-200/50 dark:bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                    <!-- OpenWeather Backend Data Fallback to UI Presets -->
                    <div class="flex items-center gap-6 border-b lg:border-b-0 lg:border-r border-slate-200 dark:border-slate-700 pb-6 lg:pb-0 lg:pr-6">
                        <div id="weatherIconContainer" class="w-24 h-24 rounded-2xl bg-gradient-to-br from-indigo-400 to-sky-400 border border-indigo-300 shadow-lg flex items-center justify-center text-5xl text-white">
                            @if(!empty($weatherData['icon']))
                                <img src="https://openweathermap.org/img/wn/{{ $weatherData['icon'] }}@2x.png" alt="icon" class="w-20 h-20 scale-125 drop-shadow-md pb-1">
                            @else
                                <i class="fa-solid fa-cloud-sun drop-shadow-md"></i>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-baseline gap-2">
                                <span id="weatherTemp" class="text-5xl sm:text-6xl font-bold tracking-tight text-slate-900 dark:text-white">
                                    {{ $weatherData['temp'] ?? 19 }}°C
                                </span>
                                <span class="text-emerald-600 dark:text-emerald-400 text-sm font-semibold capitalize" id="weatherStatusText">
                                    {{ $weatherData['desc'] ?? 'Mát mẻ dễ chịu' }}
                                </span>
                            </div>
                            <h3 id="weatherCity" class="text-xl font-bold mt-1 text-slate-800 dark:text-white">{{ $weatherData['city'] ?? 'Hà Nội' }}, Việt Nam</h3>
                            <p id="weatherDesc" class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Dự báo theo thời gian thực trạm khí tượng vệ tinh</p>
                        </div>
                    </div>

                    <!-- Metrics -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-2 gap-3.5">
                        <div class="bg-white dark:bg-slate-800/90 rounded-2xl p-3.5 border border-slate-100 dark:border-slate-700 shadow-sm">
                            <span class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1.5"><i class="fa-solid fa-droplet text-cyan-500"></i> Độ ẩm</span>
                            <span id="weatherHumidity" class="text-lg font-bold mt-1 block text-slate-800 dark:text-white">78%</span>
                        </div>
                        <div class="bg-white dark:bg-slate-800/90 rounded-2xl p-3.5 border border-slate-100 dark:border-slate-700 shadow-sm">
                            <span class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1.5"><i class="fa-solid fa-wind text-teal-500"></i> Gió nhẹ</span>
                            <span id="weatherWind" class="text-lg font-bold mt-1 block text-slate-800 dark:text-white">12 km/h</span>
                        </div>
                        <div class="bg-white dark:bg-slate-800/90 rounded-2xl p-3.5 border border-slate-100 dark:border-slate-700 shadow-sm">
                            <span class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1.5"><i class="fa-solid fa-sun text-amber-500"></i> Chỉ số UV</span>
                            <span id="weatherUV" class="text-lg font-bold mt-1 block text-slate-800 dark:text-white">3 - Thấp</span>
                        </div>
                        <div class="bg-white dark:bg-slate-800/90 rounded-2xl p-3.5 border border-slate-100 dark:border-slate-700 shadow-sm">
                            <span class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1.5"><i class="fa-solid fa-calendar-days text-emerald-500"></i> 5 Ngày Tới</span>
                            <span id="weatherVisibility" class="text-lg font-bold mt-1 block text-slate-800 dark:text-white">{{ count($forecastData) }} mốc dự báo</span>
                        </div>
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-800/80 rounded-2xl p-5 border border-slate-200 dark:border-slate-700 flex flex-col justify-between">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-amber-600 dark:text-amber-400 text-xs font-bold uppercase tracking-wider">
                                <i class="fa-solid fa-shirt"></i> Gợi Ý Mix Đồ & Săn Ảnh
                            </div>
                            <p id="weatherAdvice" class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                                {{ $weatherData['advice'] ?? 'Chuẩn bị trang phục thoáng mát hoặc áo khoác nhẹ tùy vào vùng cao hoặc biển. Mang theo kem chống nắng và kính râm khi dạo biển.' }}
                            </p>
                        </div>
                        <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700 flex items-center justify-between text-xs text-emerald-700 dark:text-emerald-400">
                            <span class="font-medium">Độ hoàn hảo du lịch:</span>
                            <span id="weatherScore" class="font-bold {{ $weatherData['scoreColor'] ?? 'text-amber-600' }} {{ $weatherData['scoreBg'] ?? 'bg-amber-100' }} border border-white/50 px-3 py-1 rounded-full shadow-sm">
                                {{ $weatherData['scoreText'] ?? '9.8 / 10 Tuyệt Vời' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- 5 Day Forecast Layout -->
                <div class="relative z-10 mt-8 pt-8 border-t border-slate-200/60 dark:border-slate-700/60">
                    <h4 class="text-sm font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2"><i class="fa-solid fa-calendar-week text-emerald-500"></i> Dự báo 5 ngày tiếp theo</h4>
                    <div id="forecastContainer" class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        @if(!empty($forecastData))
                            @foreach($forecastData as $day)
                                <div class="bg-white dark:bg-slate-800/90 rounded-2xl p-4 border border-slate-100 dark:border-slate-700 shadow-sm text-center hover:-translate-y-1 transition-transform">
                                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mb-2">{{ $day['date'] ?? '' }}</p>
                                    <div class="w-14 h-14 mx-auto bg-gradient-to-br from-indigo-400 to-sky-400 rounded-full flex items-center justify-center mb-3 shadow-md border border-indigo-300 overflow-hidden">
                                        <img src="https://openweathermap.org/img/wn/{{ $day['icon'] ?? '01d' }}@2x.png" alt="icon" class="w-16 h-16 object-contain scale-110 drop-shadow-md pb-1">
                                    </div>
                                    <p class="text-lg font-bold text-slate-800 dark:text-white">{{ $day['temp'] ?? 0 }}°</p>
                                </div>
                            @endforeach
                        @else
                            <p class="col-span-5 text-sm text-slate-500 dark:text-slate-400 text-center py-4">Chưa có dữ liệu dự báo</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= HOT TOURS SECTION ================= --}}
    <section id="tours" class="py-20 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-rose-700 bg-rose-50 border border-rose-200/80 px-3.5 py-1.5 rounded-full mb-3 shadow-sm">
                        <i class="fa-solid fa-fire text-rose-500"></i> Xu hướng thịnh hành
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">Top Tour Nổi Bật Được Quan Tâm Nhất</h2>
                    <p class="text-slate-500 text-sm mt-1">Các tour có số lượt xem và đặt chỗ cao nhất từ hệ thống</p>
                </div>
                <a href="{{ route('user.tours') }}" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-600 hover:text-emerald-700 group transition-colors">
                    <span>Xem tất cả điểm đến</span>
                    <i class="fa-solid fa-arrow-right-long group-hover:translate-x-1.5 transition-transform"></i>
                </a>
            </div>

            <!-- Loop Hot Tours from Controller -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($hotTours->take(8) as $tour)
                    <div class="glass-card-interactive rounded-3xl overflow-hidden flex flex-col group cursor-pointer bg-white transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl"
                        onclick="window.location.href='{{ route('user.tourDetail.index', $tour->id) }}'">
                        <a href="{{ route('user.tourDetail.index', $tour->id) }}" class="relative h-56 overflow-hidden block">
                            @php
                                $imgSrc = $tour->image ? (Str::startsWith($tour->image, ['http://', 'https://']) ? $tour->image : asset($tour->image)) : 'https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=700&q=80';
                            @endphp
                            <img src="{{ $imgSrc }}" alt="{{ $tour->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/10"></div>
                            <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-md text-rose-600 text-xs font-extrabold px-3 py-1 rounded-full shadow-lg border border-rose-100">
                                <i class="fa-solid fa-fire"></i> Hot {{ $tour->total_views ?? 0 }} views
                            </span>
                            <span class="absolute top-3 right-3 bg-slate-900/80 backdrop-blur-md text-white text-xs font-semibold px-2.5 py-1 rounded-full border border-slate-700">
                                <i class="fa-regular fa-clock"></i> {{ $tour->time ?? $tour->duration ?? '3N2Đ' }}
                            </span>
                        </a>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between text-xs text-slate-500 mb-2">
                                    <span class="flex items-center gap-1.5 font-medium">
                                        <i class="fa-solid fa-location-dot text-emerald-500"></i> {{ $tour->end_location ?? 'Việt Nam' }}
                                    </span>
                                    <span class="flex items-center gap-1 font-bold text-amber-500">
                                        <i class="fa-solid fa-star"></i> {{ number_format($tour->rating ?? 4.9, 1) }}
                                    </span>
                                </div>
                                <a href="{{ route('user.tourDetail.index', $tour->id) }}" class="block">
                                    <h3 class="text-base font-bold text-slate-900 group-hover:text-emerald-600 transition-colors line-clamp-2 leading-snug">
                                        {{ $tour->name }}
                                    </h3>
                                </a>
                                <p class="mt-2 text-xs text-slate-500 line-clamp-2">
                                    {{ $tour->description ?? 'Lịch trình khám phá danh lam thắng cảnh tự do, hỗ trợ xe đưa đón tận nơi và hướng dẫn viên bản địa.' }}
                                </p>
                            </div>
                            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <div class="text-emerald-600 font-extrabold text-lg">
                                        {{ number_format($tour->sale_price, 0, ',', '.') }}<span class="text-xs font-medium">đ</span>
                                    </div>
                                </div>
                                <a href="{{ route('user.tourDetail.index', $tour->id) }}"
                                    class="px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 group-hover:bg-emerald-500 group-hover:text-white font-bold text-xs transition-all flex items-center gap-1.5 border border-emerald-100 shadow-sm"
                                    onclick="event.stopPropagation()">
                                    <span>Xem Chi Tiết</span>
                                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-500">
                        Chưa có dữ liệu tour hot. Vui lòng thêm dữ liệu trong cơ sở dữ liệu.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ================= 8 FAMOUS DESTINATIONS SECTION ================= --}}
    <section id="destinations" class="py-20 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 border border-emerald-200/80 px-3.5 py-1.5 rounded-full mb-3 shadow-sm">
                    <i class="fa-solid fa-earth-americas text-emerald-600"></i> Điểm đến nổi bật
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">Điểm Đến Hấp Dẫn Không Thể Bỏ Lỡ</h2>
                <p class="text-slate-500 text-sm mt-2">Dù bạn thích lên rừng săn mây hay xuống biển đón nắng vàng, mọi cảnh sắc Việt Nam đều sẵn sàng chào đón</p>
            </div>

            <!-- Loop Destinations from Controller -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($destinations as $item)
                    @php
                        $destImg = $item->image ? (Str::startsWith($item->image, ['http://', 'https://']) ? $item->image : asset($item->image)) : 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=600&q=80';
                    @endphp
                    <a href="{{ route('user.destination', ['location' => $item->end_location]) }}"
                        class="group relative h-72 rounded-3xl overflow-hidden shadow-xl border border-slate-200 hover:border-emerald-400/50 cursor-pointer transition-all duration-500 hover:-translate-y-2">
                        <img src="{{ $destImg }}" alt="{{ $item->end_location }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>
                        <span class="absolute top-4 right-4 bg-white/95 backdrop-blur-md text-emerald-700 text-xs px-3 py-1 rounded-full font-bold border border-slate-200 shadow-sm">
                            {{ $item->total_tours }} Tours
                        </span>
                        <div class="absolute bottom-5 left-5 right-5 text-white">
                            <span class="text-[10px] text-amber-300 font-bold uppercase tracking-wider block mb-1">Điểm hẹn lý tưởng</span>
                            <h3 class="text-xl font-bold group-hover:text-emerald-300 group-hover:translate-x-1 transition-all">
                                {{ $item->end_location }}
                            </h3>
                            <p class="text-xs text-slate-200 line-clamp-1 mt-1 opacity-0 group-hover:opacity-100 transition-opacity">Khám phá trải nghiệm độc đáo tại {{ $item->end_location }}</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-500">
                        Chưa có tọa độ điểm đến nào được tìm thấy.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ================= BLOGS / TRAVEL GUIDES SECTION ================= --}}
    <section id="blogs" class="py-20 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 border border-emerald-200/80 px-3.5 py-1.5 rounded-full mb-3 shadow-sm">
                        <i class="fa-solid fa-book-open-reader text-emerald-600"></i> Cẩm nang du lịch
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">Kinh Nghiệm & Review Du Lịch</h2>
                    <p class="text-slate-500 text-sm mt-1">Những bài viết chia sẻ thực tế, bí kíp săn ảnh triệu view và mẹo du lịch tiết kiệm</p>
                </div>
                <a href="{{ route('blog.index') }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-2 transition-colors">
                    <span>Xem tất cả bài viết</span>
                    <i class="fa-solid fa-arrow-right-long"></i>
                </a>
            </div>

            <!-- Loop Blogs from Controller -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($blogs->take(4) as $post)
                    @php
                        $postImg = $post->image ? (Str::startsWith($post->image, ['http://', 'https://']) ? $post->image : asset($post->image)) : 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80';
                    @endphp
                    <article class="glass-card-interactive rounded-3xl overflow-hidden flex flex-col group cursor-pointer bg-white transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl"
                        onclick="window.location.href='{{ route('blog.show', $post->id ?? 1) }}'">
                        <a href="{{ route('blog.show', $post->id ?? 1) }}" class="relative h-48 overflow-hidden block">
                            <img src="{{ $postImg }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <span class="absolute bottom-3 left-3 bg-white/95 backdrop-blur-md border border-slate-200 text-emerald-700 text-[11px] font-bold px-3 py-1 rounded-full shadow-sm">
                                {{ $post->category->name ?? 'Cẩm Nang' }}
                            </span>
                        </a>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-3 text-xs text-slate-500 mb-2 font-medium">
                                    <span><i class="fa-regular fa-calendar text-emerald-500"></i> {{ $post->created_at ? $post->created_at->format('d/m/Y') : date('d/m/Y') }}</span>
                                    <span>• 5 phút đọc</span>
                                </div>
                                <a href="{{ route('blog.show', $post->id ?? 1) }}" class="block">
                                    <h3 class="text-base font-bold text-slate-900 group-hover:text-emerald-600 transition-colors line-clamp-2">
                                        {{ $post->title }}
                                    </h3>
                                </a>
                                <p class="text-slate-500 text-xs mt-2 line-clamp-2 leading-relaxed">
                                    {{ Str::limit(strip_tags($post->content ?? $post->summary ?? 'Kinh nghiệm du lịch thực tế, lịch trình và các điểm check-in hấp dẫn.'), 90) }}
                                </p>
                            </div>
                            <a href="{{ route('blog.show', $post->id ?? 1) }}" class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-emerald-600 group-hover:underline">
                                <span>Đọc bài viết</span>
                                <i class="fa-solid fa-arrow-right text-xs text-emerald-600 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-500">
                        Chưa có bài viết blog nào được đăng tải.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ================= CONTACT SECTION ================= --}}
    <section id="contact" class="py-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl glass-panel-light p-8 sm:p-12 lg:p-16 text-slate-800 dark:text-slate-100 relative overflow-hidden border border-slate-200 dark:border-slate-800 shadow-xl dark:shadow-2xl">
                <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-emerald-200/50 dark:bg-emerald-500/10 blur-3xl pointer-events-none"></div>
                <div class="absolute -left-24 -bottom-24 w-96 h-96 rounded-full bg-teal-200/50 dark:bg-teal-500/10 blur-3xl pointer-events-none"></div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">
                    <div>
                        <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200/80 dark:border-emerald-800/80 px-3.5 py-1.5 rounded-full mb-3 shadow-sm">
                            <i class="fa-solid fa-headset text-emerald-600 dark:text-emerald-400"></i> Hỗ trợ 24/7 tận tâm
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight text-slate-900 dark:text-white">
                            Bạn cần tư vấn về tour, lịch trình hay đặt dịch vụ? Hãy để chúng tôi giúp bạn!
                        </h2>
                        <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base mt-4 font-normal leading-relaxed">
                            Đội ngũ travel planner trẻ trung của WanderVibe luôn sẵn sàng lên kế hoạch chi tiết, tiết kiệm và tối ưu trải nghiệm check-in sống ảo nhất cho chuyến đi của bạn.
                        </p>

                        <div class="mt-8 space-y-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-xl shadow-sm shrink-0">
                                    <i class="fa-solid fa-phone-volume"></i>
                                </div>
                                <div>
                                    <span class="text-xs font-semibold text-slate-500 dark:text-emerald-400/90 block uppercase tracking-wider">Hotline đặt tour nhanh</span>
                                    <span class="text-lg sm:text-xl font-extrabold tracking-wide text-slate-900 dark:text-white">1900 888 999 (Nhánh 1)</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-xl shadow-sm shrink-0">
                                    <i class="fa-regular fa-envelope"></i>
                                </div>
                                <div>
                                    <span class="text-xs font-semibold text-slate-500 dark:text-emerald-400/90 block uppercase tracking-wider">Email tư vấn & báo giá</span>
                                    <a href="mailto:hello@wandervibe.me" class="text-lg sm:text-xl font-extrabold tracking-wide text-slate-900 dark:text-white hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">hello@wandervibe.me</a>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-xl shadow-sm shrink-0">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div>
                                    <span class="text-xs font-semibold text-slate-500 dark:text-emerald-400/90 block uppercase tracking-wider">Văn phòng chính</span>
                                    <span class="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-snug block">Tòa nhà Landmark 81, P. 22, Q. Bình Thạnh, TP. Hồ Chí Minh</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Consultation Form -->
                    <div class="bg-white dark:bg-slate-800/95 p-6 sm:p-8 rounded-3xl border border-slate-200 dark:border-slate-700/80 shadow-xl dark:shadow-2xl backdrop-blur-xl">
                        <h3 class="text-xl font-extrabold mb-1 text-slate-900 dark:text-white">Gửi yêu cầu tư vấn</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-6 font-medium">Nhận báo giá và lịch trình mẫu qua Zalo/Email trong vòng 10 phút</p>

                        <form id="contactForm" method="POST" action="{{ route('consultation.send') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label for="contactName" class="block text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5">Họ và tên của bạn</label>
                                <input type="text" name="name" id="contactName" value="{{ $user->name ?? '' }}" required placeholder="Ví dụ: Hoàng Minh"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 placeholder-slate-400 dark:placeholder-slate-500 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-emerald-500/10 transition-all">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="contactPhone" class="block text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5">Số điện thoại / Zalo</label>
                                    <input type="tel" name="phone" id="contactPhone" value="{{ $user->phone ?? '' }}" required placeholder="0909 xxx xxx"
                                        class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 placeholder-slate-400 dark:placeholder-slate-500 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-emerald-500/10 transition-all">
                                </div>
                                <div>
                                    <label for="contactDestination" class="block text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5">Điểm đến quan tâm</label>
                                    <input type="text" name="destination" id="contactDestination" placeholder="Hà Giang, Sa Pa..."
                                        class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 placeholder-slate-400 dark:placeholder-slate-500 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-emerald-500/10 transition-all">
                                </div>
                            </div>

                            <div>
                                <label for="contactMessage" class="block text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5">Yêu cầu đặc biệt</label>
                                <textarea name="message" id="contactMessage" rows="3" placeholder="Nhóm mình gồm 4 bạn trẻ muốn đi vào cuối tuần này..."
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 placeholder-slate-400 dark:placeholder-slate-500 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-emerald-500/10 transition-all resize-none"></textarea>
                            </div>

                            <div id="homeConsultationFeedback" class="hidden rounded-xl p-3 text-xs font-semibold text-center transition-all"></div>

                            <button type="submit" id="homeConsultationBtn" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600 hover:from-emerald-600 hover:to-teal-600 text-white font-extrabold text-sm uppercase tracking-wider shadow-lg shadow-emerald-500/25 hover:scale-[1.01] active:scale-[0.99] transition-all">
                                <i class="fa-solid fa-paper-plane mr-2"></i> Nhận tư vấn nhanh
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Auto-suggest Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchDestination');
            const suggestionsBox = document.getElementById('searchSuggestions');
            let searchTimeout = null;

            if (searchInput && suggestionsBox) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const keyword = this.value.trim();

                    if (keyword.length > 0) {
                        searchTimeout = setTimeout(() => {
                            fetch(`{{ route('user.search') }}?keyword=${encodeURIComponent(keyword)}`)
                                .then(response => response.json())
                                .then(data => {
                                    suggestionsBox.innerHTML = '';
                                    if (data && data.length > 0) {
                                        data.forEach(tour => {
                                            const item = document.createElement('div');
                                            item.className = 'px-4 py-3 hover:bg-emerald-50 cursor-pointer flex items-center gap-3 border-b border-slate-100 last:border-0 transition-colors bg-white';
                                            
                                            // Handle relative/absolute image paths
                                            let imgSrc = tour.image || '';
                                            if (imgSrc && !imgSrc.startsWith('http')) {
                                                imgSrc = '{{ asset("") }}' + imgSrc;
                                            } else if (!imgSrc) {
                                                imgSrc = 'https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=100&q=80';
                                            }

                                            const locationStr = tour.end_location ? `<span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-bold whitespace-nowrap"><i class="fa-solid fa-location-dot mr-1"></i>${tour.end_location}</span>` : '';
                                            const priceFormated = new Intl.NumberFormat('vi-VN', { style: 'decimal' }).format(tour.price) + 'đ';
                                            
                                            item.innerHTML = `
                                                <div class="w-12 h-12 rounded-xl overflow-hidden shrink-0 bg-slate-100 shadow-sm border border-slate-200">
                                                    <img src="${imgSrc}" class="w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=100&q=80'" alt="tour image">
                                                </div>
                                                <div class="flex-1 min-w-0 flex flex-col justify-center">
                                                    <h4 class="text-xs sm:text-sm font-bold text-slate-800 line-clamp-1 group-hover:text-emerald-600 transition-colors">${tour.name}</h4>
                                                    <div class="flex items-center gap-2 mt-1">
                                                        ${locationStr}
                                                        <span class="text-[11px] sm:text-xs font-bold text-rose-500">${priceFormated}</span>
                                                    </div>
                                                </div>
                                                <div class="text-slate-300 px-1 opacity-50 shrink-0">
                                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                                </div>
                                            `;
                                            
                                            item.addEventListener('click', () => {
                                                // Redirect to detail page when suggestion is clicked
                                                window.location.href = `/tour-detail/${tour.id}`;
                                            });
                                            
                                            suggestionsBox.appendChild(item);
                                        });
                                        suggestionsBox.classList.remove('hidden');
                                    } else {
                                        suggestionsBox.innerHTML = '<div class="px-5 py-6 text-sm text-slate-500 text-center flex flex-col items-center gap-2 bg-white"><i class="fa-regular fa-face-frown-open text-2xl text-slate-300"></i><p>Không tìm thấy địa điểm/tour phù hợp với từ khóa này</p></div>';
                                        suggestionsBox.classList.remove('hidden');
                                    }
                                })
                                .catch(error => console.error('Error fetching search suggestions:', error));
                        }, 250); 
                    } else {
                        suggestionsBox.classList.add('hidden');
                        suggestionsBox.innerHTML = '';
                    }
                });

                // Hide suggestions when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                        suggestionsBox.classList.add('hidden');
                    }
                });

                // Show suggestions again if focusing back to input
                searchInput.addEventListener('focus', function() {
                    if (this.value.trim().length > 0 && suggestionsBox.innerHTML.trim() !== '') {
                        suggestionsBox.classList.remove('hidden');
                    }
                });
            }

            // Consultation Form Submit
            const homeContactForm = document.getElementById('contactForm');
            const homeFeedback = document.getElementById('homeConsultationFeedback');
            const homeSubmitBtn = document.getElementById('homeConsultationBtn');

            if (homeContactForm) {
                homeContactForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    if (!homeSubmitBtn) return;
                    
                    const originalBtnHtml = homeSubmitBtn.innerHTML;
                    homeSubmitBtn.disabled = true;
                    homeSubmitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Đang gửi yêu cầu...';
                    
                    if (homeFeedback) {
                        homeFeedback.classList.add('hidden');
                        homeFeedback.className = 'hidden rounded-xl p-3 text-xs font-semibold text-center transition-all';
                    }

                    try {
                        const formData = new FormData(homeContactForm);
                        const response = await fetch(homeContactForm.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const data = await response.json();
                        
                        if (response.ok && data.success) {
                            if (homeFeedback) {
                                homeFeedback.textContent = data.message || 'Cảm ơn bạn! Yêu cầu tư vấn đã được gửi thành công. WanderVibe sẽ liên hệ lại qua SĐT trong ít phút!';
                                homeFeedback.className = 'block rounded-xl p-3 text-xs font-semibold text-center bg-emerald-50 text-emerald-700 border border-emerald-200 transition-all';
                            }
                            homeContactForm.reset();
                        } else {
                            throw new Error(data.message || 'Có lỗi xảy ra khi gửi yêu cầu.');
                        }
                    } catch (err) {
                        if (homeFeedback) {
                            homeFeedback.textContent = err.message || 'Không thể gửi yêu cầu lúc này. Vui lòng liên hệ hotline 1900 888 999!';
                            homeFeedback.className = 'block rounded-xl p-3 text-xs font-semibold text-center bg-rose-50 text-rose-700 border border-rose-200 transition-all';
                        }
                    } finally {
                        homeSubmitBtn.disabled = false;
                        homeSubmitBtn.innerHTML = originalBtnHtml;
                    }
                });
            }

        });
    </script>
@endsection