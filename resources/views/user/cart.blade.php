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
                <a href="{{ route('user.home') }}" class="text-primary font-medium hover:underline text-sm"><i
                        class="fa-solid fa-arrow-left mr-1"></i> Tiếp tục tìm tour</a>
            </div>

            @if(!($cartTour ?? null))
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center max-w-xl mx-auto">
                    <div class="w-20 h-20 bg-sky-50 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-cart-shopping text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-2">Giỏ hàng của bạn đang trống</h3>
                    <p class="text-gray-500 mb-6 text-sm">Chưa có chuyến đi nào được chọn. Hãy khám phá những điểm đến tuyệt vời ngay!</p>
                    <a href="{{ route('user.home') }}" class="inline-flex items-center px-6 py-3.5 bg-primary hover:bg-sky-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-sky-500/30">
                        <i class="fa-solid fa-compass mr-2"></i> Khám phá Tour ngay
                    </a>
                </div>
            @else
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
                                <img src="{{ Str::startsWith($cartTour->image, 'http') ? $cartTour->image : asset($cartTour->image) }}"
                                    alt="{{ $cartTour->name }}" class="w-full h-full object-cover">
                                <span
                                    class="absolute top-2 left-2 bg-purple-100 text-purple-700 text-[10px] font-bold px-2 py-1 rounded-md uppercase tracking-wider">{{ $cartTour->category ? $cartTour->category->name : 'Premium' }}</span>
                            </div>

                            <!-- Thông tin Tour -->
                            <div class="w-full md:w-2/3 lg:w-3/4 flex flex-col justify-between">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <a href="{{ route('user.tourDetail.index', ['id' => $cartTour->id]) }}"
                                            class="text-lg md:text-xl font-bold text-dark hover:text-primary transition-colors line-clamp-2 leading-tight">
                                            {{ $cartTour->name }}
                                        </a>
                                        <div class="flex flex-wrap items-center text-sm text-gray-500 mt-2 gap-y-1">
                                            <span class="mr-4"><i class="fa-regular fa-clock mr-1 text-primary"></i> 
                                                {{ $cartTour->time ?? 'Theo lịch trình' }}
                                            </span>
                                            <span><i class="fa-solid fa-barcode mr-1 text-gray-400"></i> WL-{{ $cartTour->id }}</span>
                                        </div>
                                    </div>
                                    <form action="{{ route('user.cart.remove', ['id' => $cartTour->id]) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa tour này khỏi giỏ hàng?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-1" title="Xóa khỏi giỏ hàng">
                                            <i class="fa-solid fa-trash-can text-lg"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- Ngày khởi hành -->
                                <div
                                    class="bg-gray-50 rounded-lg p-3 my-3 flex items-center justify-between border border-gray-100">
                                    <div class="flex items-center text-sm">
                                        <i class="fa-regular fa-calendar text-primary mr-2 text-lg"></i>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Khởi hành</p>
                                            <p class="font-bold text-dark">{{ $cartTour->start_date ? \Carbon\Carbon::parse($cartTour->start_date)->format('d/m/Y') : 'Khởi hành hàng tuần' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Điều chỉnh số lượng và giá -->
                                <div class="flex flex-col sm:flex-row sm:items-end justify-between mt-auto gap-4">
                                    <div class="space-y-3 w-full sm:w-1/2">
                                        <!-- Khách hàng -->
                                        <div
                                            class="flex items-center justify-between bg-white border border-gray-200 rounded-lg p-1.5 shadow-sm">
                                            <div class="ml-2">
                                                <p class="text-sm font-medium text-dark">Khách hàng</p>
                                                <p class="text-[10px] text-gray-500">{{ number_format($cartTour->sale_price, 0, ',', '.') }}đ/khách</p>
                                            </div>
                                            <div class="flex items-center bg-gray-50 rounded-md">
                                                <button type="button" onclick="updateQty('guest-qty', -1)"
                                                    class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-primary transition-colors hover:bg-gray-100 rounded-l-md font-bold">-</button>
                                                <input type="number" id="guest-qty" value="{{ $qty ?? 1 }}" min="1"
                                                    max="{{ $cartTour->quantity > 0 ? $cartTour->quantity : 10 }}" readonly
                                                    class="w-8 text-center text-sm font-bold bg-transparent text-dark focus:outline-none">
                                                <button type="button" onclick="updateQty('guest-qty', 1)"
                                                    class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-primary transition-colors hover:bg-gray-100 rounded-r-md font-bold">+</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tổng tiền item -->
                                    <div class="text-right border-t sm:border-0 border-gray-100 pt-3 sm:pt-0 mt-2 sm:mt-0">
                                        <p class="text-xs text-gray-500 mb-1">Tổng cộng:</p>
                                        <p class="text-xl md:text-2xl font-bold text-emerald-600" id="item-total">
                                            {{ number_format(($qty ?? 1) * $cartTour->sale_price, 0, ',', '.') }}đ</p>
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
                                    <span>Tạm tính (<span id="total-guests">{{ $qty ?? 1 }}</span> khách)</span>
                                    <span class="font-medium text-dark" id="subtotal">{{ number_format(($qty ?? 1) * $cartTour->sale_price, 0, ',', '.') }}đ</span>
                                </div>
                                <div id="discount-row" class="flex justify-between items-center text-sm {{ ($discount ?? 0) > 0 ? '' : 'hidden' }}">
                                    <span class="text-emerald-600 flex items-center"><i
                                            class="fa-solid fa-tag text-xs mr-2"></i> Khuyến mãi</span>
                                    <span class="font-bold text-emerald-600" id="discount-amount">-{{ number_format($discount ?? 0, 0, ',', '.') }}đ</span>
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
                                    <p class="text-3xl font-bold text-primary" id="final-total">{{ number_format($finalTotal ?? (($qty ?? 1) * $cartTour->sale_price), 0, ',', '.') }}đ</p>
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
            @endif
        </div>
    </section>

    <script>
        // Cấu hình giá cơ bản
        const TOUR_PRICE = {{ ($cartTour ?? null) ? $cartTour->sale_price : 0 }};
        const MAX_SLOTS = {{ ($cartTour ?? null) ? ($cartTour->quantity > 0 ? $cartTour->quantity : 10) : 10 }};
        let isVoucherApplied = {{ ($discount ?? 0) > 0 ? 'true' : 'false' }};
        let discountPercent = 0;

        // Định dạng tiền tệ VNĐ
        function formatMoney(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount) + 'đ';
        }

        // Hàm cập nhật số lượng
        function updateQty(inputId, change) {
            const inputEle = document.getElementById(inputId);
            if (!inputEle) return;
            let currentVal = parseInt(inputEle.value);
            let newVal = currentVal + change;

            // Ràng buộc số lượng
            if (newVal < 1) newVal = 1;
            if (newVal > MAX_SLOTS) newVal = MAX_SLOTS;

            inputEle.value = newVal;

            calculateTotals();

            // Đồng bộ giỏ hàng lên server
            @if($cartTour ?? null)
            fetch("{{ route('user.cart.update', ['id' => $cartTour->id]) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: new URLSearchParams({
                    id: "{{ $cartTour->id }}",
                    quantity: newVal
                })
            }).catch(e => console.log('Sync cart error:', e));
            @endif
        }

        // Hàm tính toán tổng tiền
        function calculateTotals() {
            const guestInput = document.getElementById('guest-qty');
            if (!guestInput) return;
            const guestQty = parseInt(guestInput.value) || 1;

            const itemTotal = guestQty * TOUR_PRICE;
            const totalGuests = guestQty;

            // Cập nhật giao diện của item
            const itemTotalEl = document.getElementById('item-total');
            const totalGuestsEl = document.getElementById('total-guests');
            const subtotalEl = document.getElementById('subtotal');
            const finalTotalEl = document.getElementById('final-total');

            if (itemTotalEl) itemTotalEl.innerText = formatMoney(itemTotal);
            if (totalGuestsEl) totalGuestsEl.innerText = totalGuests;
            if (subtotalEl) subtotalEl.innerText = formatMoney(itemTotal);

            // Xử lý Voucher và tính tổng thanh toán
            let discountAmount = 0;
            if (isVoucherApplied) {
                discountAmount = (itemTotal * discountPercent) / 100;
                const discEl = document.getElementById('discount-amount');
                if (discEl) discEl.innerText = '-' + formatMoney(discountAmount);
            }

            const finalTotal = Math.max(0, itemTotal - discountAmount);
            if (finalTotalEl) finalTotalEl.innerText = formatMoney(finalTotal);
        }

        // Logic Voucher
        function applyVoucher() {
            const codeInput = document.getElementById('voucher-code');
            if (!codeInput) return;
            const code = codeInput.value.trim().toUpperCase();
            const msgEle = document.getElementById('voucher-message');
            const discountRow = document.getElementById('discount-row');

            if (code === '') {
                msgEle.innerText = "Vui lòng nhập mã giảm giá.";
                msgEle.className = "text-xs mt-2 text-red-500 block";
                return;
            }

            fetch("{{ route('user.cart.applyVoucher') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: new URLSearchParams({ voucher_code: code })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    msgEle.innerHTML = '<i class="fa-solid fa-circle-check mr-1"></i> ' + (data.message || 'Áp dụng voucher thành công!');
                    msgEle.className = "text-xs mt-2 text-emerald-600 block font-medium";
                    codeInput.readOnly = true;
                    codeInput.classList.add('text-emerald-600', 'font-bold');
                    discountRow.classList.remove('hidden');
                    const discEl = document.getElementById('discount-amount');
                    if (discEl) discEl.innerText = '-' + formatMoney(data.discount || 0);
                    const finalTotalEl = document.getElementById('final-total');
                    if (finalTotalEl) finalTotalEl.innerText = formatMoney(data.finalTotal);
                } else {
                    msgEle.innerHTML = '<i class="fa-solid fa-circle-xmark mr-1"></i> ' + (data.message || 'Mã giảm giá không hợp lệ.');
                    msgEle.className = "text-xs mt-2 text-red-500 block font-medium";
                }
            })
            .catch(err => {
                msgEle.innerHTML = '<i class="fa-solid fa-circle-xmark mr-1"></i> Lỗi áp dụng mã giảm giá.';
                msgEle.className = "text-xs mt-2 text-red-500 block font-medium";
            });
        }

        window.onload = function() {
            calculateTotals();
        };
    </script>
@endsection
