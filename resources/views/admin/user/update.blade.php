@extends('admin.master')

@section('content')
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 hidden md:flex flex-shrink-0">
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Sửa Người Dùng</h2>
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
                        <a href="{{ url('admin/user') }}" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:text-primary hover:border-primary transition-all mr-4 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div>
                            <h2 class="text-2xl font-bold text-dark">Sửa Thông Tin Người Dùng</h2>
                            <p class="text-sm text-gray-500 mt-1">Cập nhật hồ sơ, phân quyền hoặc đổi trạng thái.</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <div class="lg:col-span-2 space-y-6">
                            <!-- Card 1: Tài khoản -->
                            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-dark mb-6 flex items-center"><i class="fa-solid fa-shield-halved text-primary mr-2"></i> Thông tin đăng nhập</h3>

                                <div class="space-y-5">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Họ & Tên <span class="text-red-500">*</span></label>
                                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('name') border-red-500 @enderror" required>
                                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Địa chỉ Email <span class="text-red-500">*</span></label>
                                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('email') border-red-500 @enderror" required>
                                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Mật khẩu mới</label>
                                            <input type="password" name="password" placeholder="Bỏ trống nếu không muốn đổi" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('password') border-red-500 @enderror">
                                            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Vai trò (Role)</label>
                                            <select name="role" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('role') border-red-500 @enderror">
                                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Người dùng (User)</option>
                                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                                            </select>
                                            @error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: Thông tin cá nhân -->
                            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-dark mb-6 flex items-center"><i class="fa-regular fa-address-card text-primary mr-2"></i> Hồ sơ chi tiết</h3>

                                <div class="space-y-5">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Số điện thoại</label>
                                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('phone') border-red-500 @enderror">
                                            @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Giới tính</label>
                                            <select name="gender" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('gender') border-red-500 @enderror">
                                                <option value="">-- Chọn giới tính --</option>
                                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                                                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Khác</option>
                                            </select>
                                            @error('gender')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Ngày sinh</label>
                                            <input type="date" name="birthday" value="{{ old('birthday', $user->birthday) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('birthday') border-red-500 @enderror">
                                            @error('birthday')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-dark mb-2">Địa chỉ hiện tại</label>
                                            <input type="text" name="address" value="{{ old('address', $user->address) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-dark focus:outline-none focus:border-primary focus:bg-white admin-input transition-all @error('address') border-red-500 @enderror">
                                            @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cột Phải (1/3) -->
                        <div class="space-y-6">

                            <!-- Card: Upload Ảnh -->
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-dark mb-4">Ảnh đại diện (Avatar)</h3>

                                @if($user->avatar)
                                    <div class="mb-4 text-center">
                                        <img src="{{ asset('storage/' . $user->avatar) }}" class="w-24 h-24 rounded-full border-4 border-gray-50 shadow-sm mx-auto object-cover" alt="Current Avatar">
                                    </div>
                                @endif

                                <div class="border-2 border-dashed border-sky-200 rounded-2xl bg-sky-50/50 p-4 text-center hover:bg-sky-50 transition-colors cursor-pointer group relative @error('avatar') border-red-500 @enderror">
                                    <input type="file" name="avatar" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/png, image/jpeg">
                                    <p class="text-sm font-bold text-primary">Thay đổi ảnh đại diện</p>
                                    <p class="text-[10px] text-gray-400 mt-1">Hỗ trợ JPG, PNG (Max 2MB)</p>
                                </div>
                                @error('avatar')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                            </div>

                            <!-- Card: Actions -->
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                                <h3 class="text-lg font-bold text-dark mb-4">Trạng thái & Hành động</h3>

                                <div class="mb-5">
                                    <label class="block text-sm font-medium text-dark mb-2">Trạng thái tài khoản</label>
                                    <select name="status" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm font-bold focus:outline-none focus:border-primary focus:bg-white admin-input transition-all text-emerald-600 @error('status') border-red-500 @enderror">
                                        <option value="1" {{ old('status', $user->status) == '1' ? 'selected' : '' }}>Đang hoạt động</option>
                                        <option value="0" {{ old('status', $user->status) == '0' ? 'selected' : '' }}>Dừng hoạt động</option>
                                    </select>
                                    @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>

                                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-emerald-500/30 transform hover:-translate-y-0.5 flex items-center justify-center mb-3">
                                    <i class="fa-solid fa-floppy-disk mr-2"></i> <span>Lưu Thay Đổi</span>
                                </button>

                                <a href="{{ url('admin/user') }}" class="w-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-dark font-medium py-3 rounded-xl transition-all duration-300 block text-center">
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
