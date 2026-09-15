@extends('admin.master')

@section('content')
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Header Topbar -->
        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 hidden md:flex flex-shrink-0">
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Chỉnh Sửa Banner</h2>
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
                        <a href="{{ url('admin/banner') }}" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:text-primary hover:border-primary transition-all mr-4 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div>
                            <h2 class="text-2xl font-bold text-dark">Chỉnh Sửa Banner</h2>
                            <p class="text-sm text-gray-500 mt-1">Cập nhật thông tin hoặc thay đổi hình ảnh của banner.</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <!-- Cột Trái (2/3): Thông tin -->
                        <div class="lg:col-span-2 space-y-6">
                            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-dark mb-6 flex items-center"><i class="fa-regular fa-file-lines text-primary mr-2"></i> Thông tin banner</h3>

                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-medium text-dark mb-2">Tên Banner <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" value="{{ old('name', $banner->name) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('name') border-red-500 @enderror" required>
                                        @error('name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-dark mb-2">Đường dẫn liên kết (Link)</label>
                                        <input type="text" name="link" value="{{ old('link', $banner->link) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('link') border-red-500 @enderror">
                                        @error('link')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cột Phải (1/3): Hình ảnh & Nút Lưu -->
                        <div class="space-y-6">

                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-dark mb-4">Hình ảnh Banner <span class="text-red-500">*</span></h3>

                                @if($banner->image)
                                    <div class="mb-4">
                                        <img src="{{ asset('storage/' . $banner->image) }}" class="w-full h-auto rounded-xl border border-gray-200 object-cover" alt="Current Banner Image">
                                    </div>
                                @endif

                                <div class="border-2 border-dashed border-sky-200 rounded-2xl bg-sky-50/50 p-6 text-center hover:bg-sky-50 transition-colors cursor-pointer group relative @error('image') border-red-500 @enderror">
                                    <!-- Remove required when editing to keep old image if no new one provided -->
                                    <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/png, image/jpeg">
                                    <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-cloud-arrow-up text-primary text-xl"></i>
                                    </div>
                                    <p class="text-sm font-bold text-primary">Thay đổi ảnh tải lên</p>
                                    <p class="text-[10px] text-gray-400 mt-2">Hỗ trợ JPG, PNG (Max 5MB)</p>
                                </div>
                                @error('image')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                                <h3 class="text-lg font-bold text-dark mb-4">Hành động</h3>

                                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-emerald-500/30 transform hover:-translate-y-0.5 flex items-center justify-center mb-3">
                                    <i class="fa-solid fa-floppy-disk mr-2"></i> <span>Lưu Thay Đổi</span>
                                </button>

                                <a href="{{ url('admin/banner') }}" class="w-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-dark font-medium py-3 rounded-xl transition-all duration-300 block text-center">
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
