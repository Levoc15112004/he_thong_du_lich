@extends('user.master')
@section('home')
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* Hiệu ứng focus cho input voucher */
        .voucher-input:focus-within {
            box-shadow: 0 0 0 2px rgba(14, 165, 233, 0.2);
            border-color: #0ea5e9;
        }

        /* Ẩn mũi tên của input number */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

    <section class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-dark">Giỏ hàng của bạn</h1>
                <a href="index.html" class="text-primary font-medium hover:underline text-sm"><i
                        class="fa-solid fa-arrow-left mr-1"></i> Tiếp tục tìm tour</a>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">

                <!-- Cột trái: Danh sách các tour trong giỏ hàng -->
                <div class="w-full lg:w-2/3 space-y-6">

                    <!-- Item 1 -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 transition-all"
                        id="cart-item-1">
                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Ảnh Tour -->
                            <div
                                class="w-full md:w-1/3 lg:w-1/4 h-32 md:h-auto relative rounded-xl overflow-hidden flex-shrink-0">
                                @if($cartTour)
                                <img src="{{ Str::startsWith($cartTour->image, 'http') ? $cartTour->image : asset($cartTour->image) }}"
                                    alt="{{ $cartTour->name }}" class="w-full h-full object-cover">
                                @else
                                <img src="https://images.unsplash.com/photo-1540304618210-91a030046645?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                    alt="Tour placeholder" class="w-full h-full object-cover">
                                @endif
                                <span
                                    class="absolute top-2 left-2 bg-purple-100 text-purple-700 text-[10px] font-bold px-2 py-1 rounded-md uppercase tracking-wider">{{ $cartTour && $cartTour->category ? $cartTour->category->name : 'Premium' }}</span>
                            </div>

                            <!-- Thông tin Tour -->
                            <div class="w-full md:w-2/3 lg:w-3/4 flex flex-col justify-between">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <a href="{{ $cartTour ? route('user.tourDetail.index', ['id' => $cartTour->id]) : '#' }}"
                                            class="text-lg md:text-xl font-bold text-dark hover:text-primary transition-colors line-clamp-2 leading-tight">
                                            {{ $cartTour ? $cartTour->name : 'Hành Trình Di Sản Miền Trung: Hội An - Đà Nẵng - Huế' }}
                                        </a>
                                        <div class="flex flex-wrap items-center text-sm text-gray-500 mt-2 gap-y-1">
                                            <span class="mr-4"><i class="fa-regular fa-clock mr-1 text-primary"></i> 
                                                {{ $cartTour ? $cartTour->time : '4 Ngày 3 Đêm' }}
                                            </span>
                                            <span><i class="fa-solid fa-barcode mr-1 text-gray-400"></i> WL-{{ $cartTour ? $cartTour->id : 'MT4N3D' }}</span>
                                        </div>
                                    </div>
                                    <button class="text-gray-400 hover:text-red-500 transition-colors p-1"
                                        onclick="removeItem('cart-item-1')" title="Xóa khỏi giỏ hàng">
                                        <i class="fa-solid fa-trash-can text-lg"></i>
                                    </button>
                                </div>

                                <!-- Ngày khởi hành -->
                                <div
                                    class="bg-gray-50 rounded-lg p-3 my-3 flex items-center justify-between border border-gray-100">
                                    <div class="flex items-center text-sm">
                                        <i class="fa-regular fa-calendar text-primary mr-2 text-lg"></i>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Khởi hành</p>
                                            <p class="font-bold text-dark">{{ $cartTour && $cartTour->start_date ? \Carbon\Carbon::parse($cartTour->start_date)->format('d/m/Y') : 'Đang cập nhật' }}</p>
                                        </div>
                                    </div>
                                    <button class="text-primary text-sm font-medium hover:underline">Đổi ngày</button>
                                </div>

                                <!-- Điều chỉnh số lượng và giá -->
                                <div class="flex flex-col sm:flex-row sm:items-end justify-between mt-auto gap-4">
                                    <div class="space-y-3 w-full sm:w-1/2">
                                        <!-- Khách hàng -->
                                        <div
                                            class="flex items-center justify-between bg-white border border-gray-200 rounded-lg p-1.5 shadow-sm">
                                            <div class="ml-2">
                                                <p class="text-sm font-medium text-dark">Khách hàng</p>
                                                <p class="text-[10px] text-gray-500">{{ $cartTour ? number_format($cartTour->sale_price, 0, ',', '.') : '5.900.000' }}đ/khách</p>
                                            </div>
                                            <div class="flex items-center bg-gray-50 rounded-md">
                                                <button type="button" @if($cartTour) onclick="updateQty('guest-qty', -1)" @endif
                                                    class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-primary transition-colors hover:bg-gray-100 rounded-l-md font-bold">-</button>
                                                <input type="number" id="guest-qty" value="{{ $qty ?? 1 }}" min="1"
                                                    max="{{ $cartTour ? $cartTour->quantity : 10 }}" readonly
                                                    class="w-8 text-center text-sm font-bold bg-transparent text-dark focus:outline-none">
                                                <button type="button" @if($cartTour) onclick="updateQty('guest-qty', 1)" @endif
                                                    class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-primary transition-colors hover:bg-gray-100 rounded-r-md font-bold">+</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tổng tiền item -->
                                    <div class="text-right border-t sm:border-0 border-gray-100 pt-3 sm:pt-0 mt-2 sm:mt-0">
                                        <p class="text-xs text-gray-500 mb-1">Tổng cộng:</p>
                                        <p class="text-xl md:text-2xl font-bold text-emerald-600" id="item-total">
                                            11.800.000đ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lời nhắc -->
                    <div class="bg-blue-50 border border-blue-100 text-blue-700 p-4 rounded-xl flex items-start text-sm">
                        <i class="fa-solid fa-circle-info mt-1 mr-3 text-primary text-lg"></i>
                        <p>Các tour trong giỏ hàng sẽ không được giữ chỗ cho đến khi bạn hoàn tất thanh toán. Số lượng chỗ
                            trống có thể thay đổi liên tục.</p>
                    </div>
                </div>

                <!-- Cột phải: Tổng quan & Voucher -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-2xl shadow-soft border border-gray-100 sticky top-28">

                        <div class="p-6">
                            <h2 class="text-xl font-bold text-dark mb-6">Thông tin đơn hàng</h2>

                            <!-- Box Nhập Voucher -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-dark mb-2">Mã giảm giá / Voucher</label>
                                <div
                                    class="relative flex items-center voucher-input border border-gray-200 rounded-xl bg-gray-50 transition-all overflow-hidden">
                                    <i class="fa-solid fa-ticket absolute left-3 text-gray-400"></i>
                                    <input type="text" id="voucher-code" placeholder="Nhập mã (VD: WANDERLUST)"
                                        class="w-full bg-transparent py-3 pl-10 pr-2 text-sm text-dark focus:outline-none uppercase">
                                    <button type="button" onclick="applyVoucher()"
                                        class="bg-dark hover:bg-gray-800 text-white text-sm font-semibold py-3 px-4 transition-colors">Áp
                                        dụng</button>
                                </div>
                                <p id="voucher-message" class="text-xs mt-2 hidden"></p>
                            </div>

                            <!-- Tính toán chi phí -->
                            <div class="space-y-4 mb-6 border-b border-gray-100 pb-6">
                                <div class="flex justify-between items-center text-gray-600 text-sm">
                                    <span>Tạm tính (<span id="total-guests">1</span> khách)</span>
                                    <span class="font-medium text-dark" id="subtotal">11.800.000đ</span>
                                </div>
                                <div id="discount-row" class="flex justify-between items-center text-sm hidden">
                                    <span class="text-emerald-600 flex items-center"><i
                                            class="fa-solid fa-tag text-xs mr-2"></i> Khuyến mãi</span>
                                    <span class="font-bold text-emerald-600" id="discount-amount">-0đ</span>
                                </div>
                                <div class="flex justify-between items-center text-gray-600 text-sm">
                                    <span>Thuế phí</span>
                                    <span class="font-medium text-dark">Đã bao gồm</span>
                                </div>
                            </div>

                            <!-- Tổng thanh toán -->
                            <div class="flex justify-between items-end mb-8">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Tổng cộng</p>
                                    <p class="text-xs text-gray-400">Đã bao gồm VAT</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-bold text-primary" id="final-total">11.800.000đ</p>
                                </div>
                            </div>

                            <!-- Nút thanh toán -->
                            <a href="{{ route('user.order.index') }}" type="button"
                                class="w-full bg-primary hover:bg-sky-600 text-white font-bold text-lg py-4 rounded-xl shadow-lg shadow-sky-500/30 transition-all duration-300 transform hover:-translate-y-1 flex justify-center items-center group">
                                Chuyển đến thanh toán
                                <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>

                        <!-- Badges tin cậy -->
                        <div class="bg-gray-50 p-4 rounded-b-2xl border-t border-gray-100">
                            <div class="flex items-center justify-center space-x-6 text-gray-400">
                                <div class="flex items-center text-xs font-medium" title="Thanh toán an toàn">
                                    <i class="fa-solid fa-lock text-lg mr-1.5"></i> Bảo mật
                                </div>
                                <div class="flex items-center text-xs font-medium" title="Cam kết hoàn tiền">
                                    <i class="fa-solid fa-shield-check text-lg mr-1.5"></i> Uy tín
                                </div>
                                <div class="flex space-x-2">
                                    <i class="fa-brands fa-cc-visa text-xl"></i>
                                    <i class="fa-brands fa-cc-mastercard text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>



    <script>
        // Cấu hình giá cơ bản
        const TOUR_PRICE = {{ $cartTour ? $cartTour->sale_price : 5900000 }};
        const MAX_SLOTS = {{ $cartTour ? $cartTour->quantity : 10 }};
        let isVoucherApplied = false;
        let discountPercent = 0; // % giảm giá

        // Định dạng tiền tệ VNĐ
        function formatMoney(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount) + 'đ';
        }

        // Hàm cập nhật số lượng
        function updateQty(inputId, change) {
            const inputEle = document.getElementById(inputId);
            let currentVal = parseInt(inputEle.value);
            let newVal = currentVal + change;

            // Ràng buộc số lượng
            if (newVal < 1) newVal = 1;
            if (newVal > MAX_SLOTS) newVal = MAX_SLOTS; // Giới hạn tối đa

            inputEle.value = newVal;

            calculateTotals();
        }

        // Hàm tính toán tổng tiền
        function calculateTotals() {
            const guestQty = parseInt(document.getElementById('guest-qty').value) || 1;

            const itemTotal = guestQty * TOUR_PRICE;
            const totalGuests = guestQty;

            // Cập nhật giao diện của item
            document.getElementById('item-total').innerText = formatMoney(itemTotal);
            document.getElementById('total-guests').innerText = totalGuests;
            document.getElementById('subtotal').innerText = formatMoney(itemTotal);

            // Xử lý Voucher và tính tổng thanh toán
            let discountAmount = 0;
            if (isVoucherApplied) {
                discountAmount = (itemTotal * discountPercent) / 100;
                document.getElementById('discount-amount').innerText = '-' + formatMoney(discountAmount);
            }

            const finalTotal = itemTotal - discountAmount;
            document.getElementById('final-total').innerText = formatMoney(finalTotal);
        }

        // Xóa item (Mô phỏng)
        function removeItem(itemId) {
            const item = document.getElementById(itemId);
            if (item) {
                item.style.opacity = '0';
                item.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    item.style.display = 'none';
                    // Đặt lại số lượng bằng 0 để tính toán hiển thị giỏ hàng trống (trong thực tế sẽ làm phức tạp hơn)
                    document.getElementById('guest-qty').value = 0;
                    calculateTotals();
                    alert("Đã xóa tour khỏi giỏ hàng!");
                }, 300);
            }
        }

        // Logic Voucher
        function applyVoucher() {
            const codeInput = document.getElementById('voucher-code').value.trim().toUpperCase();
            const msgEle = document.getElementById('voucher-message');
            const discountRow = document.getElementById('discount-row');

            // Mô phỏng check mã
            if (codeInput === '') {
                msgEle.innerText = "Vui lòng nhập mã giảm giá.";
                msgEle.className = "text-xs mt-2 text-red-500 block";
                return;
            }

            if (codeInput === 'WANDERLUST' || codeInput === 'SUMMER2026') {
                isVoucherApplied = true;
                discountPercent = 10; // Giảm 10%

                // Hiển thị thông báo thành công
                msgEle.innerHTML = '<i class="fa-solid fa-circle-check mr-1"></i> Áp dụng thành công! Giảm ' +
                    discountPercent + '%';
                msgEle.className = "text-xs mt-2 text-emerald-600 block font-medium";

                // Khóa ô input
                document.getElementById('voucher-code').readOnly = true;
                document.getElementById('voucher-code').classList.add('text-emerald-600', 'font-bold');

                // Hiển thị dòng giảm giá
                discountRow.classList.remove('hidden');

                // Tính toán lại
                calculateTotals();
            } else {
                isVoucherApplied = false;
                discountPercent = 0;
                discountRow.classList.add('hidden');

                msgEle.innerHTML =
                    '<i class="fa-solid fa-circle-xmark mr-1"></i> Mã giảm giá không hợp lệ hoặc đã hết hạn.';
                msgEle.className = "text-xs mt-2 text-red-500 block font-medium";
                calculateTotals();
            }
        }

        // Chạy tính toán ngay khi tải trang để format đúng
        window.onload = function() {
            calculateTotals();
        };
    </script>
@endsection
