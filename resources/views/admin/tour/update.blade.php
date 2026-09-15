@extends('admin.master')

@section('content')
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Header Topbar -->
        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 hidden md:flex flex-shrink-0">
            <!-- Left: Mobile menu button & Search -->
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Cập Nhật Thông Tin Tour</h2>
            </div>
            <!-- Right: Admin Profile -->
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

        <!-- Main Scrollable Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 lg:p-10 relative">

            <div class="block pb-10">
                <form action="{{ route('admin.tours.update', $tour->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                <!-- Back Button & Title -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center">
                        <a href="{{ url('admin/tour') }}" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:text-primary hover:border-primary transition-all mr-4 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div>
                            <h2 class="text-2xl font-bold text-dark">Cập Nhật Thông Tin Tour</h2>
                            <p class="text-sm text-gray-500 mt-1">Chỉnh sửa và cập nhật lại thông tin chi tiết của chuyến đi.</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <span class="text-sm font-medium text-gray-600">Trạng thái:</span>
                        <!-- Toggle Switch -->
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox" id="tour-status" name="status" value="1" class="sr-only peer" {{ old('status', $tour->status) == '1' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            <span class="ml-3 text-sm font-bold {{ old('status', $tour->status) == '1' ? 'text-emerald-600' : 'text-gray-500' }}" id="status-text">{{ old('status', $tour->status) == '1' ? 'Đang mở bán' : 'Bản nháp / Tạm ẩn' }}</span>
                        </label>
                    </div>
                </div>
                @error('status')<p class="text-red-500 text-xs mt-1 text-right">{{ $message }}</p>@enderror

                <!-- Form Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <!-- Cột Trái (2/3): Thông tin chính -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Card 1: Thông tin cơ bản -->
                            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-dark mb-6 flex items-center"><i class="fa-regular fa-file-lines text-primary mr-2"></i> Thông tin cơ bản</h3>

                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-medium text-dark mb-2">Tên Tour <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" value="{{ old('name', $tour->name) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('name') border-red-500 @enderror" required>
                                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Số lượng chỗ <span class="text-red-500">*</span></label>
                                            <input type="number" name="quantity" value="{{ old('quantity', $tour->quantity) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('quantity') border-red-500 @enderror" required>
                                            @error('quantity')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Danh mục <span class="text-red-500">*</span></label>
                                            <select name="category_id" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('category_id') border-red-500 @enderror" required>
                                                <option value="">-- Chọn danh mục --</option>
                                                @foreach($categoryOptions as $opt)
                                                    <option value="{{ $opt['id'] }}" {{ old('category_id', $tour->category_id) == $opt['id'] ? 'selected' : '' }}>{{ $opt['name'] }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Điểm khởi hành <span class="text-red-500">*</span></label>
                                            <input type="text" name="start_location" value="{{ old('start_location', $tour->start_location) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('start_location') border-red-500 @enderror" required>
                                            @error('start_location')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Điểm đến <span class="text-red-500">*</span></label>
                                            <input type="text" name="end_location" value="{{ old('end_location', $tour->end_location) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('end_location') border-red-500 @enderror" required>
                                            @error('end_location')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Thời gian (Thời lượng) <span class="text-red-500">*</span></label>
                                            <input type="text" name="time" value="{{ old('time', $tour->time) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('time') border-red-500 @enderror" required>
                                            @error('time')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Ngày khởi hành <span class="text-red-500">*</span></label>
                                            <input type="date" name="start_date" value="{{ old('start_date', $tour->start_date) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('start_date') border-red-500 @enderror" required>
                                            @error('start_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: Giá cả -->
                            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-dark mb-6 flex items-center"><i class="fa-solid fa-tag text-primary mr-2"></i> Thiết lập giá</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-dark mb-2">Giá gốc (VNĐ) <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="number" name="price" value="{{ old('price', $tour->price) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 pl-4 pr-12 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all text-right font-bold @error('price') border-red-500 @enderror" required>
                                            <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 font-medium text-sm pointer-events-none">đ</span>
                                        </div>
                                        @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-dark mb-2">Giá khuyến mãi (Tùy chọn)</label>
                                        <div class="relative">
                                            <input type="number" name="sale_price" value="{{ old('sale_price', $tour->sale_price) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 pl-4 pr-12 text-sm text-emerald-600 focus:outline-none focus:border-emerald-500 focus:bg-white admin-input transition-all text-right font-bold @error('sale_price') border-red-500 @enderror">
                                            <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 font-medium text-sm pointer-events-none">đ</span>
                                        </div>
                                        <p class="text-[10px] text-gray-500 mt-1">Để trống nếu không có khuyến mãi.</p>
                                        @error('sale_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Mô tả (Lịch trình) -->
                            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-dark mb-6 flex items-center"><i class="fa-solid fa-list-ul text-primary mr-2"></i> Chi tiết / Lịch trình</h3>

                                <div>
                                    <label class="block text-sm font-medium text-dark mb-2">Đoạn mô tả ngắn (Tổng quan)</label>
                                    <textarea name="description" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all resize-none @error('description') border-red-500 @enderror">{{ old('description', $tour->description) }}</textarea>
                                    @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>

                        <!-- Cột Phải (1/3): Hình ảnh & Hành động -->
                        <div class="space-y-6">

                            <!-- Card: Upload Ảnh -->
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-dark mb-4">Hình ảnh đại diện</h3>

                                @if($tour->image)
                                    <div class="mb-4 text-center">
                                        <img src="{{ Str::startsWith($tour->image, 'http') ? $tour->image : asset($tour->image) }}" class="w-full h-32 object-cover rounded-xl border border-gray-200 mx-auto" alt="Current Image">
                                    </div>
                                @endif

                                <div class="border-2 border-dashed border-sky-200 rounded-2xl bg-sky-50/50 p-6 text-center hover:bg-sky-50 transition-colors cursor-pointer group relative @error('file') border-red-500 @enderror">
                                    <input type="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/png, image/jpeg, image/webp">
                                    <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-cloud-arrow-up text-primary text-xl"></i>
                                    </div>
                                    <p class="text-sm font-bold text-primary">Đổi ảnh đại diện</p>
                                    <p class="text-[10px] text-gray-400 mt-2">Hỗ trợ JPG, PNG, WEBP (Max 5MB)</p>
                                </div>
                                @error('file')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror

                                <h3 class="text-lg font-bold text-dark mt-6 mb-4 flex items-center justify-between">
                                    <span>Ảnh mô tả (Thư viện)</span>
                                </h3>

                                @if($tour->images && $tour->images->count() > 0)
                                    <div class="grid grid-cols-3 gap-2 mb-4">
                                        @foreach($tour->images as $img)
                                            <div class="relative group h-20 rounded-lg overflow-hidden border border-gray-200">
                                                <img src="{{ Str::startsWith($img->image, 'http') ? $img->image : asset($img->image) }}" class="w-full h-full object-cover" alt="Image">
                                            </div>
                                        @endforeach
                                    </div>
                                    <p class="text-[10px] text-yellow-600 mb-2 italic">Lưu ý: Nếu bạn tải lên ảnh mới, tất cả thư viện ảnh mô tả cũ sẽ bị xóa và thay thế toàn bộ.</p>
                                @endif

                                <div class="border-2 border-dashed border-sky-200 rounded-2xl bg-sky-50/50 p-6 text-center hover:bg-sky-50 transition-colors cursor-pointer group relative @error('files.*') border-red-500 @enderror">
                                    <input type="file" name="files[]" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/png, image/jpeg, image/webp">
                                    <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-images text-primary text-xl"></i>
                                    </div>
                                    <p class="text-sm font-bold text-primary">Hiệu đính thư viện ảnh mới</p>
                                    <p class="text-[10px] text-gray-400 mt-2">Chọn nhiều ảnh cùng lúc (Max 5MB/file)</p>
                                </div>
                                @error('files.*')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                            </div>

                            <!-- Card: Actions (Lưu) -->
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                                <h3 class="text-lg font-bold text-dark mb-4">Hành động</h3>

                                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-emerald-500/30 transform hover:-translate-y-0.5 flex items-center justify-center mb-3">
                                    <i class="fa-solid fa-floppy-disk mr-2"></i> <span>Lưu Thay Đổi</span>
                                </button>

                                <a href="{{ url('admin/tour') }}" class="w-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-dark font-medium py-3 rounded-xl transition-all duration-300 block text-center">
                                    Hủy bỏ
                                </a>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        </main>
    </div>

    <!-- Script toggle Status -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusCheckbox = document.getElementById('tour-status');
            const statusText = document.getElementById('status-text');

            if(statusCheckbox) {
                statusCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        statusText.innerText = "Đang mở bán";
                        statusText.classList.remove('text-gray-500');
                        statusText.classList.add('text-emerald-600');
                    } else {
                        statusText.innerText = "Bản nháp / Tạm ẩn";
                        statusText.classList.remove('text-emerald-600');
                        statusText.classList.add('text-gray-500');
                    }
                });
            }
        });
    </script>
@endsection
