@extends('users.master')

@section('home')
<div class="min-h-screen pt-40 pb-20 flex items-center justify-center bg-slate-50">
    <div class="max-w-md w-full bg-white p-8 md:p-10 rounded-[2.5rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.05)] border border-slate-100 mx-4">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-inner">
                <i class="fa-solid fa-key text-3xl"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-900 mb-3">Quên mật khẩu</h2>
            <p class="text-slate-500 text-sm leading-relaxed px-4">Vui lòng nhập địa chỉ email của bạn. Chúng tôi sẽ gửi cho bạn mã OTP để đặt lại mật khẩu.</p>
        </div>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf
            
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Địa chỉ Email</label>
                <div class="relative group">
                    <i class="fa-solid fa-envelope absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                    <input type="email" name="email" placeholder="Nhập email của bạn..."
                        class="w-full pl-14 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all text-slate-900 font-medium" required>
                </div>
                @error('email')
                    <p class="text-red-500 text-sm mt-2 ml-1 font-medium flex items-center"><i class="fa-solid fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-2 mt-4">
                Gửi mã xác nhận
                <i class="fa-solid fa-arrow-right ml-1"></i>
            </button>

            <div class="text-center mt-8">
                <a href="{{ route('account') }}" class="inline-flex items-center justify-center gap-2 text-slate-500 hover:text-blue-600 font-semibold text-sm transition-colors group">
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center group-hover:bg-blue-50 transition-colors">
                        <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    </div>
                    Quay lại đăng nhập
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
