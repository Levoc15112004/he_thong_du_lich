@extends('user.master')
@section('home')
    <section class="relative pt-36 pb-20 lg:pt-48 lg:pb-32 min-h-[80vh] flex items-center overflow-hidden bg-dark">
        <!-- Slider Backgrounds -->
        <div class="absolute inset-0 w-full h-full z-0">
            <!-- Slide 1 (Mountain) -->
            <div class="hero-slide active absolute inset-0 w-full h-full">
                <div class="absolute inset-0 bg-gradient-to-b from-dark/70 via-dark/40 to-dark/80 z-10"></div>
                <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80"
                    alt="Mountain Tour" class="w-full h-full object-cover">
            </div>
            <!-- Slide 2 (Beach) -->
            <div class="hero-slide absolute inset-0 w-full h-full">
                <div class="absolute inset-0 bg-gradient-to-b from-dark/70 via-dark/40 to-dark/80 z-10"></div>
                <img src="https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80"
                    alt="Beach Tour" class="w-full h-full object-cover">
            </div>
            <!-- Slide 3 (Culture/Bay) -->
            <div class="hero-slide absolute inset-0 w-full h-full">
                <div class="absolute inset-0 bg-gradient-to-b from-dark/70 via-dark/40 to-dark/80 z-10"></div>
                <img src="https://images.unsplash.com/photo-1557456170-0cf4f4d0d362?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80"
                    alt="Ha Long Bay" class="w-full h-full object-cover">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full text-center">
            <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold text-white mb-6 leading-tight drop-shadow-lg">
                Khám Phá Thế Giới <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-emerald-400">Theo Cách Của
                    Bạn</span>
            </h1>
            <p class="mt-4 text-xl text-gray-200 mb-10 max-w-2xl mx-auto drop-shadow-md font-light">
                Trải nghiệm những chuyến đi tuyệt vời nhất với lịch trình được thiết kế riêng, dịch vụ cao cấp và giá cả hợp
                lý.
            </p>

            <!-- Search Box -->
            <div
                class="bg-white p-3 md:p-4 rounded-2xl md:rounded-full shadow-2xl max-w-4xl mx-auto flex flex-col md:flex-row items-center gap-3 animate-fade-in-up">
                <div
                    class="flex-1 w-full md:w-auto relative flex items-center bg-gray-50 rounded-xl md:rounded-full px-5 py-3 md:py-4 hover:bg-gray-100 transition-colors">
                    <i class="fa-solid fa-location-dot text-gray-400 mr-3"></i>
                    <input type="text" placeholder="Bạn muốn đi đâu?"
                        class="bg-transparent w-full focus:outline-none text-gray-700 placeholder-gray-500 font-medium">
                </div>
                <div
                    class="flex-1 w-full md:w-auto relative flex items-center bg-gray-50 rounded-xl md:rounded-full px-5 py-3 md:py-4 hover:bg-gray-100 transition-colors border-l border-gray-200 md:border-l-0">
                    <i class="fa-regular fa-calendar text-gray-400 mr-3"></i>
                    <input type="date"
                        class="bg-transparent w-full focus:outline-none text-gray-700 font-medium cursor-pointer">
                </div>
                <div
                    class="flex-1 w-full md:w-auto relative flex items-center bg-gray-50 rounded-xl md:rounded-full px-5 py-3 md:py-4 hover:bg-gray-100 transition-colors border-l border-gray-200 md:border-l-0">
                    <i class="fa-solid fa-users text-gray-400 mr-3"></i>
                    <select
                        class="bg-transparent w-full focus:outline-none text-gray-700 font-medium cursor-pointer appearance-none">
                        <option>1 Người</option>
                        <option>2 Người</option>
                        <option>Gia đình (3-4 người)</option>
                        <option>Nhóm (5+ người)</option>
                    </select>
                    <i class="fa-solid fa-chevron-down text-gray-400 text-sm ml-2 absolute right-5 pointer-events-none"></i>
                </div>
                <button
                    class="w-full md:w-auto bg-primary hover:bg-sky-600 text-white rounded-xl md:rounded-full px-8 py-3 md:py-4 font-bold transition-all duration-300 shadow-lg shadow-sky-500/40 flex items-center justify-center">
                    <i class="fa-solid fa-magnifying-glass mr-2"></i> Tìm Kiếm
                </button>
            </div>

            <!-- Slider Controls (Dots) -->
            <div class="flex justify-center items-center space-x-3 mt-12 animate-fade-in-up">
                <button class="slider-dot w-8 h-2.5 rounded-full bg-white shadow-md transition-all duration-300"
                    aria-label="Slide 1"></button>
                <button
                    class="slider-dot w-2.5 h-2.5 rounded-full bg-white/50 hover:bg-white/80 shadow-md transition-all duration-300"
                    aria-label="Slide 2"></button>
                <button
                    class="slider-dot w-2.5 h-2.5 rounded-full bg-white/50 hover:bg-white/80 shadow-md transition-all duration-300"
                    aria-label="Slide 3"></button>
            </div>
        </div>

        <!-- Decoration Curve -->
        <div class="absolute bottom-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-[50px] lg:h-[80px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path
                    d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.08,130.83,119.33,200.7,112.5,241.57,108.57,281.39,94.95,321.39,56.44Z"
                    fill="#f9fafb"></path>
            </svg>
        </div>
    </section>

    <!-- Weather Forecast Section -->
    <section class="bg-gray-50 py-10 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between mb-8">
                <div class="mb-4 md:mb-0 flex items-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mr-4 shadow-inner">
                        <i class="fa-solid fa-cloud-sun text-orange-500 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-dark">Dự báo thời tiết</h3>
                        <p class="text-gray-500 text-sm mt-0.5">Cập nhật tình hình thời tiết các điểm đến</p>
                    </div>
                </div>
                
                <!-- Search City Weather -->
                <div class="w-full md:w-[350px] relative">
                    <input type="text" placeholder="Nhập tên thành phố..." class="w-full pl-12 pr-12 py-3 rounded-full border border-gray-300 focus:outline-none focus:border-primary focus:ring-4 focus:ring-sky-100 transition-all bg-white shadow-sm font-medium text-gray-700">
                    <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button class="absolute right-2 top-2 bottom-2 bg-primary text-white w-9 h-9 rounded-full hover:bg-sky-600 transition-colors flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Weather Card Container -->
            <div class="bg-white rounded-3xl p-6 shadow-soft border border-gray-100 flex flex-col lg:flex-row gap-8 relative overflow-hidden">
                
                <!-- Current Weather / Featured City -->
                <div class="lg:w-1/3 relative overflow-hidden rounded-2xl bg-gradient-to-br from-sky-400 via-sky-500 to-blue-600 text-white p-6 flex flex-col justify-between min-h-[250px] shadow-lg shadow-sky-500/20">
                    <!-- decorative circles -->
                    <div class="absolute -top-16 -right-16 w-32 h-32 bg-white/20 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-white/20 rounded-full blur-xl"></div>
                    
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <h4 class="text-2xl font-bold drop-shadow-md">Đà Lạt</h4>
                            <p class="text-sky-100 text-sm mt-1 flex items-center"><i class="fa-solid fa-location-dot mr-1"></i> Việt Nam</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sky-100 text-sm font-medium">Hôm nay</p>
                            <p class="text-xs text-sky-200 mt-1">17 Tháng 8</p>
                        </div>
                    </div>
                    
                    <div class="relative z-10 flex items-center justify-between mt-auto">
                        <div class="flex items-center">
                            <i class="fa-solid fa-cloud-sun text-5xl mr-4 drop-shadow-lg text-yellow-300"></i>
                            <div class="text-5xl font-light tracking-tighter">18<span class="text-2xl font-normal align-top ml-1">°C</span></div>
                        </div>
                        <div class="text-right text-sm text-sky-100 flex flex-col gap-1.5 font-medium">
                            <span class="flex items-center justify-end"><i class="fa-solid fa-wind mr-2 w-4"></i> 12 km/h</span>
                            <span class="flex items-center justify-end"><i class="fa-solid fa-droplet mr-2 w-4"></i> 75%</span>
                        </div>
                    </div>
                </div>

                <!-- 5 Days Forecast -->
                <div class="lg:w-2/3 flex flex-col justify-center">
                    <div class="flex items-center justify-between mb-5">
                        <h4 class="text-lg font-bold text-dark">Dự báo 5 ngày tới</h4>
                        <span class="text-primary text-sm font-medium cursor-pointer hover:underline">Xem chi tiết</span>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                        
                        <!-- Day 1 -->
                        <div class="bg-gray-50 hover:bg-sky-50 transition-colors border border-gray-100 rounded-2xl p-4 flex flex-col items-center justify-center text-center cursor-pointer group">
                            <p class="text-gray-500 text-sm font-medium mb-3 group-hover:text-primary">T2, 18/08</p>
                            <i class="fa-solid fa-cloud-sun text-yellow-500 text-3xl mb-3 group-hover:scale-110 transition-transform drop-shadow-sm"></i>
                            <p class="text-dark font-bold text-lg leading-none mb-1">20°</p>
                            <p class="text-gray-400 text-xs">15°</p>
                        </div>
                        
                        <!-- Day 2 -->
                        <div class="bg-gray-50 hover:bg-sky-50 transition-colors border border-gray-100 rounded-2xl p-4 flex flex-col items-center justify-center text-center cursor-pointer group">
                            <p class="text-gray-500 text-sm font-medium mb-3 group-hover:text-primary">T3, 19/08</p>
                            <i class="fa-solid fa-cloud-rain text-blue-400 text-3xl mb-3 group-hover:scale-110 transition-transform drop-shadow-sm"></i>
                            <p class="text-dark font-bold text-lg leading-none mb-1">18°</p>
                            <p class="text-gray-400 text-xs">16°</p>
                        </div>
                        
                        <!-- Day 3 -->
                        <div class="bg-gray-50 hover:bg-sky-50 transition-colors border border-gray-100 rounded-2xl p-4 flex flex-col items-center justify-center text-center cursor-pointer group">
                            <p class="text-gray-500 text-sm font-medium mb-3 group-hover:text-primary">T4, 20/08</p>
                            <i class="fa-solid fa-sun text-yellow-500 text-3xl mb-3 group-hover:scale-110 transition-transform drop-shadow-sm"></i>
                            <p class="text-dark font-bold text-lg leading-none mb-1">24°</p>
                            <p class="text-gray-400 text-xs">18°</p>
                        </div>
                        
                        <!-- Day 4 -->
                        <div class="bg-gray-50 hover:bg-sky-50 transition-colors border border-gray-100 rounded-2xl p-4 flex flex-col items-center justify-center text-center cursor-pointer group">
                            <p class="text-gray-500 text-sm font-medium mb-3 group-hover:text-primary">T5, 21/08</p>
                            <i class="fa-solid fa-cloud text-gray-400 text-3xl mb-3 group-hover:scale-110 transition-transform drop-shadow-sm"></i>
                            <p class="text-dark font-bold text-lg leading-none mb-1">21°</p>
                            <p class="text-gray-400 text-xs">17°</p>
                        </div>
                        
                        <!-- Day 5 -->
                        <div class="bg-gray-50 hover:bg-sky-50 transition-colors border border-gray-100 rounded-2xl p-4 flex flex-col items-center justify-center text-center cursor-pointer group md:col-span-1 col-span-2">
                            <p class="text-gray-500 text-sm font-medium mb-3 group-hover:text-primary">T6, 22/08</p>
                            <i class="fa-solid fa-cloud-bolt text-gray-600 text-3xl mb-3 group-hover:scale-110 transition-transform drop-shadow-sm"></i>
                            <p class="text-dark font-bold text-lg leading-none mb-1">19°</p>
                            <p class="text-gray-400 text-xs">15°</p>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Muted suggestion basically weather boxes -->
            <div class="flex items-center text-sm mt-6">
                <span class="text-gray-400 mr-4 font-medium hidden md:block">Các điểm đến nổi bật:</span>
                <div class="flex space-x-3 overflow-x-auto w-full pb-2 md:pb-0 no-scrollbar">
                    <div class="flex items-center space-x-2 min-w-max bg-white px-3 py-1.5 rounded-full border border-gray-200 cursor-pointer hover:border-primary hover:text-primary transition-colors text-gray-600">
                        <span>Phú Quốc</span>
                        <i class="fa-solid fa-sun text-yellow-500 text-xs"></i>
                        <span class="font-bold">32°</span>
                    </div>
                    <div class="flex items-center space-x-2 min-w-max bg-white px-3 py-1.5 rounded-full border border-gray-200 cursor-pointer hover:border-primary hover:text-primary transition-colors text-gray-600">
                        <span>Sapa</span>
                        <i class="fa-solid fa-cloud-rain text-blue-400 text-xs"></i>
                        <span class="font-bold">15°</span>
                    </div>
                    <div class="flex items-center space-x-2 min-w-max bg-white px-3 py-1.5 rounded-full border border-gray-200 cursor-pointer hover:border-primary hover:text-primary transition-colors text-gray-600">
                        <span>Đà Nẵng</span>
                        <i class="fa-solid fa-sun text-yellow-500 text-xs"></i>
                        <span class="font-bold">28°</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hot Tours Section -->
    <section id="hot-tours" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-primary font-bold tracking-wider uppercase text-sm mb-2 block">Lựa Chọn Hàng Đầu</span>
                <h2 class="text-3xl md:text-4xl font-bold text-dark mb-4">Tour Hot Nhất Tháng Này</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Những hành trình được yêu thích nhất với mức giá ưu đãi không thể
                    bỏ lỡ. Số lượng có hạn!</p>
            </div>

            <!-- Filter Tabs -->
            <div class="flex flex-wrap justify-center gap-4 mb-12" id="tour-filters">
                <button
                    class="filter-btn active bg-dark text-white px-6 py-2.5 rounded-full font-medium transition-all shadow-md"
                    data-filter="all">Tất cả</button>
                <button
                    class="filter-btn bg-white text-gray-600 hover:bg-gray-100 px-6 py-2.5 rounded-full font-medium transition-all border border-gray-200"
                    data-filter="sea">Biển đảo</button>
                <button
                    class="filter-btn bg-white text-gray-600 hover:bg-gray-100 px-6 py-2.5 rounded-full font-medium transition-all border border-gray-200"
                    data-filter="mountain">Vùng núi</button>
                <button
                    class="filter-btn bg-white text-gray-600 hover:bg-gray-100 px-6 py-2.5 rounded-full font-medium transition-all border border-gray-200"
                    data-filter="culture">Văn hóa</button>
            </div>

            <!-- Hot Tours Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                @foreach($hotTours as $tour)
                <div class="tour-item card-hover bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-soft group"
                    data-category="{{ $tour->category ? strtolower($tour->category->name) : 'all' }}">
                    <div class="relative overflow-hidden h-64">
                        <div
                            class="absolute top-4 left-4 z-10 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-red-500 flex items-center shadow-sm">
                            <i class="fa-solid fa-fire mr-1"></i> HOT
                        </div>
                        <img src="{{ Str::startsWith($tour->image, 'http') ? $tour->image : asset($tour->image) }}"
                            alt="{{ $tour->name }}"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-sm text-primary font-semibold tracking-wide"><i
                                    class="fa-solid fa-location-dot mr-1"></i> {{ $tour->end_location }}</span>
                            <span class="text-sm text-gray-500 flex items-center"><i class="fa-regular fa-clock mr-1"></i>
                                {{ $tour->time }}</span>
                        </div>
                        <h3
                            class="text-xl font-bold text-dark mb-3 line-clamp-2 hover:text-primary transition-colors cursor-pointer">
                            <a href="{{ route('user.tourDetail.index', ['id' => $tour->id]) }}">{{ $tour->name }}</a>
                        </h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ \Illuminate\Support\Str::limit(strip_tags($tour->description), 100) }}</p>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div>
                                <p class="text-lg font-bold text-dark text-emerald-600">{{ number_format($tour->sale_price, 0, ',', '.') }}<span
                                        class="text-sm font-normal">đ</span></p>
                            </div>
                            <a href="{{ route('user.tourDetail.index', ['id' => $tour->id]) }}"
                                class="bg-primary/10 text-primary hover:bg-primary hover:text-white p-3 rounded-full transition-colors">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <button
                    class="border-2 border-primary text-primary hover:bg-primary hover:text-white px-8 py-3 rounded-full font-semibold transition-all duration-300">
                    Xem Tất Cả Tour Hot
                </button>
            </div>
        </div>
    </section>

    <!-- Destinations Section -->
    <section id="tours" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                <div>
                    <span class="text-primary font-bold tracking-wider uppercase text-sm mb-2 block">Điểm Đến</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-dark">Khám Phá Các Tour Đa Dạng</h2>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="#" class="text-primary font-medium hover:underline flex items-center group">
                        Xem bản đồ <i
                            class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <!-- Destinations Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($destinations as $destination)
                <div class="group relative rounded-2xl overflow-hidden cursor-pointer aspect-square md:aspect-[3/4]">
                    <img src="{{ Str::startsWith($destination->image, 'http') ? $destination->image : asset($destination->image) }}"
                        alt="{{ $destination->end_location }}"
                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    
                    @if(str_contains(strtolower($destination->end_location), 'thái lan') || str_contains(strtolower($destination->end_location), 'nhật bản') || str_contains(strtolower($destination->end_location), 'hàn quốc') || str_contains(strtolower($destination->end_location), 'quốc tế'))
                    <div class="absolute top-4 right-4 z-10 bg-primary text-white px-2 py-1 rounded text-xs font-bold">
                        Quốc Tế
                    </div>
                    @endif

                    <div class="absolute bottom-0 left-0 p-4 md:p-6 w-full">
                        <h3 class="text-white text-xl md:text-2xl font-bold mb-1">{{ $destination->end_location }}</h3>
                        <p class="text-gray-300 text-sm">{{ $destination->total_tours }} Tours</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center border-b border-gray-100 pb-16">
                <div class="p-4">
                    <div
                        class="w-16 h-16 mx-auto bg-sky-50 rounded-2xl flex items-center justify-center mb-6 text-primary shadow-inner">
                        <i class="fa-solid fa-map-location-dot text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-dark mb-2">Hơn 500+ Điểm Đến</h3>
                    <p class="text-gray-500 text-sm">Đa dạng lựa chọn từ trong nước đến quốc tế, thỏa sức khám phá.</p>
                </div>
                <div class="p-4">
                    <div
                        class="w-16 h-16 mx-auto bg-sky-50 rounded-2xl flex items-center justify-center mb-6 text-primary shadow-inner">
                        <i class="fa-solid fa-headset text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-dark mb-2">Hỗ Trợ 24/7</h3>
                    <p class="text-gray-500 text-sm">Đội ngũ chuyên nghiệp luôn sẵn sàng đồng hành cùng bạn trên mọi nẻo
                        đường.</p>
                </div>
                <div class="p-4">
                    <div
                        class="w-16 h-16 mx-auto bg-sky-50 rounded-2xl flex items-center justify-center mb-6 text-primary shadow-inner">
                        <i class="fa-solid fa-tags text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-dark mb-2">Giá Tốt Nhất</h3>
                    <p class="text-gray-500 text-sm">Cam kết mức giá cạnh tranh cùng nhiều chương trình ưu đãi độc quyền.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews & Blog Section -->
    <section id="reviews" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-primary font-bold tracking-wider uppercase text-sm mb-2 block">Góc Chia Sẻ</span>
                <h2 class="text-3xl md:text-4xl font-bold text-dark mb-4">Cẩm Nang & Đánh Giá</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Kinh nghiệm du lịch thực tế và những câu chuyện truyền cảm hứng
                    từ cộng đồng Wanderlust.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($recentBlogs as $blog)
                <article
                    class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-soft transition-shadow border border-gray-100">
                    <div class="overflow-hidden h-56">
                        <img src="{{ asset('storage/imgBlog/' . $blog->image) }}"
                            alt="{{ $blog->title }}"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-xs text-gray-500 mb-3 space-x-4">
                            <span class="bg-gray-100 px-2 py-1 rounded">Kinh nghiệm</span>
                            <span><i class="fa-regular fa-calendar mr-1"></i> {{ $blog->created_at->format('d/m/Y') }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-dark mb-2 hover:text-primary cursor-pointer transition-colors">{{ $blog->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ \Illuminate\Support\Str::limit(strip_tags($blog->content), 120) }}</p>
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-700">Wanderlust Admin</span>
                            </div>
                            <a href="#" class="text-primary text-sm font-semibold hover:underline">Đọc thêm</a>
                        </div>
                    </div>
                </article>
                @endforeach

                <!-- Review Testimonial (Different layout for variety) -->
                <article
                    class="bg-primary rounded-2xl overflow-hidden shadow-soft text-white p-8 flex flex-col justify-between relative">
                    <i class="fa-solid fa-quote-right absolute top-6 right-6 text-6xl text-white/10"></i>
                    <div>
                        <div class="flex text-yellow-300 text-sm mb-4">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4">"Trải nghiệm vượt xa mong đợi!"</h3>
                        <p class="text-white/90 text-sm italic mb-6">"Tour đi Thái Lan của Wanderlust được tổ chức rất
                            chuyên nghiệp. Hướng dẫn viên nhiệt tình, lịch trình hợp lý không bị quá sức. Chắc chắn sẽ tiếp
                            tục ủng hộ."</p>
                    </div>
                    <div class="flex items-center border-t border-white/20 pt-4 mt-auto">
                        <img src="https://i.pravatar.cc/150?img=12" alt="Avatar"
                            class="w-10 h-10 rounded-full border-2 border-white mr-3">
                        <div>
                            <p class="font-bold text-sm">Trần Văn Nam</p>
                            <p class="text-xs text-white/70">Khách hàng Tour Thái Lan 5N4Đ</p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>


    <script>
        // Header scroll effect
        const header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                header.classList.add('shadow-md');
                header.classList.replace('glass-effect', 'bg-white');
            } else {
                header.classList.remove('shadow-md');
                header.classList.replace('bg-white', 'glass-effect');
            }
        });

        // Mobile menu toggle
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Hot Tours Filtering logic
        const filterBtns = document.querySelectorAll('.filter-btn');
        const tourItems = document.querySelectorAll('.tour-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active class from all buttons
                filterBtns.forEach(b => {
                    b.classList.remove('bg-dark', 'text-white', 'shadow-md');
                    b.classList.add('bg-white', 'text-gray-600');
                });

                // Add active class to clicked button
                btn.classList.remove('bg-white', 'text-gray-600');
                btn.classList.add('bg-dark', 'text-white', 'shadow-md');

                const filterValue = btn.getAttribute('data-filter');

                tourItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-category') ===
                        filterValue) {
                        item.style.display = 'block';
                        // Add slight animation
                        item.animate([{
                                opacity: 0,
                                transform: 'scale(0.95)'
                            },
                            {
                                opacity: 1,
                                transform: 'scale(1)'
                            }
                        ], {
                            duration: 300,
                            easing: 'ease-out'
                        });
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // --- Hero Slider Logic ---
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.slider-dot');
        let currentSlide = 0;
        let slideInterval;

        function updateSlider(index) {
            // Remove active state from current slide
            slides[currentSlide].classList.remove('active');
            dots[currentSlide].classList.remove('w-8', 'bg-white');
            dots[currentSlide].classList.add('w-2.5', 'bg-white/50');

            // Update to new index
            currentSlide = index;

            // Add active state to new slide
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.remove('w-2.5', 'bg-white/50');
            dots[currentSlide].classList.add('w-8', 'bg-white');
        }

        function nextSlide() {
            let nextIndex = (currentSlide + 1) % slides.length;
            updateSlider(nextIndex);
        }

        // Initialize Auto Slide (change every 5.5 seconds)
        slideInterval = setInterval(nextSlide, 5500);

        // Dot click handlers for manual navigation
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                // Reset timer when user manually clicks
                clearInterval(slideInterval);
                updateSlider(index);
                slideInterval = setInterval(nextSlide, 5500);
            });
        });
    </script>
@endsection
