@extends('admin.master')

@section('content')
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 hidden md:flex flex-shrink-0">
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Sửa Chi Tiết Tour</h2>
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
                        <a href="{{ url('admin/tour_detail') }}" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:text-primary hover:border-primary transition-all mr-4 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div>
                            <h2 class="text-2xl font-bold text-dark">Sửa Lịch trình (Timeline)</h2>
                            <p class="text-sm text-gray-500 mt-1">Cập nhật lại lộ trình, địa danh hoặc bản đồ trải nghiệm.</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.tour_schedules.update', $tour_detail->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <!-- Cột Trái (2/3): Lộ trình cơ bản -->
                        <div class="lg:col-span-2 space-y-6">

                            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-dark mb-6 flex items-center"><i class="fa-solid fa-map text-primary mr-2"></i> Nội dung hoạt động (Day by day)</h3>

                                <div class="space-y-5">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-dark mb-2">Thuộc tính của Tour (Chọn Tour) <span class="text-red-500">*</span></label>
                                            <select name="tour_id" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('tour_id') border-red-500 @enderror" required>
                                                @foreach($tours as $tour)
                                                    <option value="{{ $tour->id }}" {{ old('tour_id', $tour_detail->tour_id) == $tour->id ? 'selected' : '' }}>{{ $tour->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('tour_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Ngày số mấy? <span class="text-red-500">*</span></label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400 font-bold">Ngày</div>
                                                <input type="number" name="day_number" min="1" value="{{ old('day_number', $tour_detail->day_number) }}" placeholder="1" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 pl-12 pr-4 text-sm text-dark font-bold focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('day_number') border-red-500 @enderror" required>
                                            </div>
                                            @error('day_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-dark mb-2">Tiêu đề lịch trình (Title) <span class="text-red-500">*</span></label>
                                        <input type="text" name="title" value="{{ old('title', $tour_detail->title) }}" placeholder="VD: Khởi hành từ Hà Nội - Đến Sapa..." class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('title') border-red-500 @enderror" required>
                                        @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-dark mb-2">Mô tả hoạt động chi tiết (Description)</label>
                                        <textarea name="description" rows="5" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all resize-y @error('description') border-red-500 @enderror" required>{{ old('description', $tour_detail->description) }}</textarea>
                                        @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-dark mb-6 flex items-center"><i class="fa-solid fa-location-dot text-primary mr-2"></i> Bản đồ & Tọa độ</h3>
                                <p class="text-sm text-gray-500 mb-4">Các trường dưới đây không bắt buộc, điền để khách xem vị trí tham quan trên bản đồ điện tử.</p>

                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-medium text-dark mb-2">Tên địa danh (Location Name)</label>
                                        <input type="text" name="location_name" value="{{ old('location_name', $tour_detail->location_name) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('location_name') border-red-500 @enderror">
                                        @error('location_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Vĩ độ (Latitude)</label>
                                            <input type="number" step="0.000001" name="latitude" value="{{ old('latitude', $tour_detail->latitude) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark font-mono focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('latitude') border-red-500 @enderror">
                                            @error('latitude')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Kinh độ (Longitude)</label>
                                            <input type="number" step="0.000001" name="longitude" value="{{ old('longitude', $tour_detail->longitude) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark font-mono focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('longitude') border-red-500 @enderror">
                                            @error('longitude')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-dark mb-2">Link Bản Đồ (Google Map / Iframe Link)</label>
                                        <input type="text" name="map_link" value="{{ old('map_link', $tour_detail->map_link) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('map_link') border-red-500 @enderror">
                                        @error('map_link')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cột Phải (1/3): Hình ảnh & Đăng -->
                        <div class="space-y-6">

                            <!-- Upload Ảnh Đại Diện -->
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-dark mb-4">Hình ảnh minh họa</h3>

                                <!-- Current Image Preview -->
                                @if($tour_detail->image)
                                <div class="mb-4 text-center">
                                    <img src="{{ Str::startsWith($tour_detail->image, 'http') ? $tour_detail->image : asset($tour_detail->image) }}" class="w-full h-auto rounded-xl border border-gray-200 shadow-sm mx-auto object-cover" alt="Current Schedule Image">
                                </div>
                                @endif

                                <div class="border-2 border-dashed border-sky-200 rounded-2xl bg-sky-50/50 p-4 text-center hover:bg-sky-50 transition-colors cursor-pointer group relative @error('image') border-red-500 @enderror">
                                    <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/png, image/jpeg">
                                    <p class="text-sm font-bold text-primary">Thay đổi ảnh tải lên</p>
                                    <p class="text-[10px] text-gray-400 mt-1">JPG, PNG (Max 5MB)</p>
                                </div>
                                @error('image')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                            </div>

                            <!-- Tính năng đăng -->
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                                <h3 class="text-lg font-bold text-dark mb-4">Hành động</h3>

                                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-emerald-500/30 transform hover:-translate-y-0.5 flex items-center justify-center mb-3">
                                    <i class="fa-solid fa-arrows-rotate mr-2"></i> <span>Lưu Thay Đổi (Update)</span>
                                </button>

                                <a href="{{ url('admin/tour_detail') }}" class="w-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-dark font-medium py-3 rounded-xl transition-all duration-300 block text-center">
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
