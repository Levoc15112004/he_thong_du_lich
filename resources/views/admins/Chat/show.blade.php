@extends('admins.master')

@section('title', 'Chi tiết Phiên Chat & Hỗ trợ Khách hàng')

@section('home')
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-5xl mx-auto space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-2 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200 shrink-0">
                    <i class="fa-regular fa-comments text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-700 to-blue-600">
                        Chat: {{ $session->user->name ?? 'Khách' }}
                    </h4>
                    <p class="text-sm text-slate-500 mt-1 flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-slate-400"></i>
                        {{ $session->user->email ?? 'Không rõ email' }}
                    </p>
                </div>
            </div>

            <a href="{{ route('admin.chat.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-xl transition-all duration-300 shadow-sm group shrink-0">
                <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                <span>Trở lại danh sách</span>
            </a>
        </div>

        {{-- CHAT INTERFACE --}}
        <div class="bg-white/95 backdrop-blur-xl border border-white shadow-2xl shadow-slate-200/60 rounded-3xl overflow-hidden flex flex-col h-[75vh] sm:h-[700px] relative">
            <div class="absolute top-0 right-0 p-40 bg-indigo-50/50 rounded-full blur-3xl opacity-60 -z-10 -translate-y-1/2 translate-x-1/2"></div>
            
            {{-- CHAT HEADER --}}
            <div class="border-b border-slate-100 bg-white/50 px-6 py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 relative z-10 backdrop-blur-md">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-center shrink-0">
                        <i class="fa-regular fa-clock text-slate-400 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Bắt đầu lúc</p>
                        <p class="text-sm font-bold text-slate-700">{{ optional($session->started_at)->format('H:i - d/m/Y') }}</p>
                    </div>
                </div>

                <div>
                    @if ($session->status == 1)
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 border border-emerald-100 rounded-xl shadow-sm">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                            </span>
                            <span class="text-emerald-700 text-xs font-bold leading-none">Đang trực tuyến</span>
                        </div>
                    @else
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl shadow-sm">
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-slate-300"></span>
                            <span class="text-slate-600 text-xs font-bold leading-none">Đã đóng phiên</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- MESSAGES AREA --}}
            <div id="chatBody" class="flex-1 overflow-y-auto px-4 sm:px-6 py-8 space-y-6 bg-slate-50/50 relative z-10 smooth-scroll">
                
                <div class="text-center mb-8">
                    <span class="inline-block px-4 py-1.5 bg-white border border-slate-200 rounded-full text-[10px] font-bold text-slate-400 shadow-sm">Phiên chat bắt đầu</span>
                </div>

                @forelse($messages as $message)
                    
                    {{-- GIAO DIỆN TIN NHẮN KHÁCH HÀNG (TRÁI) --}}
                    @if ($message->sender_type === 'user')
                        <div class="flex items-start gap-3 justify-start max-w-3xl group/msg">
                            <div class="w-10 h-10 rounded-full bg-emerald-100/50 border-2 border-white shadow-sm flex items-center justify-center shrink-0 mt-auto mb-5">
                                <i class="fa-solid fa-user text-emerald-500 text-sm"></i>
                            </div>
                            <div>
                                <div class="bg-white border border-slate-100 text-slate-700 px-5 py-3 rounded-2xl rounded-bl-sm shadow-sm text-[15px] leading-relaxed max-w-lg mb-1 float-left break-words">
                                    {{ $message->message }}
                                </div>
                                <div class="clear-both"></div>
                                <p class="text-[10px] font-bold text-slate-400 pl-1 opacity-0 group-hover/msg:opacity-100 transition-opacity">
                                    {{ $message->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @endif


                    {{-- GIAO DIỆN TIN NHẮN BOT / ADMIN (PHẢI) --}}
                    @if (in_array($message->sender_type, ['bot', 'admin']))
                        <div class="flex items-start gap-3 justify-end group/msg">
                            <div class="max-w-lg flex flex-col items-end">
                                
                                @if ($message->sender_type === 'bot')
                                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white px-5 py-3 rounded-2xl rounded-br-sm shadow-md shadow-indigo-200/50 text-[15px] leading-relaxed mb-1 text-left break-words">
                                        {!! nl2br(e($message->message)) !!}
                                    </div>
                                    <p class="text-[10px] font-bold text-indigo-200 pr-1 flex items-center gap-1 opacity-0 group-hover/msg:opacity-100 transition-opacity">
                                        <i class="fa-solid fa-robot text-[9px]"></i> Trả lời tự động lúc {{ $message->created_at->format('H:i') }}
                                    </p>
                                @else
                                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-3 rounded-2xl rounded-br-sm shadow-md shadow-blue-200/50 text-[15px] leading-relaxed mb-1 text-left break-words">
                                        {{ $message->message }}
                                    </div>
                                    <p class="text-[10px] font-bold text-blue-300 pr-1 flex items-center gap-1 opacity-0 group-hover/msg:opacity-100 transition-opacity">
                                        <i class="fa-solid fa-user-tie text-[9px]"></i> Quản trị viên lúc {{ $message->created_at->format('H:i') }}
                                    </p>
                                @endif

                            </div>
                            
                            {{-- Bot Avatar --}}
                            @if ($message->sender_type === 'bot')
                                <div class="w-10 h-10 rounded-full bg-indigo-50 border-2 border-white shadow-sm flex items-center justify-center shrink-0 overflow-hidden mt-auto mb-5 p-1">
                                    <img src="{{ asset('fontend/img/ai_avatar_light.png') }}" class="w-full h-full object-contain rounded-full" alt="AI">
                                </div>
                            @endif

                            {{-- Admin Avatar --}}
                            @if ($message->sender_type === 'admin')
                                <div class="w-10 h-10 rounded-full bg-blue-100 border-2 border-white shadow-sm flex items-center justify-center shrink-0 mt-auto mb-5">
                                    <i class="fa-solid fa-user-shield text-blue-600 text-sm"></i>
                                </div>
                            @endif
                        </div>
                    @endif

                @empty
                    <div class="flex flex-col items-center justify-center h-full text-slate-400">
                        <i class="fa-regular fa-comments text-5xl mb-4 opacity-50"></i>
                        <p class="text-sm font-medium">Chưa có tin nhắn nào trong phiên này.</p>
                    </div>
                @endforelse

            </div>

            {{-- CHAT FOOTER ACTIONS --}}
            <div class="border-t border-slate-100 bg-white px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 relative z-10">
                <div class="text-sm font-medium">
                    <span class="text-slate-500 mr-2">Tình trạng:</span>
                    @if ($session->status == 1)
                        <span class="text-emerald-500 font-bold"><i class="fa-solid fa-lock-open mr-1"></i> Có thể tiếp nhận</span>
                    @else
                        <span class="text-slate-400 font-bold"><i class="fa-solid fa-lock mr-1"></i> Hội thoại đã khóa</span>
                    @endif
                </div>

                @if ($session->status == 1)
                    <form action="{{ route('admin.chat.end', $session->id) }}" method="POST"
                        onsubmit="return confirm('Khách hàng sẽ không thể tiếp tục gửi tin sau khi bạn kết thúc phiên. Khóa phiên chat này?')"
                        class="w-full sm:w-auto">
                        @csrf
                        <button class="w-full sm:w-auto px-6 py-2.5 bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white rounded-xl font-bold transition-colors flex items-center justify-center gap-2 border border-rose-100">
                            <i class="fa-solid fa-ban"></i> Đóng phiên hỗ trợ
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</div>

<style>
    /* Custom scrollbar for chat area */
    .smooth-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .smooth-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .smooth-scroll::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 10px;
    }
</style>

<script>
    // Smooth auto-scroll to bottom of chat
    const chatBody = document.getElementById('chatBody');
    if(chatBody) {
        setTimeout(() => {
            chatBody.scrollTo({
                top: chatBody.scrollHeight,
                behavior: 'smooth'
            });
        }, 100);
    }
</script>
@endsection
