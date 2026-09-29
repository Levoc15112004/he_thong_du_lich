@extends('users.master')

@section('home')
<div class="min-h-screen pt-40 pb-20 flex items-center justify-center bg-slate-50">
    <div class="max-w-md w-full bg-white p-8 md:p-10 rounded-[2.5rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.05)] border border-slate-100 mx-4">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-green-50 text-green-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-inner">
                <i class="fa-solid fa-lock-open text-3xl"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-900 mb-3">Đặt lại mật khẩu</h2>
            <p class="text-slate-500 text-sm leading-relaxed px-4">Vui lòng nhập mã OTP đã được gửi đến email của bạn và tạo mật khẩu mới.</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Mã OTP</label>
                <div class="relative group">
                    <i class="fa-solid fa-shield-halved absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-green-500 transition-colors"></i>
                    <input type="text" name="otp" placeholder="Nhập mã OTP..."
                        class="w-full pl-14 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-green-500 focus:ring-4 focus:ring-green-500/10 transition-all text-slate-900 font-medium tracking-widest" required>
                </div>
                @error('otp')
                    <p class="text-red-500 text-sm mt-2 ml-1 font-medium flex items-center"><i class="fa-solid fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Mật khẩu mới</label>
                <div class="relative group">
                    <i class="fa-solid fa-lock absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-green-500 transition-colors"></i>
                    <input type="password" name="password" placeholder="Nhập mật khẩu mới..."
                        class="w-full pl-14 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-green-500 focus:ring-4 focus:ring-green-500/10 transition-all text-slate-900 font-medium" required>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-2 ml-1 font-medium flex items-center"><i class="fa-solid fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Xác nhận mật khẩu</label>
                <div class="relative group">
                    <i class="fa-solid fa-check-double absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-green-500 transition-colors"></i>
                    <input type="password" name="password_confirmation" placeholder="Xác nhận lại mật khẩu..."
                        class="w-full pl-14 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-green-500 focus:ring-4 focus:ring-green-500/10 transition-all text-slate-900 font-medium" required>
                </div>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-4 rounded-2xl font-bold shadow-xl shadow-green-200 hover:bg-green-700 hover:-translate-y-1 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-2 mt-6">
                Đổi mật khẩu
                <i class="fa-solid fa-check ml-1"></i>
            </button>
            
            <div class="text-center mt-6">
                <a href="{{ route('account') }}" class="inline-flex items-center justify-center gap-2 text-slate-500 hover:text-green-600 font-semibold text-sm transition-colors group">
                    Hủy bỏ
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
