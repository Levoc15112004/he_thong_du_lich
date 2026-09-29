@extends("admins.master")

@section("title", "Quản lý Đánh giá Tour")

@section("home")
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-[120rem] mx-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-4 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-lg shadow-amber-200 shrink-0">
                    <i class="fa-solid fa-star text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-amber-700 to-orange-600">
                        Quản lý Đánh giá Tour
                    </h4>
                    <p class="text-sm text-slate-500 mt-1">Xem phản hồi và đánh giá từ khách hàng</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl shadow-sm flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-comment-dots"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Tổng Đánh Giá</p>
                        <p class="text-sm font-bold text-slate-800">{{ $reviews->total() }} Lượt</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ALERTS --}}
        @if(session("success"))
            <div class="bg-emerald-50/80 backdrop-blur-sm border border-emerald-200 text-emerald-800 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                    <i class="fa-solid fa-check"></i>
                </div>
                <span class="text-sm font-medium">{{ session("success") }}</span>
            </div>
        @endif

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="py-4 px-6">ID</th>
                            <th class="py-4 px-6">Khách hàng</th>
                            <th class="py-4 px-6">Đơn hàng / Tour</th>
                            <th class="py-4 px-6">Điểm đánh giá</th>
                            <th class="py-4 px-6">Bình luận</th>
                            <th class="py-4 px-6">Ngày gửi</th>
                            <th class="py-4 px-6 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($reviews as $rev)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-6 font-semibold text-slate-800">#{{ $rev->id }}</td>
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-900">{{ $rev->user->name ?? "Khách vãng lai" }}</div>
                                    <div class="text-xs text-slate-500">{{ $rev->user->email ?? "" }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($rev->order && $rev->order->tour)
                                        <span class="font-medium text-slate-800 line-clamp-1">{{ $rev->order->tour->name }}</span>
                                        <span class="text-xs text-slate-500">Đơn #{{ $rev->order_id }}</span>
                                    @else
                                        <span class="text-xs text-slate-400">Đơn hàng #{{ $rev->order_id }}</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-1 text-amber-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $rev->rating)
                                                <i class="fa-solid fa-star text-xs"></i>
                                            @else
                                                <i class="fa-regular fa-star text-xs text-slate-300"></i>
                                            @endif
                                        @endfor
                                        <span class="ml-1 text-xs font-bold text-slate-700">({{ $rev->rating }}/5)</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 max-w-xs text-slate-600">
                                    <p class="line-clamp-2">{{ $rev->comment }}</p>
                                </td>
                                <td class="py-4 px-6 text-slate-500 text-xs">
                                    {{ $rev->created_at ? $rev->created_at->format("d/m/Y H:i") : "N/A" }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <form action="{{ route("reviews.destroy", $rev->id) }}" method="POST" onsubmit="return confirm("Bạn có chắc chắn muốn xóa đánh giá này?");" class="inline-block">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition-colors">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400">
                                    <i class="fa-solid fa-star text-4xl mb-3 text-slate-300 block"></i>
                                    Chưa có đánh giá nào từ khách hàng
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($reviews->hasPages())
                <div class="p-6 border-t border-slate-100">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
