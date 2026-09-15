@extends('admin.master')

@section('content')
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Header Topbar -->
        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 hidden md:flex flex-shrink-0">
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Thêm Danh Mục Mới</h2>
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

        <!-- Main Scrollable Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 lg:p-10 relative">
            <div class="block pb-10">

                <!-- Back Button & Title -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center">
                        <a href="{{ route('categories.index') }}" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:text-primary hover:border-primary transition-all mr-4 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div>
                            <h2 class="text-2xl font-bold text-dark">Thêm Danh Mục Mới</h2>
                            <p class="text-sm text-gray-500 mt-1">Quản lý cách phân loại tour trong hệ thống.</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <!-- Cột Trái (2/3) -->
                        <div class="lg:col-span-2 space-y-6">
                            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-dark mb-6 flex items-center"><i class="fa-regular fa-folder-open text-primary mr-2"></i> Thông tin danh mục</h3>

                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-medium text-dark mb-2">Tên Danh Mục <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Ví dụ: Tour Du Lịch Biển Đảo" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('name') border-red-500 @enderror" required>
                                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-dark mb-2">Đường dẫn liên kết (Slug/Link) <span class="text-red-500">*</span></label>
                                        <input type="text" name="link" value="{{ old('link') }}" placeholder="Ví dụ: /tour-bien-dao" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('link') border-red-500 @enderror" required>
                                        @error('link')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-dark mb-2">Danh Chọn Trực Thuộc (Danh Mục Cha)</label>
                                        <select name="category_id" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('category_id') border-red-500 @enderror">
                                            <option value="">-- Thuộc Danh Mục Gốc (Không có cha) --</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <!-- Tuỳ chọn: status ẩn cũng có thể bỏ ra ngoài checkbox giống phần tour tùy style -->
                                </div>
                            </div>
                        </div>

                        <!-- Cột Phải (1/3) -->
                        <div class="space-y-6">
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                                <h3 class="text-lg font-bold text-dark mb-4">Trạng thái & Hành động</h3>

                                <div class="mb-6 flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
                                    <span class="text-sm font-medium text-gray-700">Hiển thị trên web</span>
                                    <input type="hidden" name="status" value="0">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="status" value="1" class="sr-only peer" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                                    </label>
                                </div>

                                <button type="submit" class="w-full bg-primary hover:bg-sky-600 text-white font-bold py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-sky-500/30 transform hover:-translate-y-0.5 flex items-center justify-center mb-3">
                                    <i class="fa-solid fa-floppy-disk mr-2"></i> <span>Tạo Danh Mục</span>
                                </button>

                                <a href="{{ route('categories.index') }}" class="w-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-dark font-medium py-3 rounded-xl transition-all duration-300 block text-center">
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
