@extends("admins.master")

@section("title", "Quản lý Yêu cầu Tư vấn")

@section("home")
<div class="min-h-screen bg-slate-50 dark:bg-slate-900 px-4 sm:px-6 lg:px-8 py-8 transition-colors duration-200">
    <div class="max-w-[120rem] mx-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-4 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-400 to-rose-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/20 shrink-0">
                    <i class="fa-solid fa-headset text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-orange-600 to-rose-600 dark:from-orange-400 dark:to-rose-400">
                        Yêu Cầu Tư Vấn Khách Hàng
                    </h4>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Danh sách thông tin khách hàng để lại từ form nhận tư vấn nhanh</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3">
                <form action="" method="GET" class="relative w-full sm:w-auto">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Tìm SĐT, tên khách..."
                           class="w-full sm:w-64 pl-10 pr-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                </form>

                <div class="px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-orange-50 dark:bg-orange-950/60 text-orange-600 dark:text-orange-400 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">Tổng yêu cầu</p>
                        <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $consultations->total() }} lượt</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ALERTS --}}
        @if(session("success"))
            <div class="bg-orange-50/90 dark:bg-orange-950/40 border border-orange-200 dark:border-orange-800 text-orange-800 dark:text-orange-200 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-orange-100 dark:bg-orange-900/60 flex items-center justify-center text-orange-600 dark:text-orange-300 shrink-0">
                    <i class="fa-solid fa-check"></i>
                </div>
                <span class="text-sm font-semibold">{{ session("success") }}</span>
            </div>
        @endif

        {{-- TABLE CARD --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            <th class="py-4 px-6">STT</th>
                            <th class="py-4 px-6">Khách hàng</th>
                            <th class="py-4 px-6">Thông tin chi tiết yêu cầu</th>
                            <th class="py-4 px-6">Thời gian gửi</th>
                            <th class="py-4 px-6">Trạng thái</th>
                            <th class="py-4 px-6 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($consultations as $item)
                            <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-700/30 transition-colors {{ $item->status === 'unread' ? 'bg-orange-50/20 dark:bg-orange-950/10' : '' }}">
                                <td class="py-4 px-6 font-mono text-xs text-slate-500">#{{ $item->id }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-xs shrink-0">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <span class="font-bold text-slate-800 dark:text-white text-xs sm:text-sm">
                                            {{ Str::after($item->title, 'mới: ') ?: $item->title }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 max-w-sm">
                                    <div class="bg-slate-50 dark:bg-slate-900/60 p-2.5 rounded-xl border border-slate-100 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-300 leading-relaxed">
                                        {{ $item->message }}
                                    </div>
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap text-xs text-slate-500">
                                    {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : 'Vừa xong' }}
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    @if($item->status === 'unread')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-200">Cần liên hệ</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">Đã tư vấn</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('admin.consultations.toggle', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1 rounded-lg text-xs font-bold {{ $item->status === 'unread' ? 'bg-orange-500 text-white hover:bg-orange-600' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                                {{ $item->status === 'unread' ? 'Đã gọi' : 'Chưa gọi' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.consultations.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Xóa yêu cầu này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white flex items-center justify-center transition-colors">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400 font-medium">Chưa có yêu cầu tư vấn nào từ khách hàng.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($consultations->hasPages())
                <div class="p-6 border-t border-slate-100 dark:border-slate-700">
                    {{ $consultations->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
