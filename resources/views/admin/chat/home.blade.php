@extends('admin.master')

@section('content')
    <!-- CSS & JS dành riêng cho chức năng Modal -->
    <style>
        .modal { transition: opacity 0.25s ease; }
        body.modal-active { overflow-x: hidden; overflow-y: hidden !important; }

        /* Tùy chỉnh thanh cuộn cho khu vực hiển thị chat */
        .chat-scroll::-webkit-scrollbar { width: 6px; }
        .chat-scroll::-webkit-scrollbar-track { background: transparent; }
        .chat-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
    </style>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative">

        <!-- Header Topbar -->
        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 hidden md:flex flex-shrink-0">
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Quản Lý Giao Tiếp & Hỗ Trợ Chatbot</h2>
            </div>

            <div class="flex items-center space-x-4">
                <button class="w-10 h-10 rounded-full bg-gray-50 text-gray-500 flex items-center justify-center hover:bg-gray-100 hover:text-primary transition-colors relative">
                    <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
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
            <div class="block">

                <!-- Toolbar: Search & Filters -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                    <div class="flex flex-col sm:flex-row gap-3 flex-1">
                        <div class="relative w-full sm:w-80">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" placeholder="Tìm theo Session ID, Tên người dùng..." class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm text-dark focus:outline-none focus:border-primary admin-input transition-all">
                        </div>
                        <select class="bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-600 focus:outline-none focus:border-primary admin-input transition-all w-full sm:w-auto">
                            <option value="">Ngày tạo (Mới nhất)</option>
                            <option value="">Tuần này</option>
                            <option value="">Tháng này</option>
                        </select>
                        <select class="bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-600 focus:outline-none focus:border-primary admin-input transition-all w-full sm:w-auto">
                            <option value="">Trạng thái Chat</option>
                            <option value="1">Đang tương tác (Live)</option>
                            <option value="0">Đã kết thúc (Ended)</option>
                        </select>
                    </div>

                    <button class="bg-dark text-white font-medium px-5 py-2.5 rounded-xl hover:bg-gray-800 flex items-center transition-colors shadow-soft">
                        <i class="fa-solid fa-robot mr-2 text-primary"></i> Cấu Hình Bot Tư Vấn
                    </button>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[900px]">
                            <thead>
                                <tr class="bg-gray-50/80 text-xs uppercase text-gray-500 font-bold tracking-wider border-b border-gray-100">
                                    <th class="py-4 px-6 w-16 text-center">ID</th>
                                    <th class="py-4 px-6">Phiên Chat (Session & User)</th>
                                    <th class="py-4 px-6">Bắt đầu lúc (Started)</th>
                                    <th class="py-4 px-6">Kết thúc lúc (Ended)</th>
                                    <th class="py-4 px-6 text-center">Tình Trạng (Status)</th>
                                    <th class="py-4 px-6 text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">

                                @forelse($chats as $item)
                                <tr class="hover:bg-sky-50/30 transition-colors group">
                                    <td class="py-4 px-6 text-center text-gray-400 font-medium">#{{ $item->id }}</td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            @if($item->user)
                                            <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center font-bold mr-3 shadow-sm border-2 border-white">
                                                {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-dark text-sm mb-0.5 group-hover:text-primary transition-colors">{{ $item->user->name }}</p>
                                                <p class="text-[10px] text-gray-400 font-mono">Sess: {{ Str::limit($item->session, 10, '') }}</p>
                                            </div>
                                            @else
                                            <div class="w-10 h-10 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mr-3 shadow-sm border-2 border-white">
                                                <i class="fa-solid fa-user-secret"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-600 text-sm mb-0.5 italic">Khách vãng lai (Guest)</p>
                                                <p class="text-[10px] text-gray-400 font-mono">Sess: {{ Str::limit($item->session, 10, '') }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="text-xs text-dark font-medium">{{ \Carbon\Carbon::parse($item->started_at)->format('d/m/Y - h:i') }}<span class="lowercase">{{ \Carbon\Carbon::parse($item->started_at)->format('A') }}</span></span>
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($item->ended_at)
                                        <span class="text-xs text-dark font-medium text-gray-500">{{ \Carbon\Carbon::parse($item->ended_at)->format('d/m/Y - h:i') }}<span class="lowercase">{{ \Carbon\Carbon::parse($item->ended_at)->format('A') }}</span></span>
                                        @else
                                        <span class="text-xs text-gray-400 italic">...</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($item->status == 1)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 inline-block"></span> Đang tương tác
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-500 uppercase">
                                            <i class="fa-solid fa-power-off mr-1"></i> Đã kết thúc
                                        </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button onclick="toggleModal('modal-chat-{{ $item->id }}')" class="bg-gray-100 text-gray-600 hover:text-primary hover:bg-sky-50 font-medium text-xs px-3 py-1.5 rounded-lg transition-colors border border-gray-200">
                                                <i class="fa-regular fa-comment-dots mr-1"></i> Xem Nội Dung
                                            </button>
                                            <a href="{{ route('admin.chat.destroy', $item->id) }}" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors" title="Xóa lịch sử chat" onclick="return confirm('Xóa sạch lịch sử đoạn chat này?');">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-gray-500">
                                        Không có phiên chat nào.
                                    </td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-50 flex items-center justify-between">
                        {{ $chats->links('pagination::tailwind') }}
                    </div>
                </div>

            </div>
        </main>
    </div>

    @foreach($chats as $item)
    <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50 transition-all duration-300" id="modal-chat-{{ $item->id }}">
        <div class="modal-overlay absolute w-full h-full bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('modal-chat-{{ $item->id }}')"></div>

        <div class="modal-container bg-white w-11/12 md:max-w-xl mx-auto rounded-2xl shadow-2xl z-50 flex flex-col h-[80vh] max-h-[700px] transform scale-95 transition-transform duration-300 relative">

            <!-- Header Chat Popup -->
            <div class="flex justify-between items-center p-4 lg:p-5 border-b border-gray-100 bg-gray-50/50 rounded-t-2xl flex-shrink-0">
                <div class="flex items-center">
                    @if($item->user)
                    <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center font-bold mr-3 border-2 border-white relative shadow-sm">
                        {{ strtoupper(substr($item->user->name, 0, 1)) }}
                        <!-- Nếu đang live thì xanh, end rồi thì xám -->
                        <span class="absolute right-0 bottom-0 w-2.5 h-2.5 {{ $item->status == 1 ? 'bg-emerald-500' : 'bg-gray-400' }} border border-white rounded-full"></span>
                    </div>
                    <div>
                        <p class="font-bold text-dark text-base">{{ $item->user->name }}</p>
                        @if($item->status == 1)
                        <p class="text-[11px] text-emerald-600 font-bold uppercase"><i class="fa-solid fa-circle-dot animate-pulse"></i> Đang hỗ trợ</p>
                        @else
                        <p class="text-[11px] text-gray-500 font-bold uppercase"><i class="fa-solid fa-power-off"></i> Đã kết thúc</p>
                        @endif
                    </div>
                    @else
                    <div class="w-10 h-10 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mr-3 border-2 border-white relative shadow-sm">
                        <i class="fa-solid fa-user-secret"></i>
                        <span class="absolute right-0 bottom-0 w-2.5 h-2.5 {{ $item->status == 1 ? 'bg-emerald-500' : 'bg-gray-400' }} border border-white rounded-full"></span>
                    </div>
                    <div>
                        <p class="font-bold text-gray-600 text-base italic">Khách vãng lai</p>
                        @if($item->status == 1)
                        <p class="text-[11px] text-emerald-600 font-bold uppercase"><i class="fa-solid fa-circle-dot animate-pulse"></i> Đang hỗ trợ</p>
                        @else
                        <p class="text-[11px] text-gray-500 font-bold uppercase"><i class="fa-solid fa-power-off"></i> Đã kết thúc</p>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="modal-close cursor-pointer z-50 w-8 h-8 rounded-lg flex justify-center items-center hover:bg-gray-200 transition-colors" onclick="toggleModal('modal-chat-{{ $item->id }}')">
                    <i class="fa-solid fa-xmark text-gray-400 text-lg"></i>
                </div>
            </div>

            <!-- Body Chat Window (Scrollable) -->
            <div class="p-4 lg:p-6 bg-slate-50 flex-1 overflow-y-auto chat-scroll flex flex-col space-y-4">

                <!-- Timeline divider -->
                <div class="flex items-center justify-center mb-2">
                    <span class="text-[10px] text-gray-400 font-bold uppercase bg-white border border-gray-200 px-3 py-1 rounded-full shadow-sm">{{ \Carbon\Carbon::parse($item->started_at)->format('d/m/Y - h:i A') }}</span>
                </div>

                @forelse($item->messages as $msg)
                    @if($msg->sender_type == 'bot' || $msg->sender_type == 'admin')
                    <!-- Bot / Admin Message -->
                    <div class="flex items-start max-w-[85%]">
                        <div class="w-8 h-8 rounded-full {{ $msg->sender_type == 'bot' ? 'bg-sky-100' : 'bg-indigo-100' }} flex-shrink-0 flex items-center justify-center border border-white shadow-sm mr-3">
                            <i class="fa-solid {{ $msg->sender_type == 'bot' ? 'fa-robot text-primary' : 'fa-headset text-indigo-500' }} text-xs"></i>
                        </div>
                        <div>
                            <div class="bg-white border border-gray-200 p-3.5 rounded-2xl rounded-tl-sm text-sm text-dark shadow-sm leading-relaxed">
                                {{ $msg->message }}
                            </div>
                            <p class="text-[10px] text-gray-400 mt-1 ml-1">{{ \Carbon\Carbon::parse($msg->created_at)->format('h:i A') }}</p>
                        </div>
                    </div>
                    @else
                    <!-- User Message -->
                    <div class="flex items-start flex-row-reverse max-w-[85%] self-end">
                        <div class="w-8 h-8 rounded-full bg-orange-100 flex-shrink-0 flex items-center justify-center border border-white shadow-sm ml-3 text-orange-500 font-bold text-xs">
                            {{ $item->user ? strtoupper(substr($item->user->name, 0, 1)) : '?' }}
                        </div>
                        <div>
                            <div class="bg-primary text-white p-3.5 rounded-2xl rounded-tr-sm text-sm shadow-sm shadow-sky-500/20 leading-relaxed">
                                {{ $msg->message }}
                            </div>
                            <p class="text-[10px] text-gray-400 mt-1 mr-1 text-right">{{ \Carbon\Carbon::parse($msg->created_at)->format('h:i A') }}</p>
                        </div>
                    </div>
                    @endif
                @empty
                    <div class="text-center text-gray-400 text-xs italic">Không có tin nhắn nào.</div>
                @endforelse

                @if($item->status == 1)
                <!-- Điểm ngắt Admin đang soi -->
                <div class="flex justify-start w-full">
                    <span class="inline-flex bg-white px-3 py-1.5 rounded-full shadow-sm text-xs border border-gray-100 items-center">
                        <span class="flex space-x-1 mr-2">
                            <span class="w-1 h-1 bg-gray-400 rounded-full animate-bounce"></span>
                            <span class="w-1 h-1 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                            <span class="w-1 h-1 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
                        </span>
                        <span class="text-gray-400 text-[10px] font-bold uppercase">Live Tracking...</span>
                    </span>
                </div>
                @endif
            </div>

            @if($item->status == 1)
            <!-- Block Can thiệp (Take over) -->
            <div class="p-4 bg-white border-t border-gray-100 rounded-b-2xl">
                <div class="flex items-center space-x-3 cursor-pointer hover:bg-orange-100 transition-colors bg-orange-50/50 p-2.5 rounded-xl border border-orange-100 w-full justify-center text-orange-600 text-sm font-medium">
                    <i class="fa-solid fa-headset mr-2"></i> Trả lời trực tiếp ngay (Ngắt Bot)
                </div>
            </div>
            @endif
        </div>
    </div>
    @endforeach

    <!-- Script điều khiển Modal -->
    <script>
        function toggleModal(modalID){
            const modal = document.getElementById(modalID);
            const container = modal.querySelector('.modal-container');

            modal.classList.toggle('opacity-0');
            modal.classList.toggle('pointer-events-none');
            document.body.classList.toggle('modal-active');

            if(!modal.classList.contains('opacity-0')){
                container.classList.remove('scale-95');
                container.classList.add('scale-100');
            } else {
                container.classList.add('scale-95');
                container.classList.remove('scale-100');
            }
        }
    </script>
@endsection
