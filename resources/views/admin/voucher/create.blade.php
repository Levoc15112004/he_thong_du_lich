@extends('admin.master')

@section('content')
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 hidden md:flex flex-shrink-0">
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Thêm Voucher Khuyến Mãi</h2>
            </div>

            <div class="flex items-center space-x-4">
                <button class="w-10 h-10 rounded-full bg-gray-50 text-gray-500 flex items-center justify-center hover:bg-gray-100 hover:text-primary transition-colors relative">
                    <i class="fa-regular fa-bell"></i>
                </button>
                <div class="h-8 w-px bg-gray-200"></div>
                <div class="relative group cursor-pointer pb-2">
                    <div class="flex items-center">
                        <img src="https://i.pravatar.cc/150?img=11" alt="Admin" class="w-9 h-9 rounded-full border-2 border-white shadow-sm">
                        <span class="ml-2 text-sm font-bold text-dark hidden sm:block">{{ Auth::check() ? Auth::user()->name : 'Admin' }}</span>
                    </div>
                    <!-- Dropdown -->
                    <div class="absolute right-0 top-full w-48 bg-white border border-gray-100 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden">
                        <form action="{{ route('logout.admin') }}" method="POST" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 flex items-center font-medium">
                                <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 lg:p-10 relative">
            <div class="block pb-10">

                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center">
                        <a href="{{ url('admin/voucher') }}" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:text-primary hover:border-primary transition-all mr-4 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div>
                            <h2 class="text-2xl font-bold text-dark">Tạo Voucher / Mã Giảm Giá Mới</h2>
                            <p class="text-sm text-gray-500 mt-1">Quản lý các chương trình khuyến mãi cho sự kiện hoặc khách hàng thân thiết.</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.vouchers.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <!-- Cột Trái (2/3): Thông tin cơ bản & Quy định giảm -->
                        <div class="lg:col-span-2 space-y-6">

                            <!-- Box 1: Info -->
                            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-dark mb-6 flex items-center"><i class="fa-solid fa-ticket text-primary mr-2"></i> Thông Tin Mã Giảm</h3>

                                <div class="space-y-5">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Mã Voucher (Code) <span class="text-red-500">*</span></label>
                                            <input type="text" name="code" value="{{ old('code') }}" placeholder="VD: SUMMER26" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm font-mono font-bold text-sky-600 focus:outline-none focus:border-primary focus:bg-white admin-input transition-all uppercase @error('code') border-red-500 @enderror" required>
                                            @error('code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Sự kiện (Event Type)</label>
                                            <input type="text" name="event_type" value="{{ old('event_type', 'normal') }}" placeholder="VD: normal, flash_sale, black_friday..." class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('event_type') border-red-500 @enderror">
                                            @error('event_type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-dark mb-2">Tên Chương Trình (Name) <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" value="{{ old('name') }}" placeholder="VD: Khuyến Mãi Hè Sôi Động Giảm 10%" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('name') border-red-500 @enderror" required>
                                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-dark mb-2">Mô tả thêm (Description)</label>
                                        <textarea name="description" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all resize-y @error('description') border-red-500 @enderror" placeholder="Mô tả cho khách hàng biết điều kiện áp dụng...">{{ old('description') }}</textarea>
                                        @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Box 2: Giá Trị Giảm -->
                            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-dark mb-6 flex items-center"><i class="fa-solid fa-percent text-primary mr-2"></i> Thiết Lập Chiết Khấu</h3>

                                <div class="space-y-5">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Loại Giảm Giá (Type) <span class="text-red-500">*</span></label>
                                            <select name="discount_type" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('discount_type') border-red-500 @enderror" required>
                                                <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Giảm theo Phần Trăm (%)</option>
                                                <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Giảm Trực Tiếp Giá Tiền (VNĐ)</option>
                                            </select>
                                            @error('discount_type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Giá Trị Giảm (Value) <span class="text-red-500">*</span></label>
                                            <div class="relative">
                                                <input type="number" name="discount_value" value="{{ old('discount_value') }}" step="0.01" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark font-bold focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('discount_value') border-red-500 @enderror" required>
                                            </div>
                                            @error('discount_value')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Giảm Tối Đa (Max Discount)</label>
                                            <input type="number" name="max_discount" value="{{ old('max_discount') }}" placeholder="VD: 500000" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('max_discount') border-red-500 @enderror">
                                            <p class="text-[10px] text-gray-400 mt-1">Dành cho loại giảm % (Có thể bỏ trống)</p>
                                            @error('max_discount')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Đơn Hàng Tối Thiểu (Min Order)</label>
                                            <input type="number" name="min_order_value" value="{{ old('min_order_value') }}" placeholder="VD: 2000000" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('min_order_value') border-red-500 @enderror">
                                            <p class="text-[10px] text-gray-400 mt-1">Bỏ trống nếu không yêu cầu mốc giá.</p>
                                            @error('min_order_value')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cột Phải (1/3): Thời Gian & Action -->
                        <div class="space-y-6">

                            <!-- Box 3: Thời Hạn & Giới Hạn -->
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-dark mb-4">Mốc Thời Gian & Giới Hạn</h3>

                                <div class="space-y-5">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Tổng số lượng phát hành</label>
                                            <input type="number" name="quantity" value="{{ old('quantity', 100) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-3 text-sm text-dark font-bold focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('quantity') border-red-500 @enderror">
                                            @error('quantity')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <!-- Used_count luôn = 0 lúc khởi tạo -->
                                        <div class="opacity-50 pointer-events-none cursor-not-allowed">
                                            <label class="block text-sm font-medium text-dark mb-2">Đã dùng</label>
                                            <input type="number" value="0" readonly class="w-full bg-gray-100 border border-gray-200 rounded-xl py-2.5 px-3 text-sm text-gray-500 font-bold focus:outline-none">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-dark mb-2">Thời gian bắt đầu (Start Date)</label>
                                        <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-3 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('start_date') border-red-500 @enderror">
                                        @error('start_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-dark mb-2">Thời gian kết thúc (End Date)</label>
                                        <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-3 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('end_date') border-red-500 @enderror">
                                        @error('end_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Tính năng đăng -->
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                                <h3 class="text-lg font-bold text-dark mb-4">Xuất Bản & Trạng Thái</h3>

                                <div class="mb-6 flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100 relative">
                                    <span class="text-sm font-medium text-gray-700">Kích hoạt Voucher ngay</span>
                                    <input type="hidden" name="status" value="0">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="status" value="1" class="sr-only peer" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                                    </label>
                                    @error('status')<p class="text-red-500 text-xs absolute -bottom-5 right-0">{{ $message }}</p>@enderror
                                </div>

                                <button type="submit" class="w-full bg-primary hover:bg-sky-600 text-white font-bold py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-sky-500/30 transform hover:-translate-y-0.5 flex items-center justify-center mb-3">
                                    <i class="fa-solid fa-floppy-disk mr-2"></i> <span>Tạo Mã Khuyến Mãi</span>
                                </button>

                                <a href="{{ url('admin/voucher') }}" class="w-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-dark font-medium py-3 rounded-xl transition-all duration-300 block text-center">
                                    Hủy bỏ
                                </a>
                            </div>

                        </div>

                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection
