@extends('user.master')
@section('home')
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">


                <!-- Trạng thái quy trình (Step 2 Active) -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="cart.html"
                        class="flex items-center text-emerald-600 font-medium hover:underline cursor-pointer">
                        <div
                            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mr-2">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        Giỏ hàng
                    </a>
                    <div class="w-12 h-px bg-emerald-500"></div>
                    <div class="flex items-center text-primary font-bold">
                        <div
                            class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center mr-2 shadow-md shadow-sky-200">
                            2</div>
                        Thanh toán
                    </div>
                    <div class="w-12 h-px bg-gray-300"></div>
                    <div class="flex items-center text-gray-400 font-medium">
                        <div class="w-8 h-8 rounded-full border-2 border-gray-300 flex items-center justify-center mr-2">3
                        </div>
                        Hoàn tất
                    </div>
                </div>


            </div>
        </div>

    <!-- Main Content -->
    <section class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-dark">Hoàn tất đặt tour</h1>
                <a href="cart.html" class="text-gray-500 hover:text-primary font-medium text-sm transition-colors"><i
                        class="fa-solid fa-arrow-left mr-1"></i> Quay lại giỏ hàng</a>
            </div>

            <!-- Form bao quanh toàn bộ khu vực để submit -->
            <form id="checkout-form" class="flex flex-col lg:flex-row gap-8" onsubmit="handleCheckout(event)">

                <!-- Cột trái: Thông tin khách hàng & Phương thức thanh toán -->
                <div class="w-full lg:w-2/3 space-y-8">

                    <!-- Phần 1: Thông tin liên hệ -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                        <div class="flex items-center mb-6 border-b border-gray-100 pb-4">
                            <div
                                class="w-8 h-8 rounded-full bg-sky-100 text-primary flex items-center justify-center mr-3 font-bold">
                                1</div>
                            <h2 class="text-xl font-bold text-dark">Thông tin liên lạc</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Họ và tên -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-dark mb-2">Họ và tên người đặt <span
                                        class="text-red-500">*</span></label>
                                <div
                                    class="relative flex items-center input-field border border-gray-200 rounded-xl bg-gray-50 transition-all overflow-hidden">
                                    <i class="fa-regular fa-user absolute left-4 text-gray-400"></i>
                                    <input type="text" required placeholder="VD: Nguyễn Văn A"
                                        class="w-full bg-transparent py-3.5 pl-11 pr-4 text-sm text-dark focus:outline-none">
                                </div>
                            </div>

                            <!-- Số điện thoại -->
                            <div>
                                <label class="block text-sm font-medium text-dark mb-2">Số điện thoại <span
                                        class="text-red-500">*</span></label>
                                <div
                                    class="relative flex items-center input-field border border-gray-200 rounded-xl bg-gray-50 transition-all overflow-hidden">
                                    <i class="fa-solid fa-phone absolute left-4 text-gray-400"></i>
                                    <input type="tel" required pattern="[0-9]{10,11}" placeholder="VD: 0912345678"
                                        class="w-full bg-transparent py-3.5 pl-11 pr-4 text-sm text-dark focus:outline-none">
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-dark mb-2">Email <span
                                        class="text-red-500">*</span></label>
                                <div
                                    class="relative flex items-center input-field border border-gray-200 rounded-xl bg-gray-50 transition-all overflow-hidden">
                                    <i class="fa-regular fa-envelope absolute left-4 text-gray-400"></i>
                                    <input type="email" required placeholder="VD: email@example.com"
                                        class="w-full bg-transparent py-3.5 pl-11 pr-4 text-sm text-dark focus:outline-none">
                                </div>
                                <p class="text-[10px] text-gray-500 mt-1">Vé điện tử sẽ được gửi về email này.</p>
                            </div>

                            <!-- Địa chỉ -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-dark mb-2">Địa chỉ (Tùy chọn)</label>
                                <div
                                    class="relative flex items-center input-field border border-gray-200 rounded-xl bg-gray-50 transition-all overflow-hidden">
                                    <i class="fa-solid fa-location-dot absolute left-4 text-gray-400"></i>
                                    <input type="text" placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố"
                                        class="w-full bg-transparent py-3.5 pl-11 pr-4 text-sm text-dark focus:outline-none">
                                </div>
                            </div>

                            <!-- Ghi chú -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-dark mb-2">Ghi chú cho chuyến đi (Tùy
                                    chọn)</label>
                                <div
                                    class="relative flex items-start input-field border border-gray-200 rounded-xl bg-gray-50 transition-all overflow-hidden">
                                    <i class="fa-regular fa-comment-dots absolute left-4 top-4 text-gray-400"></i>
                                    <textarea rows="3" placeholder="Ví dụ: Ăn chay, dị ứng hải sản, phụ nữ có thai..."
                                        class="w-full bg-transparent py-3.5 pl-11 pr-4 text-sm text-dark focus:outline-none resize-none"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Phần 2: Phương thức thanh toán -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                        <div class="flex items-center mb-6 border-b border-gray-100 pb-4">
                            <div
                                class="w-8 h-8 rounded-full bg-sky-100 text-primary flex items-center justify-center mr-3 font-bold">
                                2</div>
                            <h2 class="text-xl font-bold text-dark">Phương thức thanh toán</h2>
                        </div>

                        <div class="space-y-4">

                            <!-- Option 1: Thanh toán trực tiếp (Tiền mặt / Chuyển khoản) -->
                            <label class="block cursor-pointer relative group">
                                <input type="radio" name="payment_method" value="direct" class="payment-radio sr-only"
                                    checked>
                                <div class="border-2 border-gray-200 rounded-xl p-5 transition-all hover:border-gray-300">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div
                                                class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mr-4">
                                                <i class="fa-solid fa-building-columns text-xl"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-dark text-base">Thanh toán trực tiếp / Chuyển
                                                    khoản</h3>
                                                <p class="text-xs text-gray-500">Giữ chỗ trước, thanh toán sau qua ngân hàng
                                                    hoặc tại văn phòng.</p>
                                            </div>
                                        </div>
                                        <!-- Check mark icon -->
                                        <div
                                            class="check-icon w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center opacity-0 transform scale-50 transition-all duration-300">
                                            <i class="fa-solid fa-check text-xs"></i>
                                        </div>
                                    </div>
                                    <!-- Mô tả ẩn, hiện khi check -->
                                    <div
                                        class="payment-desc max-h-0 opacity-0 overflow-hidden transition-all duration-500 border-t border-sky-100 text-sm text-gray-600">
                                        <p class="mb-2 font-medium text-dark">Thông tin chuyển khoản ngân hàng:</p>
                                        <div class="bg-white border border-gray-200 rounded-lg p-3 space-y-2">
                                            <div class="flex justify-between"><span class="text-gray-500">Ngân
                                                    hàng:</span> <strong>Vietcombank</strong></div>
                                            <div class="flex justify-between"><span class="text-gray-500">Số tài
                                                    khoản:</span> <strong>0123456789</strong></div>
                                            <div class="flex justify-between"><span class="text-gray-500">Chủ tài
                                                    khoản:</span> <strong>CÔNG TY TNHH WANDERLUST</strong></div>
                                            <div class="flex justify-between items-start">
                                                <span class="text-gray-500 w-24">Nội dung CK:</span>
                                                <strong class="text-right text-primary">SĐT_TEN_KHACH_HANG</strong>
                                            </div>
                                        </div>
                                        <p class="mt-2 text-xs italic text-amber-600"><i
                                                class="fa-solid fa-triangle-exclamation mr-1"></i> Vui lòng thanh toán
                                            trong vòng 24h để hệ thống giữ chỗ.</p>
                                    </div>
                                </div>
                            </label>

                            <!-- Option 2: Thanh toán qua MoMo -->
                            <label class="block cursor-pointer relative group">
                                <input type="radio" name="payment_method" value="momo"
                                    class="payment-radio sr-only">
                                <div class="border-2 border-gray-200 rounded-xl p-5 transition-all hover:border-gray-300">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div
                                                class="w-12 h-12 rounded-lg bg-pink-50 text-[#a50064] flex items-center justify-center mr-4">
                                                <i class="fa-solid fa-wallet text-xl"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-dark text-base">Thanh toán qua Ví MoMo</h3>
                                                <p class="text-xs text-gray-500">Quét mã QR bằng ứng dụng MoMo. Miễn phí
                                                    giao dịch.</p>
                                            </div>
                                        </div>
                                        <div
                                            class="check-icon w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center opacity-0 transform scale-50 transition-all duration-300">
                                            <i class="fa-solid fa-check text-xs"></i>
                                        </div>
                                    </div>
                                    <div
                                        class="payment-desc max-h-0 opacity-0 overflow-hidden transition-all duration-500 border-t border-sky-100 text-sm text-gray-600">
                                        <div class="flex items-center p-3 bg-white rounded-lg border border-pink-100">
                                            <i class="fa-solid fa-qrcode text-3xl text-gray-400 mr-4"></i>
                                            <p>Bạn sẽ được chuyển hướng đến cổng thanh toán an toàn của MoMo để quét mã QR
                                                hoàn tất giao dịch.</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Option 3: Thanh toán qua VNPAY -->
                            <label class="block cursor-pointer relative group">
                                <input type="radio" name="payment_method" value="vnpay"
                                    class="payment-radio sr-only">
                                <div class="border-2 border-gray-200 rounded-xl p-5 transition-all hover:border-gray-300">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div
                                                class="w-12 h-12 rounded-lg bg-blue-50 text-[#005baa] flex items-center justify-center mr-4">
                                                <i class="fa-solid fa-credit-card text-xl"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-dark text-base">Thanh toán VNPAY / Thẻ ATM</h3>
                                                <p class="text-xs text-gray-500">Quét mã VNPAY-QR hoặc dùng thẻ
                                                    ATM/Visa/Mastercard.</p>
                                            </div>
                                        </div>
                                        <div
                                            class="check-icon w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center opacity-0 transform scale-50 transition-all duration-300">
                                            <i class="fa-solid fa-check text-xs"></i>
                                        </div>
                                    </div>
                                    <div
                                        class="payment-desc max-h-0 opacity-0 overflow-hidden transition-all duration-500 border-t border-sky-100 text-sm text-gray-600">
                                        <div class="flex items-center p-3 bg-white rounded-lg border border-blue-100">
                                            <i class="fa-solid fa-mobile-screen-button text-3xl text-gray-400 mr-4"></i>
                                            <p>Bạn sẽ được chuyển hướng đến cổng VNPAY. Hỗ trợ thanh toán qua ứng dụng
                                                Mobile Banking của hơn 40 ngân hàng.</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                        </div>
                    </div>
                </div>

                <!-- Cột phải: Tổng quan Đơn hàng (Sticky) -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-2xl shadow-soft border border-gray-100 sticky top-28">

                        <div class="p-6">
                            <h2 class="text-lg font-bold text-dark mb-4 border-b border-gray-100 pb-4">Tóm tắt đơn hàng
                            </h2>

                            <!-- Thông tin Tour -->
                            <div class="flex gap-4 mb-6">
                                <img src="https://images.unsplash.com/photo-1540304618210-91a030046645?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80"
                                    alt="Tour Thumbnail" class="w-20 h-20 object-cover rounded-lg">
                                <div>
                                    <h3 class="text-sm font-bold text-dark line-clamp-2 leading-tight mb-1">Hành Trình Di
                                        Sản Miền Trung: Hội An - Đà Nẵng - Huế</h3>
                                    <p class="text-xs text-gray-500"><i class="fa-regular fa-calendar mr-1"></i>
                                        15/09/2026</p>
                                    <p class="text-xs text-gray-500 mt-1"><i class="fa-solid fa-user-group mr-1"></i> 2
                                        Người lớn, 0 Trẻ em</p>
                                </div>
                            </div>

                            <!-- Tính toán chi phí (Kế thừa từ bước giỏ hàng) -->
                            <div class="space-y-3 mb-6 border-y border-gray-100 py-4">
                                <div class="flex justify-between items-center text-gray-600 text-sm">
                                    <span>Giá tour (2 khách)</span>
                                    <span class="font-medium text-dark">11.800.000đ</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-emerald-600 flex items-center">Voucher áp dụng</span>
                                    <span class="font-bold text-emerald-600">-1.180.000đ</span>
                                </div>
                            </div>

                            <!-- Tổng thanh toán -->
                            <div class="flex justify-between items-end mb-6">
                                <div>
                                    <p class="text-sm font-bold text-dark">Tổng thanh toán</p>
                                    <p class="text-[10px] text-gray-400">Đã bao gồm VAT & Thuế phí</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-bold text-primary">10.620.000đ</p>
                                </div>
                            </div>

                            <!-- Điều khoản -->
                            <div class="mb-6 flex items-start">
                                <input type="checkbox" id="terms" required
                                    class="mt-1 w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary cursor-pointer">
                                <label for="terms" class="ml-2 text-xs text-gray-500 cursor-pointer">
                                    Tôi đã đọc và đồng ý với các <a href="#"
                                        class="text-primary hover:underline">Điều khoản đặt dịch vụ</a> và <a
                                        href="#" class="text-primary hover:underline">Chính sách hủy hoàn tiền</a>
                                    của Wanderlust.
                                </label>
                            </div>

                            <!-- Nút Xác nhận Thanh toán -->
                            <!-- Chú ý: Vì dùng thẻ <form>, nút này phải có type="submit" -->
                            <button type="submit" id="submit-btn"
                                class="w-full bg-primary hover:bg-sky-600 text-white font-bold text-lg py-4 rounded-xl shadow-lg shadow-sky-500/30 transition-all duration-300 transform hover:-translate-y-1 flex justify-center items-center group relative">
                                <span class="btn-text flex items-center">
                                    <i class="fa-solid fa-lock text-sm mr-2 opacity-80"></i> Hoàn tất Đặt Tour
                                </span>
                                <div class="loading-spinner absolute"></div>
                            </button>
                        </div>

                        <!-- Badges -->
                        <div class="bg-gray-50 p-4 rounded-b-2xl border-t border-gray-100 text-center">
                            <p class="text-[10px] text-gray-400 mb-2 uppercase tracking-wider font-bold">Thanh toán an toàn
                                với</p>
                            <div class="flex items-center justify-center space-x-3 opacity-60">
                                <span class="text-sm font-bold text-dark">VISA</span>
                                <span class="text-sm font-bold text-dark">MasterCard</span>
                                <span class="text-sm font-bold text-[#a50064]">MoMo</span>
                                <span class="text-sm font-bold text-[#005baa]">VNPAY</span>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </section>
    <script>
        function handleCheckout(event) {
            // Ngăn chặn form submit mặc định để chạy hiệu ứng
            event.preventDefault();

            const form = event.target;
            const submitBtn = document.getElementById('submit-btn');

            // Validate (HTML5 validation đã xử lý một phần do có thuộc tính required)
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Lấy phương thức thanh toán đang chọn
            const selectedPayment = document.querySelector('input[name="payment_method"]:checked').value;

            // Thêm class is-loading để hiển thị spinner
            submitBtn.classList.add('is-loading');
            submitBtn.disabled = true;

            // Mô phỏng quá trình xử lý (gọi API...) mất khoảng 1.5 giây
            setTimeout(() => {
                // Tùy thuộc vào phương thức thanh toán để xử lý bước tiếp theo
                if (selectedPayment === 'momo') {
                    alert("Đang chuyển hướng đến cổng thanh toán MoMo...");
                    // window.location.href = 'link-momo';
                } else if (selectedPayment === 'vnpay') {
                    alert("Đang chuyển hướng đến cổng thanh toán VNPAY...");
                    // window.location.href = 'link-vnpay';
                } else {
                    alert("Đặt tour thành công! Hướng dẫn chuyển khoản đã được gửi vào email của bạn.");
                    // Chuyển đến trang Cảm ơn/Hoàn tất (Step 3)
                    // window.location.href = 'success.html';
                }

                // Xóa trạng thái loading (thường thì khi chuyển trang sẽ không cần bước này, nhưng để demo thì khôi phục lại nút)
                submitBtn.classList.remove('is-loading');
                submitBtn.disabled = false;

            }, 1500);
        }
    </script>

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
                        momo: '#a50064', // MoMo brand color
                        vnpay: '#005baa', // VNPAY brand color
                    },
                    boxShadow: {
                        'soft': '0 10px 40px -10px rgba(0,0,0,0.08)',
                    }
                }
            }
        }
    </script>
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* Hiệu ứng focus cho input */
        .input-field:focus-within {
            box-shadow: 0 0 0 2px rgba(14, 165, 233, 0.2);
            border-color: #0ea5e9;
        }

        /* Tùy chỉnh radio button ẩn để tạo custom card */
        .payment-radio:checked + div {
            border-color: #0ea5e9;
            background-color: #f0f9ff;
        }
        .payment-radio:checked + div .check-icon {
            opacity: 1;
            transform: scale(1);
        }
        .payment-radio:checked + div .payment-desc {
            max-height: 200px;
            opacity: 1;
            margin-top: 12px;
            padding-top: 12px;
        }

        /* Hiệu ứng loading cho nút submit */
        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .is-loading .loading-spinner {
            display: inline-block;
        }
        .is-loading .btn-text {
            display: none;
        }
    </style>
@endsection
