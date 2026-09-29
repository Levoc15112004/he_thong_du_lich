@extends('admins.master')

@section('title', 'Danh sách người dùng')

@section('home')
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-7xl mx-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-4 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-400 to-emerald-500 flex items-center justify-center text-white shadow-lg shadow-teal-200">
                    <i class="fa-solid fa-users text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-700 to-emerald-600">
                        Quản lý Người dùng
                    </h4>
                    <p class="text-sm text-slate-500 mt-1">Xem danh sách và quản lý thông tin thành viên trong hệ thống.</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl shadow-sm flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center">
                        <i class="fa-solid fa-users-viewfinder"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Tổng số viên</p>
                        <p class="text-sm font-bold text-slate-800">{{ $users->total() }} người</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ALERTS --}}
        @if (session('success'))
            <div class="bg-emerald-50/80 backdrop-blur-sm border border-emerald-200 text-emerald-800 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                    <i class="fa-solid fa-check"></i>
                </div>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @elseif(session('error'))
            <div class="bg-rose-50/80 backdrop-blur-sm border border-rose-200 text-rose-800 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif

        {{-- SEARCH --}}
        <div class="bg-white/80 backdrop-blur-xl border border-white p-6 rounded-3xl shadow-xl shadow-slate-100/50">
            <div class="flex flex-col sm:flex-row gap-4 items-center">
                <div class="relative flex-1 w-full group">
                    <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-teal-500 transition-colors"></i>
                    <input type="text" placeholder="Tìm kiếm tên, email, số điện thoại..."
                        class="w-full pl-12 pr-6 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all outline-none placeholder:text-slate-400">
                </div>
                <button class="w-full sm:w-auto px-8 py-3.5 bg-slate-800 text-white rounded-xl font-bold hover:bg-slate-900 transition-all shadow-lg shadow-slate-200 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-filter"></i> Lọc dữ liệu
                </button>
            </div>
        </div>

        {{-- DESKTOP TABLE VIEW --}}
        <div class="hidden lg:block bg-white/90 backdrop-blur-xl border border-white shadow-2xl shadow-slate-200/50 rounded-3xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 w-16">Thành viên</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700">Liên hệ</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 text-center w-28">Vai trò</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 text-center w-36">Trạng thái</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 text-center w-32">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-white shadow-md bg-slate-100 flex items-center justify-center">
                                            <img src="{{ $user->avatar ? asset($user->avatar) : asset('fontend/img/img_default.jpg') }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white {{ $user->status == 'dang_hoat_dong' ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-slate-800 text-base leading-tight">{{ $user->name }}</h5>
                                        <span class="text-xs text-slate-500 font-medium">ID: #{{ $user->id }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 mb-1">
                                    <i class="fa-solid fa-envelope text-slate-400 text-xs w-4"></i>
                                    <span class="text-sm font-medium text-slate-700">{{ $user->email }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-phone text-slate-400 text-xs w-4"></i>
                                    <span class="text-sm text-slate-600">{{ $user->phone ?? 'Chưa cập nhật' }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($user->role == 'admin')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-50 text-purple-700 border border-purple-100 rounded-lg text-xs font-bold shadow-sm">
                                        <i class="fa-solid fa-shield-halved"></i> Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-teal-50 text-teal-700 border border-teal-100 rounded-lg text-xs font-bold shadow-sm">
                                        <i class="fa-regular fa-user"></i> User
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($user->status == 'dang_hoat_dong')
                                    <span class="inline-flex px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-lg text-xs font-bold shadow-sm justify-center w-full">
                                        Đang hoạt động
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 bg-slate-100 text-slate-600 border border-slate-200 rounded-lg text-xs font-bold shadow-sm justify-center w-full">
                                        Dừng hoạt động
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="w-10 h-10 flex items-center justify-center text-amber-500 bg-amber-50 border border-amber-200 rounded-xl hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản này không? Mọi dữ liệu liên quan có thể bị ảnh hưởng.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 flex items-center justify-center text-rose-500 bg-rose-50 border border-rose-200 rounded-xl hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-users-slash text-5xl mb-4 text-slate-300"></i>
                                    <p class="text-lg font-medium">Hiện không có người dùng nào trong hệ thống.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/50">
                    {{ $users->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

        {{-- MOBILE CARDS VIEW --}}
        <div class="lg:hidden space-y-4">
            @forelse($users as $user)
                <div class="bg-white/90 backdrop-blur-xl border border-white rounded-3xl shadow-lg shadow-slate-200/50 p-5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 {{ $user->role == 'admin' ? 'bg-purple-50/50' : 'bg-teal-50/50' }} rounded-full blur-2xl -z-10 -translate-y-1/2 translate-x-1/2"></div>
                    
                    <div class="flex items-center gap-4 mb-4">
                        <div class="relative">
                            <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-white shadow-md bg-slate-100 flex items-center justify-center shrink-0">
                                <img src="{{ $user->avatar ? asset($user->avatar) : asset('fontend/img/img_default.jpg') }}" class="w-full h-full object-cover">
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white {{ $user->status == 'dang_hoat_dong' ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h5 class="font-bold text-slate-800 text-lg leading-tight truncate">{{ $user->name }}</h5>
                            <div class="flex items-center gap-2 mt-1">
                                @if($user->role == 'admin')
                                    <span class="text-[10px] font-bold text-purple-700 bg-purple-100 px-2 array-1 rounded-md">ADMIN</span>
                                @else
                                    <span class="text-[10px] font-bold text-teal-700 bg-teal-100 px-2 py-0.5 rounded-md">USER</span>
                                @endif
                                <span class="text-xs font-medium text-slate-400">#{{ $user->id }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-3 space-y-2 mb-4">
                        <div class="flex items-center gap-3 text-sm">
                            <i class="fa-solid fa-envelope text-slate-400 shrink-0"></i>
                            <span class="font-medium text-slate-700 truncate">{{ $user->email }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <i class="fa-solid fa-phone text-slate-400 shrink-0"></i>
                            <span class="text-slate-600">{{ $user->phone ?? 'Chưa cập nhật' }}</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="flex items-center justify-center gap-2 bg-amber-50 hover:bg-amber-500 text-amber-600 hover:text-white py-2.5 rounded-xl font-bold transition-colors text-sm border border-amber-100">
                            <i class="fa-solid fa-pen"></i> Sửa
                        </a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa tài khoản?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-rose-50 hover:bg-rose-500 text-rose-600 hover:text-white py-2.5 rounded-xl font-bold transition-colors text-sm border border-rose-100">
                                <i class="fa-solid fa-trash"></i> Xóa
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white/80 p-10 rounded-3xl border border-dashed border-slate-300 text-center">
                    <i class="fa-solid fa-users-slash text-4xl mb-3 text-slate-300"></i>
                    <p class="text-slate-500 font-medium">Không có người dùng nào!</p>
                </div>
            @endforelse
            
            @if($users->hasPages())
                <div class="pt-2">
                    {{ $users->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
