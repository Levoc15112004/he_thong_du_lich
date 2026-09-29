@extends('users.master')
@section('home')
    <div class="container mx-auto px-4 md:px-16 pb-12 min-h-screen bg-slate-50" style="padding-top: 160px;">
        <div class="max-w-3xl mx-auto">

            <!-- Breadcrumb -->
            <nav class="text-sm mb-8">
                <ul class="flex flex-wrap items-center gap-x-2 gap-y-2">
                    <li>
                        <a href="{{ route('user.home') }}" class="flex items-center text-blue-600 hover:underline whitespace-nowrap">
                            <i class="fa-solid text-sm fa-house mr-1"></i>Trang chủ
                            <i class="fa-solid fa-angle-right ml-1 text-gray-400"></i>
                        </a>
                    </li>
                    <li class="text-gray-500 font-medium whitespace-nowrap">Đánh giá chuyến đi</li>
                </ul>
            </nav>

            @if (session('error'))
                <div class="mb-6 p-4 text-sm text-red-700 bg-red-50 rounded-2xl border border-red-200 flex items-center gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-exclamation text-xl"></i>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-white text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 pattern-dots opacity-20"></div>
                    <div class="relative z-10">
                        <i class="fa-solid fa-heart-circle-check text-5xl mb-4 text-white/90"></i>
                        <h1 class="text-2xl md:text-3xl font-extrabold mb-2">Đánh Giá Chuyến Đi</h1>
                        <p class="text-blue-100 text-sm md:text-base">Chia sẻ trải nghiệm của bạn để giúp chúng tôi hoàn thiện dịch vụ tốt hơn</p>
                    </div>
                </div>

                <div class="p-6 md:p-10">
                    <!-- Tour Info Summary -->
                    <div class="flex flex-col md:flex-row gap-6 bg-slate-50 p-4 md:p-6 rounded-2xl border border-slate-100 mb-10 items-center md:items-start">
                        <div style="flex-shrink: 0; width: 100%; max-width: 280px;">
                            <img src="{{ asset($tour->image) }}" alt="{{ $tour->name }}" style="width: 100%; height: 140px; object-fit: cover;" class="rounded-xl shadow-sm border border-white">
                        </div>
                        <div class="flex-1 w-full text-center md:text-left">
                            <h2 class="text-xl font-bold text-slate-800 mb-4 leading-snug">{{ $tour->name }}</h2>
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 text-sm text-slate-600">
                                <span class="flex items-center gap-2 bg-white px-3 py-2 rounded-lg border border-slate-200 shadow-sm font-medium">
                                    <i class="fa-regular fa-calendar-days text-blue-500"></i>
                                    {{ \Carbon\Carbon::parse($tour->start_date)->format('d/m/Y') }}
                                </span>
                                <span class="flex items-center gap-2 bg-white px-3 py-2 rounded-lg border border-slate-200 shadow-sm font-medium">
                                    <i class="fa-solid fa-location-dot text-blue-500"></i>
                                    {{ $tour->start_location }} <i class="fa-solid fa-arrow-right-long text-slate-300 mx-1"></i> {{ $tour->end_location }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Review Form -->
                    <form action="{{ route('review.store') }}" method="POST" class="space-y-8">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <!-- Rating Section -->
                        <div class="space-y-4 text-center bg-white border border-slate-100 shadow-sm rounded-2xl p-8">
                            <label class="block text-lg font-bold text-slate-800">
                                Bạn cảm thấy chuyến đi này thế nào? <span class="text-red-500">*</span>
                            </label>

                            <div class="flex justify-center gap-2 md:gap-4 select-none group py-2" id="rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer transition-transform hover:scale-110">
                                        <input type="radio" name="rating" value="{{ $i }}" class="hidden peer/r{{ $i }}" required>
                                        <i class="fa-solid fa-star text-4xl md:text-5xl text-slate-200
                                            transition-colors duration-200
                                            peer-checked/r{{ $i }}:text-yellow-400"></i>
                                    </label>
                                @endfor
                            </div>
                            <p class="text-sm text-slate-500 font-medium h-5" id="rating-text">Vui lòng chọn số sao đánh giá</p>
                        </div>

                        <!-- Comment Section -->
                        <div class="space-y-3">
                            <label class="block text-sm font-bold text-slate-700 ml-1">
                                Chia sẻ thêm về trải nghiệm của bạn
                            </label>
                            <textarea name="comment" rows="5" required
                                class="w-full border border-slate-200 rounded-2xl p-4 text-slate-700 text-sm md:text-base
                                focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none resize-none bg-slate-50 focus:bg-white"
                                placeholder="Điều gì làm bạn ấn tượng nhất về chuyến đi? Cảm nhận của bạn về hướng dẫn viên, khách sạn, món ăn..."></textarea>
                        </div>

                        <!-- Actions -->
                        <div class="pt-8 flex flex-col md:flex-row gap-4 justify-end">
                            <a href="{{ route('user.tourDetail.index', $tour->id ?? 1) }}" class="px-8 py-3.5 rounded-xl text-slate-600 font-bold bg-slate-100 hover:bg-slate-200 hover:text-slate-900 transition-colors text-center">
                                Huỷ bỏ
                            </a>
                            <button type="submit" class="px-8 py-3.5 rounded-xl text-white font-bold bg-gradient-to-r from-blue-600 to-indigo-600 hover:shadow-lg hover:shadow-blue-500/30 transition-all hover:-translate-y-0.5 text-center flex items-center justify-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i>
                                Gửi Đánh Giá
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('input[name="rating"]');
            const ratingText = document.getElementById('rating-text');
            const texts = {
                1: 'Rất không hài lòng 😞',
                2: 'Không hài lòng 😕',
                3: 'Bình thường 😐',
                4: 'Hài lòng 🙂',
                5: 'Tuyệt vời! 😍'
            };

            stars.forEach((star, idx) => {
                // Hover effect
                star.nextElementSibling.addEventListener('mouseenter', () => {
                    stars.forEach((s, i) => {
                        const icon = s.nextElementSibling;
                        if (i <= idx && !s.checked) {
                            icon.classList.add('text-yellow-300');
                            icon.classList.remove('text-slate-200');
                        }
                    });
                });

                // Mouse leave effect
                star.nextElementSibling.addEventListener('mouseleave', () => {
                    stars.forEach((s) => {
                        if (!s.checked) {
                            s.nextElementSibling.classList.remove('text-yellow-300');
                            s.nextElementSibling.classList.add('text-slate-200');
                        }
                    });
                });

                // Click effect
                star.addEventListener('change', () => {
                    stars.forEach((s, i) => {
                        const icon = s.nextElementSibling;
                        if (i <= idx) {
                            icon.classList.add('text-yellow-400');
                            icon.classList.remove('text-slate-200', 'text-yellow-300');
                        } else {
                            icon.classList.remove('text-yellow-400', 'text-yellow-300');
                            icon.classList.add('text-slate-200');
                        }
                    });

                    ratingText.innerText = texts[star.value];
                    ratingText.classList.add('text-yellow-600', 'font-bold');
                    ratingText.classList.remove('text-slate-500', 'font-medium');
                });
            });

            // Clean hover effect when mouse leaves container
            document.getElementById('rating-stars').addEventListener('mouseleave', () => {
                let hasChecked = false;
                stars.forEach(s => { if(s.checked) hasChecked = true; });

                stars.forEach((s, i) => {
                    if (!s.checked) {
                        s.nextElementSibling.classList.remove('text-yellow-300');
                        s.nextElementSibling.classList.add(hasChecked ? (i < document.querySelector('input[name="rating"]:checked').value ? 'text-yellow-400' : 'text-slate-200') : 'text-slate-200');
                    }
                });
            });
        });
    </script>
@endsection
