@extends('users.master')

@section('home')
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Roboto"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9', // Sky Blue
                            600: '#0284c7', // Primary Blue
                            700: '#0369a1',
                        }
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                        'glow': '0 0 15px rgba(14, 165, 233, 0.3)',
                    }
                }
            }
        }
    </script>
    <div class="relative  py-8 pt-24 overflow-hidden">

        <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-8">
                <a href="{{ route('user.home') }}" class="hover:text-brand-600">Trang chủ</a>
                <i class="fa-solid fa-chevron-right text-sm"></i>
                <span class="text-brand-700 font-medium">Hồ sơ cá nhân</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- LEFT SIDEBAR -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-2xl shadow-soft p-6 sticky top-24 border">

                        <!-- User Card -->
                        <div class="flex flex-col items-center text-center">
                            <div class="relative mb-4 group">
                                <div
                                    class="w-16 h-16 rounded-full p-1 border-2 border-dashed border-brand-300 group-hover:border-brand-500 transition">
                                    <img id="avatarPreviews"
                                        src="{{ $user->avatar ? asset($user->avatar) : asset('fontend/img/img_default.jpg') }}"
                                        alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                                </div>
                                <label for="avatarInput"
                                    class="absolute bottom-0 right-0 bg-brand-600 text-white p-2 rounded-full cursor-pointer hover:bg-brand-700 w-8 h-8 flex items-center justify-center">
                                    <i class="fa-solid fa-camera text-xs"></i>
                                </label>
                            </div>

                            <h2 class="text-lg font-bold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-base text-gray-400">{{ $user->email }}</p>
                        </div>

                        <!-- Menu -->
                        <div class="mt-8 space-y-2">
                            <a href="#profile"
                                class="flex items-center text-base gap-3 px-4 py-3 rounded-xl bg-brand-50 text-brand-700 font-medium">
                                <i class="fa-regular fa-user w-5"></i> Thông tin cá nhân
                            </a>

                            <a href="{{ route('user.tours.booked') }}"
                                class="flex items-center text-base gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
                                <i class="fa-solid fa-clock-rotate-left w-5"></i> Lịch sử đặt tour
                            </a>

                            <a href="#security"
                                class="flex items-center text-base gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
                                <i class="fa-solid fa-shield-halved w-5"></i> Đổi mật khẩu
                            </a>

                            <div class="pt-4 mt-4 border-t">
                                <form action="{{ route('user.logout') }}" method="POST">
                                    @csrf
                                    <button
                                        class="flex w-full text-base items-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 font-medium">
                                        <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT CONTENT -->
                <div class="lg:col-span-9 space-y-8">

                    <!-- PROFILE -->
                    <section id="profile" class="bg-white rounded-2xl shadow-soft border p-6 md:p-8 scroll-mt-24">

                        <div class="mb-6">
                            <h3 class="text-base font-bold text-gray-900">Thông tin cá nhân</h3>
                            <p class="text-sm text-gray-500 mt-1">Cập nhật thông tin tài khoản</p>
                        </div>

                        <form action="{{ route('user.updateProfile') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-6">
                            @csrf

                            <!-- Hidden Avatar -->
                            <input type="file" id="avatarInput" name="avatar" accept="image/*"
                                onchange="previewAvatar(event)" class="hidden">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <!-- Name -->
                                <div>
                                    <label class="text-base font-semibold">Họ và tên</label>
                                    <input name="name" value="{{ $user->name }}"
                                        class="w-full mt-1 text-sm px-4 py-3 rounded-xl bg-gray-50 focus:ring-2 focus:ring-brand-500">
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="text-base font-semibold">Email</label>
                                    <input readonly name="email" value="{{ $user->email }}"
                                        class="w-full mt-1 text-sm px-4 py-3 rounded-xl bg-gray-100 cursor-not-allowed">
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label class="text-base font-semibold">Số điện thoại</label>
                                    <input name="phone" value="{{ $user->phone }}"
                                        class="w-full mt-1 text-sm px-4 py-3 rounded-xl bg-gray-50 focus:ring-2 focus:ring-brand-500">
                                </div>

                                <!-- Address -->
                                <div>
                                    <label class="text-base font-semibold">Địa chỉ</label>
                                    <input name="address" value="{{ $user->address }}"
                                        class="w-full mt-1 px-4 text-sm py-3 rounded-xl bg-gray-50 focus:ring-2 focus:ring-brand-500">
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label class="text-base font-semibold">Giới tính</label>
                                    <select name="gender" class="w-full mt-1 text-sm px-4 py-3 rounded-xl bg-gray-50">
                                        <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Nam</option>
                                        <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Nữ
                                        </option>
                                        <option value="orther" {{ $user->gender == 'orther' ? 'selected' : '' }}>Khác
                                        </option>
                                    </select>
                                </div>

                                <!-- Birthday -->
                                <div>
                                    <label class="text-base font-semibold">Ngày sinh</label>
                                    <input type="date" name="birthday" value="{{ $user->birthday }}"
                                        class="w-full mt-1 text-sm px-4 py-3 rounded-xl bg-gray-50">
                                </div>
                            </div>

                            <!-- About -->
                            <div>
                                <label class="text-base font-semibold">Giới thiệu</label>
                                <textarea name="about" rows="3" class="w-full mt-1 p-4 rounded-xl bg-gray-50">{{ $user->about }}</textarea>
                            </div>

                            <div class="flex justify-end">
                                <button
                                    class="bg-brand-600 hover:bg-brand-700 text-base px-8 py-3 rounded-xl font-bold shadow">
                                    Lưu thay đổi
                                </button>
                            </div>
                        </form>
                    </section>

                    <!-- SECURITY (placeholder) -->
                    <section id="security" class="bg-white rounded-2xl shadow-soft border p-6 md:p-8 scroll-mt-24">
                        <h3 class="text-base font-bold mb-4">Đổi mật khẩu</h3>
                        <form action="{{ route('user.change.password') }}" method="POST" class="max-w-xl">
                            @csrf

                            <div class="space-y-5">

                                <!-- Mật khẩu hiện tại -->
                                <div>
                                    <label class="text-base font-semibold text-gray-700 mb-1 block">
                                        Mật khẩu hiện tại
                                    </label>
                                    <input type="password" name="current_password"
                                        class="w-full px-4 py-3 rounded-xl bg-gray-50 focus:ring-2 focus:ring-brand-500"
                                        placeholder="••••••••">
                                    @error('current_password')
                                        <p class="text-red-500 text-base mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Mật khẩu mới -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-base font-semibold text-gray-700 mb-1 block">
                                            Mật khẩu mới
                                        </label>
                                        <input type="password" name="password"
                                            class="w-full px-4 py-3 rounded-xl bg-gray-50 focus:ring-2 focus:ring-brand-500"
                                            placeholder="••••••••">
                                        @error('password')
                                            <p class="text-red-500 text-base mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="text-base font-semibold text-gray-700 mb-1 block">
                                            Nhập lại mật khẩu
                                        </label>
                                        <input type="password" name="password_confirmation"
                                            class="w-full px-4 py-3 rounded-xl bg-gray-50 focus:ring-2 focus:ring-brand-500"
                                            placeholder="••••••••">
                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="pt-4">
                                    <button type="submit"
                                        class="bg-gray-800 text-white px-5 py-2 rounded-xl font-bold hover:bg-gray-900 transition-all">
                                        Cập nhật mật khẩu
                                    </button>
                                </div>

                                <!-- Thông báo thành công -->
                                @if (session('success'))
                                    <p class="text-green-600 text-base mt-2">
                                        {{ session('success') }}
                                    </p>
                                @endif

                            </div>
                        </form>

                    </section>

                </div>
            </div>
        </main>
    </div>

    <script>
        function previewAvatar(event) {
            const output = document.getElementById('avatarPreviews');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = () => URL.revokeObjectURL(output.src);
        }
    </script>
@endsection
