@extends('admins.master')

@section('title', 'Cập nhật thông tin người dùng')

@section('home')
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-5xl mx-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-lg shadow-amber-200">
                    <i class="fa-solid fa-user-pen text-lg"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-amber-600 to-orange-500">
                        Cập nhật hồ sơ
                    </h4>
                    <p class="text-sm text-slate-500 mt-1">Chỉnh sửa thông tin thành viên hệ thống</p>
                </div>
            </div>

            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-xl transition-all duration-300 shadow-sm group">
                <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                <span>Quay lại danh sách</span>
            </a>
        </div>
        
        {{-- ALERTS --}}
        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50/50 p-5 backdrop-blur-sm">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
                    <p class="font-semibold text-rose-700 text-base">Vui lòng kiểm tra lại thông tin:</p>
                </div>
                <ul class="list-disc list-inside text-rose-600 text-sm space-y-1 ml-7">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM CARD --}}
        <div class="bg-white/90 backdrop-blur-xl border border-white shadow-2xl shadow-slate-200/50 rounded-3xl overflow-hidden relative">
            <div class="absolute top-0 right-0 p-32 bg-amber-50 rounded-full blur-3xl opacity-60 -z-10 -translate-y-1/2 translate-x-1/2"></div>
            
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="relative z-10 p-6 sm:p-10 space-y-8">
                @csrf
                @method('PUT')

                {{-- ===== THÔNG TIN CƠ BẢN ===== --}}
                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center">
                            <i class="fa-solid fa-address-card text-sm"></i>
                        </div>
                        <h5 class="text-lg font-bold text-slate-800">Thông tin cơ bản</h5>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- Name --}}
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">
                                Tên hiển thị <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-300 {{ $errors->has('name') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/20' : '' }}">
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">
                                Địa chỉ Email <span class="text-slate-400 text-xs font-normal ml-1">(Không thể sửa)</span>
                            </label>
                            <div class="relative">
                                <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="email" value="{{ $user->email }}" readonly
                                    class="w-full bg-slate-100 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-slate-500 font-medium cursor-not-allowed select-none">
                            </div>
                        </div>
                        
                        {{-- Phone --}}
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">
                                Số điện thoại
                            </label>
                            <div class="relative">
                                <i class="fa-solid fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-300 {{ $errors->has('phone') ? 'border-rose-300' : '' }}">
                                </div>
                        </div>

                        {{-- Vai trò --}}
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Vai trò <span class="text-slate-400 text-xs font-normal ml-1">(Không thể sửa)</span></label>
                            <div class="relative">
                                <i class="fa-solid fa-shield-halved absolute left-4 top-1/2 -translate-y-1/2 text-purple-400"></i>
                                <select disabled class="w-full bg-slate-100 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-slate-500 font-medium appearance-none cursor-not-allowed select-none">
                                    <option {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                </select>
                            </div>
                        </div>
                        
                        {{-- Status --}}
                        <div class="md:col-span-2">
                            <label class="block text-slate-700 font-semibold mb-2">
                                Trạng thái hoạt động <span class="text-rose-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="status" value="dang_hoat_dong" class="peer sr-only" {{ old('status', $user->status) === 'dang_hoat_dong' ? 'checked' : '' }}>
                                    <div class="w-full border-2 border-slate-100 rounded-xl px-4 py-3 text-center font-bold text-slate-400 hover:bg-slate-50 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-600 transition-all">
                                        <i class="fa-solid fa-circle-check mr-2"></i> Cho phép hoạt động
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="status" value="dung_hoat_dong" class="peer sr-only" {{ old('status', $user->status) === 'dung_hoat_dong' ? 'checked' : '' }}>
                                    <div class="w-full border-2 border-slate-100 rounded-xl px-4 py-3 text-center font-bold text-slate-400 hover:bg-slate-50 peer-checked:border-slate-400 peer-checked:bg-slate-100 peer-checked:text-slate-600 transition-all">
                                        <i class="fa-solid fa-lock mr-2"></i> Khóa tài khoản
                                    </div>
                                </label>
                            </div>
                        </div>

                    </div>
                </section>
                
                <hr class="border-slate-100">

                {{-- ===== CÁ NHÂN HÓA ===== --}}
                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-pink-50 text-pink-500 flex items-center justify-center">
                            <i class="fa-solid fa-image-portrait text-sm"></i>
                        </div>
                        <h5 class="text-lg font-bold text-slate-800">Thông tin cá nhân & Ảnh đại diện</h5>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        {{-- Gender --}}
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Giới tính</label>
                            <select name="gender" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-300">
                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Khác</option>
                            </select>
                        </div>
                        
                        {{-- Birthday --}}
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Ngày sinh</label>
                            <input type="date" name="birthday" value="{{ old('birthday', $user->birthday) }}" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-300">
                        </div>
                        
                        {{-- Avatar Upload --}}
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Đổi Avatar</label>
                            <label class="flex items-center justify-center w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 cursor-pointer hover:bg-slate-100 transition-colors group">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-cloud-arrow-up text-slate-400 group-hover:text-orange-500 transition-colors"></i>
                                    <span class="text-sm font-medium text-slate-600 group-hover:text-orange-600 transition-colors" id="file-name">Tải ảnh mới</span>
                                </div>
                                <input type="file" name="avatar" class="hidden" accept="image/*" onchange="previewImage(event)">
                            </label>
                        </div>
                        
                        {{-- Address --}}
                        <div class="md:col-span-3">
                            <label class="block text-slate-700 font-semibold mb-2">Địa chỉ hiện tại</label>
                            <div class="relative">
                                <i class="fa-solid fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="address" value="{{ old('address', $user->address) }}" placeholder="Số nhà, đường, xã/phường, quận/huyện, tỉnh/thành phố..."
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-300">
                            </div>
                        </div>

                    </div>
                    
                    {{-- Avatar Preview --}}
                    <div class="mt-6 flex flex-col sm:flex-row gap-6 items-center">
                        <div class="relative shrink-0">
                            <img id="avatar-preview" src="{{ $user->avatar_url }}" 
                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=10b981&color=fff';" 
                                 class="w-32 h-32 md:w-40 md:h-40 rounded-[2rem] object-cover shadow-lg border-4 border-white">
                            <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow">
                                <i class="fa-solid fa-camera text-slate-400 text-sm"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-700 mb-1">Ảnh đại diện hiện tại</p>
                            <p class="text-xs text-slate-500">Khuyến nghị tỉ lệ 1:1, dung lượng tối đa 2MB.</p>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100">

                {{-- SUBMIT --}}
                <div class="flex flex-col sm:flex-row justify-end gap-4 pt-2">
                    <button type="submit"
                        class="inline-flex justify-center items-center gap-2 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-orange-200/50 hover:shadow-xl hover:shadow-orange-300/50 hover:-translate-y-0.5 transition-all duration-300 text-sm">
                        <i class="fa-solid fa-save text-lg"></i> Lưu thay đổi hồ sơ
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const fileNameLabel = document.getElementById('file-name');
        const preview = document.getElementById('avatar-preview');
        
        if (file) {
            fileNameLabel.textContent = "Đã chọn ảnh mới";
            preview.src = URL.createObjectURL(file);
            preview.classList.add('ring-4', 'ring-orange-200');
        }
    }
</script>
@endsection

