@extends('admins.master')

@section('home')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8fafc;
        }

        .gradient-primary {
            background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
        }

        .voucher-preview {
            background-image: radial-gradient(circle at 0% 50%, transparent 15px, #ffffff 16px),
                radial-gradient(circle at 100% 50%, transparent 15px, #ffffff 16px);
        }

        .input-error {
            border-color: #ef4444 !important;
        }
    </style>

    <main class="flex-1 p-6 lg:p-10">
        <form action="{{ route('admin.vouchers.store') }}" method="POST">
            @csrf

            <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-xl sm:text-3xl font-bold text-slate-900 ">Tạo Voucher Mới</h1>
                    <p class="text-slate-500 mt-1">Thiết lập các chương trình ưu đãi hấp dẫn cho khách du lịch.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.vouchers.index') }}"
                        class="px-5 py-2.5 border border-slate-200 text-slate-600 font-medium rounded-xl hover:bg-white transition-all">
                        Hủy bỏ
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-blue-200 hover:opacity-90 transition-all">
                        Lưu Voucher
                    </button>
                </div>
            </header>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <div class="xl:col-span-2 space-y-6">

                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                        <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <span
                                class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-sm">01</span>
                            Thông tin cơ bản
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Tên chương trình ưu đãi</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    placeholder="Ví dụ: Ưu đãi Hè Rực Rỡ 2024"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Mã Voucher</label>
                                <div class="relative">
                                    <input type="text" id="voucherCode" name="code" value="{{ old('code') }}"
                                        placeholder="HELLO2024"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none  font-mono font-bold transition-all @error('code') border-red-500 @enderror">
                                    <button type="button" onclick="generateCode()"
                                        class="absolute right-2 top-1.5 px-3 py-1.5 text-xs font-bold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-all">
                                        <i class="fas fa-random mr-1"></i> Tự động
                                    </button>
                                </div>
                                @error('code')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                        <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <span
                                class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center text-sm">02</span>
                            Cấu hình giảm giá
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Loại giảm giá</label>
                                <select id="discountType" name="discount_type"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none bg-white @error('discount_type') border-red-500 @enderror">
                                    <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Phần
                                        trăm (%)</option>
                                    <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Số tiền
                                        cố định (₫)</option>
                                </select>
                                @error('discount_type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Giá trị giảm</label>
                                <div class="relative">
                                    <input type="number" id="discountValue" name="discount_value"
                                        value="{{ old('discount_value', 10) }}"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none @error('discount_value') border-red-500 @enderror">
                                    <span id="valueUnit" class="absolute right-4 top-3.5 text-slate-400 font-bold">%</span>
                                </div>
                                @error('discount_value')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Tổng số lượng phát hành</label>
                                <input type="number" name="quantity" value="{{ old('quantity', 100) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none @error('quantity') border-red-500 @enderror">
                                @error('quantity')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">

                                <label class="text-sm font-semibold text-slate-700">
                                    Loại sự kiện
                                </label>

                                <select name="event_type" id="event_type"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200">

                                    <option value="none">Không</option>

                                    <option value="register">
                                        Đăng ký lần đầu
                                    </option>

                                    <option value="summer">
                                        Sự kiện mùa hè
                                    </option>

                                    <option value="order_amount">
                                        Đơn hàng tối thiểu
                                    </option>

                                    <option value="first_order">
                                        Đơn đầu tiên
                                    </option>

                                </select>

                            </div>

                            <input type="hidden" name="status" value="1">
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                        <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <span
                                class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm">03</span>
                            Thời gian áp dụng
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Ngày bắt đầu</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none @error('start_date') border-red-500 @enderror">
                                @error('start_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Ngày kết thúc</label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none @error('end_date') border-red-500 @enderror">
                                @error('end_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <div class="space-y-6">
                    <div class="gradient-primary p-6 rounded-[2rem] shadow-xl shadow-blue-200 text-white sticky top-6">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <p class="text-blue-100 text-xs font-bold  ">Live Preview</p>
                                <h3 class="text-xl font-bold mt-1">Xác nhận Voucher</h3>
                            </div>
                            <i class="fas fa-eye opacity-50 text-xl"></i>
                        </div>

                        <div class="voucher-preview rounded-2xl p-6 text-slate-800 relative shadow-lg">
                            <div
                                class="flex flex-col items-center justify-center border-b border-dashed border-slate-200 pb-4 mb-4">
                                <p class="text-slate-500 text-xs font-bold  ">Mã Giảm Giá</p>
                                <p id="previewCode" class="text-3xl font-bold text-blue-600 ">#2026SUMMER</p>

                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <div>
                                        <p id="previewValue" class="text-lg font-bold leading-tight">Giảm 10%</p>
                                        <p
                                            class="text-[10px] text-slate-500  font-bold  text-blue-600">
                                            Áp dụng cho tour của bạn</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-500">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold">Hạn sử dụng</p>
                                        <p id="previewExpiry" class="text-[11px] font-medium text-slate-500">
                                            Chưa xác định ngày
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="button"
                                    class="w-full py-3 bg-slate-900 text-white rounded-xl text-sm font-bold hover:scale-[1.02] transition-transform">
                                    Sử dụng ngay
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-amber-50 p-6 rounded-3xl border border-amber-100">
                        <div class="flex gap-4">
                            <div
                                class="w-10 h-10 shrink-0 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-amber-900">Mẹo quản trị</h4>
                                <p class="text-sm text-amber-700 mt-1 leading-relaxed">Đảm bảo ngày kết thúc sau ngày
                                    bắt đầu để voucher có hiệu lực.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script>
        function generateCode() {
            const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            let result = "VIVU";
            for (let i = 0; i < 5; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById("voucherCode").value = result;
            updatePreview();
        }

        function updatePreview() {
            // Cập nhật Mã
            const code = document.getElementById("voucherCode").value || "HELLO2024";
            document.getElementById("previewCode").innerText = code.to();

            // Cập nhật Giá trị
            const type = document.getElementById("discountType").value;
            const value = document.getElementById("discountValue").value || "0";
            const unitSpan = document.getElementById("valueUnit");

            if (type === "percent") {
                unitSpan.innerText = "%";
                document.getElementById("previewValue").innerText = `Giảm ${value}%`;
            } else {
                unitSpan.innerText = "₫";
                document.getElementById("previewValue").innerText = `Giảm ${Number(value).toLocaleString()}₫`;
            }

            // Tính toán số ngày còn lại
            const endDateInput = document.getElementById("end_date").value;
            const previewExpiry = document.getElementById("previewExpiry");

            if (endDateInput) {
                const now = new Date();
                now.setHours(0, 0, 0, 0); // Đưa về đầu ngày để tính chính xác

                const end = new Date(endDateInput);
                end.setHours(0, 0, 0, 0);

                const diffInMs = end - now;
                const diffInDays = Math.ceil(diffInMs / (1000 * 60 * 60 * 24));

                if (diffInDays > 0) {
                    previewExpiry.innerText = `Còn ${diffInDays} ngày`;
                    previewExpiry.className = "text-[11px] font-medium " + (diffInDays <= 3 ? "text-red-500" :
                        "text-emerald-600");
                } else if (diffInDays === 0) {
                    previewExpiry.innerText = "Hết hạn hôm nay";
                    previewExpiry.className = "text-[11px] font-medium text-orange-500";
                } else {
                    previewExpiry.innerText = "Đã hết hạn hoặc ngày không hợp lệ";
                    previewExpiry.className = "text-[11px] font-medium text-red-500";
                }
            } else {
                previewExpiry.innerText = "Chưa xác định ngày";
                previewExpiry.className = "text-[11px] font-medium text-slate-500";
            }
        }

        // Sự kiện cập nhật
        document.getElementById("voucherCode").addEventListener("input", updatePreview);
        document.getElementById("discountValue").addEventListener("input", updatePreview);
        document.getElementById("discountType").addEventListener("change", updatePreview);
        document.getElementById("end_date").addEventListener("change", updatePreview);

        // Chạy lần đầu khi load trang (trong trường hợp có old value)
        window.addEventListener('load', updatePreview);
    </script>
@endsection

