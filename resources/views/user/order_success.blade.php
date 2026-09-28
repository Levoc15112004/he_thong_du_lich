@extends('user.master')
@section('home')
    <style>
        /* Hiệu ứng vẽ dấu tích thành công (Animated Checkmark) */
        .success-checkmark {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            border-radius: 50%;
            display: block;
            stroke-width: 2.5;
            stroke: #10b981;
            stroke-miterlimit: 10;
            box-shadow: inset 0px 0px 0px #10b981;
            animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
        }

        .success-checkmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2.5;
            stroke-miterlimit: 10;
            stroke: #10b981;
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        .success-checkmark__check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }

        @keyframes stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes scale {

            0%,
            100% {
                transform: none;
            }

            50% {
                transform: scale3d(1.1, 1.1, 1);
            }
        }

        @keyframes fill {
            100% {
                box-shadow: inset 0px 0px 0px 30px rgba(16, 185, 129, 0.1);
            }
        }

        /* Đường gạch đứt cho biên lai */
        .dashed-line {
            border-top: 2px dashed #e5e7eb;
            position: relative;
        }

        .dashed-line::before,
        .dashed-line::after {
            content: '';
            position: absolute;
            top: -10px;
            width: 20px;
            height: 20px;
            background-color: #f9fafb;
            /* Màu nền body */
            border-radius: 50%;
        }

        .dashed-line::before {
            left: -34px;
            box-shadow: inset -1px 0px 0px 0px #e5e7eb;
        }

        .dashed-line::after {
            right: -34px;
            box-shadow: inset 1px 0px 0px 0px #e5e7eb;
        }
    </style>
    <main class="flex-grow py-12 md:py-16">
        <div class="max-w-3xl mx-auto px-4 mt-8 sm:px-6 lg:px-8">

            <!-- Phần thông báo thành công -->
            <div class="text-center mb-10">
                <div class="mb-6">
                    <!-- SVG Animated Checkmark -->
                    <svg class="success-checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                        <circle class="success-checkmark__circle" cx="26" cy="26" r="25" fill="none" />
                        <path class="success-checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                    </svg>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-dark mb-3">Đặt Tour Thành Công!</h1>
                <p class="text-gray-500 text-lg max-w-lg mx-auto">Cảm ơn bạn đã lựa chọn Wanderlust. Thông tin xác nhận và
                    vé điện tử đã được gửi tới email của bạn.</p>
            </div>

            <!-- Khu vực Hóa đơn (Bill) -->
            <div class="bg-white rounded-3xl shadow-bill border border-gray-100 overflow-hidden mb-8 relative">
                <!-- Header Bill -->
                <div
                    class="bg-dark text-white p-6 md:p-8 flex flex-col md:flex-row justify-between items-center md:items-start">
                    <div class="text-center md:text-left mb-4 md:mb-0">
                        <p class="text-gray-400 text-sm mb-1 uppercase tracking-wider font-semibold">Mã Đơn Hàng</p>
                        <h2 class="text-2xl font-bold tracking-wider text-sky-400">WL-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h2>
                    </div>
                    <div class="text-center md:text-right">
                        <p class="text-gray-400 text-sm mb-1">Ngày đặt</p>
                        <p class="font-medium">{{ $order->created_at->format('d/m/Y - h:i A') }}</p>
                    </div>
                </div>

                <!-- Thông tin khách hàng & Thanh toán -->
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-6 bg-sky-50/50">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-2">Thông tin khách hàng</p>
                        <p class="font-bold text-dark text-lg">{{ $order->name }}</p>
                        <p class="text-sm text-gray-600 mt-1"><i class="fa-solid fa-phone w-4 text-gray-400"></i> {{ $order->phone }}</p>
                        <p class="text-sm text-gray-600 mt-1"><i class="fa-solid fa-envelope w-4 text-gray-400"></i> {{ $order->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-2">Phương thức thanh toán</p>
                        @php
                            $payment = $order->payments ? $order->payments->first() : null;
                            $methodName = 'Thanh toán trực tiếp / Chuyển khoản';
                            if ($payment) {
                                if ($payment->payment_method === 'momo') $methodName = 'Ví MoMo';
                                elseif ($payment->payment_method === 'vnpay') $methodName = 'Cổng VNPAY / Thẻ ATM';
                            }
                        @endphp
                        <div class="flex items-center">
                            <i class="fa-solid fa-credit-card text-xl text-primary mr-2"></i>
                            <p class="font-bold text-dark">{{ $methodName }}</p>
                        </div>
                        @if($payment && $payment->status == 1)
                            <p class="text-sm text-emerald-600 font-medium mt-1"><i class="fa-solid fa-circle-check mr-1"></i> Đã thanh toán thành công</p>
                        @else
                            <p class="text-sm text-amber-600 font-medium mt-1"><i class="fa-solid fa-clock mr-1"></i> Đã ghi nhận - Chờ xác nhận</p>
                        @endif
                    </div>
                </div>

                <!-- Thông tin Tour -->
                <div class="p-6 md:p-8">
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-4">Chi tiết dịch vụ</p>

                    <div class="flex flex-col sm:flex-row gap-4 mb-6">
                        @if($order->tour)
                        <img src="{{ Str::startsWith($order->tour->image, 'http') ? $order->tour->image : asset($order->tour->image) }}"
                            alt="{{ $order->tour->name }}" class="w-full sm:w-24 h-24 object-cover rounded-xl shadow-sm">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-dark leading-tight mb-2">{{ $order->tour->name }}</h3>
                            <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                                <p><i class="fa-regular fa-calendar text-primary w-4"></i> {{ $order->tour->start_date ? \Carbon\Carbon::parse($order->tour->start_date)->format('d/m/Y') : 'Khởi hành hàng tuần' }}</p>
                                <p><i class="fa-regular fa-clock text-primary w-4"></i> {{ $order->time ?? ($order->tour->time ?? 'Theo lịch trình') }}</p>
                                <p><i class="fa-solid fa-user-group text-primary w-4"></i> {{ $order->quantity }} Khách</p>
                                <p><i class="fa-solid fa-barcode text-primary w-4"></i> WL-{{ $order->tour->id }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Đường cắt ngang mô phỏng biên lai -->
                <div class="dashed-line"></div>

                <!-- Tổng tiền -->
                <div class="p-6 md:p-8 bg-gray-50">
                    <div class="space-y-3 mb-4 text-sm">
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Tạm tính ({{ $order->quantity }} khách)</span>
                            <span class="font-medium text-dark">{{ number_format(($order->total_price + ($order->discount_amount ?? 0)), 0, ',', '.') }}đ</span>
                        </div>
                        @if(($order->discount_amount ?? 0) > 0)
                        <div class="flex justify-between items-center">
                            <span class="text-emerald-600">Voucher {{ $order->voucher ? $order->voucher->code : 'Áp dụng' }}</span>
                            <span class="font-medium text-emerald-600">-{{ number_format($order->discount_amount, 0, ',', '.') }}đ</span>
                        </div>
                        @endif
                    </div>

                    <div class="border-t border-gray-200 pt-4 flex justify-between items-end">
                        <div>
                            <p class="text-base font-bold text-dark">Tổng thanh toán</p>
                            <p class="text-xs text-gray-500">Đã bao gồm VAT</p>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-primary">{{ number_format($order->total_price, 0, ',', '.') }}đ</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Khu vực các nút thao tác -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <!-- Nút Về Trang Chủ -->
                <a href="{{ route('user.home') }}"
                    class="bg-primary hover:bg-sky-600 text-white font-bold py-3.5 px-6 rounded-xl transition-all duration-300 flex items-center justify-center shadow-lg shadow-sky-500/30">
                    <i class="fa-solid fa-house mr-2"></i> Về Trang Chủ
                </a>

                @if($order->tour_id)
                <!-- Nút Xem chi tiết tour -->
                <a href="{{ route('user.tourDetail.index', ['id' => $order->tour_id]) }}"
                    class="bg-white border-2 border-primary text-primary hover:bg-sky-50 font-bold py-3.5 px-6 rounded-xl transition-all duration-300 flex items-center justify-center">
                    <i class="fa-solid fa-map-location-dot mr-2"></i> Xem Lịch Trình Tour
                </a>
                @endif
            </div>

            <!-- Ghi chú hỗ trợ -->
            <p class="text-center text-sm text-gray-500 mt-10">
                Cần hỗ trợ về đơn hàng? Vui lòng liên hệ Hotline <a href="tel:19001234"
                    class="font-bold text-primary hover:underline">1900 1234</a>.
            </p>

        </div>
    </main>

    <!-- Footer thu gọn -->
    <footer class="bg-white border-t border-gray-200 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-sm text-gray-500 mb-4 md:mb-0">&copy; 2026 Wanderlust Travel. Mọi chuyến đi đều được bảo hiểm an
                toàn.</p>
            <div class="flex space-x-6 text-sm text-gray-500">
                <a href="index.html" class="hover:text-primary transition-colors">Về Trang Chủ</a>
                <a href="#" class="hover:text-primary transition-colors">Theo dõi đơn hàng</a>
            </div>
        </div>
    </footer>

    <!-- Modal Đánh Giá (Ẩn theo mặc định) -->
    <div id="review-modal"
        class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center px-4 transition-opacity duration-300 opacity-0">
        <div class="bg-white rounded-3xl w-full max-w-lg overflow-hidden shadow-2xl transform scale-95 transition-transform duration-300"
            id="review-content">
            <!-- Header Modal -->
            <div class="flex justify-between items-center p-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-dark">Đánh giá trải nghiệm đặt tour</h3>
                <button onclick="closeReviewModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Body Modal -->
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-6">Bạn cảm thấy quá trình đặt tour tại Wanderlust như thế nào? Đánh giá
                    của bạn giúp chúng tôi cải thiện dịch vụ tốt hơn.</p>

                <!-- Chọn sao -->
                <div class="flex justify-center space-x-2 mb-8" id="star-rating">
                    <i class="fa-regular fa-star text-3xl text-gray-300 cursor-pointer hover:text-yellow-400 transition-colors"
                        data-value="1"></i>
                    <i class="fa-regular fa-star text-3xl text-gray-300 cursor-pointer hover:text-yellow-400 transition-colors"
                        data-value="2"></i>
                    <i class="fa-regular fa-star text-3xl text-gray-300 cursor-pointer hover:text-yellow-400 transition-colors"
                        data-value="3"></i>
                    <i class="fa-regular fa-star text-3xl text-gray-300 cursor-pointer hover:text-yellow-400 transition-colors"
                        data-value="4"></i>
                    <i class="fa-regular fa-star text-3xl text-gray-300 cursor-pointer hover:text-yellow-400 transition-colors"
                        data-value="5"></i>
                </div>
                <p id="rating-text" class="text-center font-bold text-primary mb-6 hidden">Tuyệt vời!</p>

                <!-- Input phản hồi -->
                <textarea rows="4" placeholder="Chia sẻ thêm cảm nhận của bạn (Tùy chọn)..."
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors resize-none"></textarea>

                <button onclick="submitReview()"
                    class="w-full mt-6 bg-dark hover:bg-gray-800 text-white font-bold py-3 rounded-xl transition-all">Gửi
                    Đánh Giá</button>
            </div>
        </div>
    </div>

    <!-- Logic JS cho Modal Đánh Giá -->
    <script>
        const modal = document.getElementById('review-modal');
        const modalContent = document.getElementById('review-content');

        function openReviewModal() {
            modal.classList.remove('hidden');
            // Cần một chút delay để transition CSS chạy
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function closeReviewModal() {
            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Logic Rating Stars
        const stars = document.querySelectorAll('#star-rating i');
        const ratingText = document.getElementById('rating-text');
        const texts = ['Rất tệ', 'Tệ', 'Bình thường', 'Tốt', 'Tuyệt vời!'];

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                // Reset all
                stars.forEach(s => {
                    s.classList.remove('fa-solid', 'text-yellow-400');
                    s.classList.add('fa-regular', 'text-gray-300');
                });
                // Fill up to clicked
                for (let i = 0; i <= index; i++) {
                    stars[i].classList.remove('fa-regular', 'text-gray-300');
                    stars[i].classList.add('fa-solid', 'text-yellow-400');
                }

                // Show text
                ratingText.innerText = texts[index];
                ratingText.classList.remove('hidden');
            });
        });

        function submitReview() {
            alert("Cảm ơn bạn đã gửi đánh giá! Chúc bạn có một chuyến đi vui vẻ.");
            closeReviewModal();
        }
    </script>
@endsection
