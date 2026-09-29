<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Voucher Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .sidebar-item:hover {
            background-color: rgba(99, 102, 241, 0.1);
            color: #4f46e5;
        }
        .sidebar-item.active {
            background-color: #4f46e5;
            color: white;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        /* Modal Animation */
        .modal-enter {
            opacity: 0;
            transform: scale(0.95);
        }
        .modal-enter-active {
            opacity: 1;
            transform: scale(1);
            transition: opacity 300ms, transform 300ms;
        }
        /* Checkbox styling */
        .voucher-checkbox:checked + div {
            border-color: #4f46e5;
            background-color: #f5f3ff;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1);
        }
    </style>
</head>
<body class="flex min-h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col shrink-0">
        <div class="p-6">
            <div class="flex items-center gap-3 text-emerald-600 font-bold text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                </svg>
                <span>Vouchify</span>
            </div>
        </div>
        <nav class="flex-1 px-4 space-y-1">
            <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span class="font-medium">Tổng quan</span>
            </a>
            <a href="#" class="sidebar-item active flex items-center gap-3 px-4 py-3 rounded-xl transition-all shadow-lg shadow-emerald-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="font-medium">Quản lý User</span>
            </a>
            <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M11 7h.01M11 11h.01M11 15h.01M15 7h.01M15 11h.01M15 15h.01M19 7h.01M19 11h.01M19 15h.01M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span class="font-medium">Kho Voucher</span>
            </a>
            <div class="pt-10">
                <p class="px-4 text-xs font-semibold text-slate-400  mb-2">Hệ thống</p>
                <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-medium">Cài đặt</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden">

        <!-- Header -->
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
            <div class="flex items-center bg-slate-100 rounded-full px-4 py-2 w-96">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" placeholder="Tìm kiếm nhanh..." class="bg-transparent border-none focus:ring-0 text-sm w-full ml-2 text-slate-600">
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-slate-800">Admin </p>
                        <p class="text-[11px] text-slate-500 ">Quản trị viên</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin+Nguyen&background=4f46e5&color=fff" alt="Avatar" class="w-10 h-10 rounded-xl shadow-sm">
                </div>
            </div>
        </header>

        <!-- Page Content Area -->
        <div class="flex-1 overflow-y-auto p-8 space-y-8">

            <!-- Breadcrumbs & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Quản lý User & Voucher</h1>
                    <p class="text-slate-500 text-sm">Gán cùng lúc nhiều mã giảm giá cho khách hàng.</p>
                </div>
                <div class="flex gap-3">
                    <button onclick="openAssignModal()" class="flex items-center gap-2 bg-emerald-600 text-white px-5 py-2.5 rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-200 font-semibold text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Gán Voucher Mới
                    </button>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Người dùng có Voucher</p>
                        <h3 class="text-2xl font-bold text-slate-800">4,210</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Voucher đã phát</p>
                        <h3 class="text-2xl font-bold text-slate-800">8,590</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Lượt gán trong ngày</p>
                        <h3 class="text-2xl font-bold text-slate-800">124</h3>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-800">Lịch sử gán Voucher</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase font-semibold ">
                                <th class="px-6 py-4">Người dùng</th>
                                <th class="px-6 py-4">Mã Voucher</th>
                                <th class="px-6 py-4">Giá trị</th>
                                <th class="px-6 py-4">Hết hạn</th>
                                <th class="px-6 py-4 text-center">Trạng thái</th>
                                <th class="px-6 py-4 text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody" class="divide-y divide-slate-100">
                            <!-- Rows populated by Script -->
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://i.pravatar.cc/150?u=1" class="w-10 h-10 rounded-full shadow-sm" alt="User">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">Lê Minh Tuấn</p>
                                            <p class="text-xs text-slate-500">tuan.le@example.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-mono text-sm font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded uppercase">SUMMER24</span>
                                </td>
                                <td class="px-6 py-4"><span class="text-sm font-medium text-slate-700">Giảm 50%</span></td>
                                <td class="px-6 py-4"><span class="text-sm text-slate-600">24/12/2024</span></td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 text-[11px] font-bold rounded-full bg-emerald-100 text-emerald-700">ACTIVE</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-slate-400 hover:text-rose-600 p-2 transition"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal: Gán Nhiều Voucher -->
    <div id="assignModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden">
        <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="modalContainer">
            <!-- Modal Header -->
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Gán Voucher cho User</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Bạn có thể chọn một hoặc nhiều mã cùng lúc.</p>
                </div>
                <button onclick="closeAssignModal()" class="text-slate-400 hover:text-slate-600 p-2 hover:bg-white rounded-full transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <form id="assignVoucherForm" class="p-8 space-y-6">
                <!-- Chọn User -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">1. Chọn người dùng mục tiêu</label>
                    <div class="relative">
                        <select id="userSelect" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition outline-none appearance-none">
                            <option value="" disabled selected>Tìm người dùng...</option>
                            <option value="1">Nguyễn Văn A (a@example.com)</option>
                            <option value="2">Trần Thị B (b@example.com)</option>
                            <option value="3">Lê Văn C (c@example.com)</option>
                            <option value="4">Phạm Minh D (d@example.com)</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Chọn Nhiều Voucher -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-sm font-semibold text-slate-700">2. Chọn các mã Voucher áp dụng</label>
                        <span id="selectedCount" class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Đã chọn: 0</span>
                    </div>

                    <!-- Search Voucher In Modal -->
                    <div class="relative mb-4">
                        <input type="text" id="voucherSearch" placeholder="Lọc nhanh mã voucher..." class="w-full bg-slate-100 border-none rounded-lg px-4 py-2 text-xs focus:ring-2 focus:ring-emerald-500 transition outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-3 max-h-48 overflow-y-auto pr-2 custom-scrollbar" id="voucherGrid">
                        <!-- Voucher Item -->
                        <label class="relative block cursor-pointer group">
                            <input type="checkbox" name="voucher_type" value="SUMMER" data-label="SUMMER24" data-val="Giảm 50%" class="voucher-checkbox peer sr-only">
                            <div class="p-4 border border-slate-200 rounded-2xl group-hover:border-emerald-300 transition-all flex flex-col h-full">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded uppercase">SUMMER24</span>
                                    <div class="w-4 h-4 rounded-full border border-slate-300 peer-checked:bg-emerald-600 peer-checked:border-emerald-600 flex items-center justify-center transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 text-white opacity-0 peer-checked:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                </div>
                                <p class="text-sm font-bold text-slate-800">Giảm giá 50%</p>
                                <p class="text-[10px] text-slate-500 mt-1 ">Dành cho đơn từ 200k</p>
                            </div>
                        </label>

                        <label class="relative block cursor-pointer group">
                            <input type="checkbox" name="voucher_type" value="FREESHIP" data-label="SHIP0" data-val="Freeship" class="voucher-checkbox peer sr-only">
                            <div class="p-4 border border-slate-200 rounded-2xl group-hover:border-emerald-300 transition-all flex flex-col h-full">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded uppercase">SHIP0</span>
                                    <div class="w-4 h-4 rounded-full border border-slate-300 peer-checked:bg-emerald-600 peer-checked:border-emerald-600 flex items-center justify-center transition-colors"></div>
                                </div>
                                <p class="text-sm font-bold text-slate-800">Miễn phí giao hàng</p>
                                <p class="text-[10px] text-slate-500 mt-1 ">Tối đa 30k</p>
                            </div>
                        </label>

                        <label class="relative block cursor-pointer group">
                            <input type="checkbox" name="voucher_type" value="NEWBIE" data-label="WELCOME" data-val="Giảm 20k" class="voucher-checkbox peer sr-only">
                            <div class="p-4 border border-slate-200 rounded-2xl group-hover:border-emerald-300 transition-all flex flex-col h-full">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded uppercase">WELCOME</span>
                                    <div class="w-4 h-4 rounded-full border border-slate-300 peer-checked:bg-emerald-600 peer-checked:border-emerald-600 flex items-center justify-center transition-colors"></div>
                                </div>
                                <p class="text-sm font-bold text-slate-800">Quà người mới</p>
                                <p class="text-[10px] text-slate-500 mt-1 ">Giảm trực tiếp 20k</p>
                            </div>
                        </label>

                        <label class="relative block cursor-pointer group">
                            <input type="checkbox" name="voucher_type" value="VIP10" data-label="VIPPRO" data-val="Giảm 10%" class="voucher-checkbox peer sr-only">
                            <div class="p-4 border border-slate-200 rounded-2xl group-hover:border-emerald-300 transition-all flex flex-col h-full">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded uppercase">VIPPRO</span>
                                    <div class="w-4 h-4 rounded-full border border-slate-300 peer-checked:bg-emerald-600 peer-checked:border-emerald-600 flex items-center justify-center transition-colors"></div>
                                </div>
                                <p class="text-sm font-bold text-slate-800">Ưu đãi Hội Viên</p>
                                <p class="text-[10px] text-slate-500 mt-1 ">Không giới hạn đơn</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Thiết lập hạn dùng chung -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Ngày bắt đầu</label>
                        <input type="date" required value="2024-03-20" id="startDate" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Ngày hết hạn chung</label>
                        <input type="date" required value="2024-06-30" id="endDate" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 outline-none transition">
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="closeAssignModal()" class="flex-1 px-6 py-3 border border-slate-200 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 transition">Hủy bỏ</button>
                    <button type="submit" id="btnSubmit" disabled class="flex-1 px-6 py-3 bg-emerald-600 text-white font-bold rounded-2xl hover:bg-emerald-700 shadow-lg shadow-emerald-100 transition disabled:opacity-50 disabled:cursor-not-allowed">Xác nhận gán (0)</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-8 right-8 bg-slate-900 text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-3 transform translate-y-24 transition-all duration-300 opacity-0 z-[60]">
        <div class="bg-emerald-500 p-1 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
        </div>
        <span class="text-sm font-medium" id="toastMessage">Thành công!</span>
    </div>

    <script>
        const assignModal = document.getElementById('assignModal');
        const modalContainer = document.getElementById('modalContainer');
        const assignForm = document.getElementById('assignVoucherForm');
        const voucherCheckboxes = document.querySelectorAll('.voucher-checkbox');
        const selectedCountLabel = document.getElementById('selectedCount');
        const btnSubmit = document.getElementById('btnSubmit');
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toastMessage');

        // Monitor multi-selection
        function updateSelectedCount() {
            const checked = document.querySelectorAll('.voucher-checkbox:checked').length;
            selectedCountLabel.innerText = `Đã chọn: ${checked}`;
            btnSubmit.disabled = checked === 0;
            btnSubmit.innerText = `Xác nhận gán (${checked})`;
        }

        voucherCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateSelectedCount);
        });

        function openAssignModal() {
            assignModal.classList.remove('hidden');
            setTimeout(() => {
                modalContainer.classList.remove('scale-95', 'opacity-0');
            }, 10);
        }

        function closeAssignModal() {
            modalContainer.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                assignModal.classList.add('hidden');
                assignForm.reset();
                updateSelectedCount();
            }, 300);
        }

        function showToast(message) {
            toastMessage.innerText = message;
            toast.classList.remove('translate-y-24', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-24', 'opacity-0');
            }, 3000);
        }

        // Handle Form Submission
        assignForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const userText = document.getElementById('userSelect').options[document.getElementById('userSelect').selectedIndex].text;
            const userName = userText.split('(')[0].trim();
            const checkedVouchers = document.querySelectorAll('.voucher-checkbox:checked');
            const endDate = document.getElementById('endDate').value;

            closeAssignModal();

            setTimeout(() => {
                const tableBody = document.getElementById('userTableBody');

                checkedVouchers.forEach(v => {
                    const label = v.getAttribute('data-label');
                    const value = v.getAttribute('data-val');

                    const newRow = document.createElement('tr');
                    newRow.className = "hover:bg-slate-50/80 transition-colors bg-emerald-50/30";
                    newRow.innerHTML = `
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center font-bold text-emerald-600">${userName.charAt(0)}</div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">${userName}</p>
                                    <p class="text-xs text-slate-500">vừa được gán</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4"><span class="font-mono text-sm font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded uppercase">${label}</span></td>
                        <td class="px-6 py-4"><span class="text-sm font-medium text-slate-700">${value}</span></td>
                        <td class="px-6 py-4"><span class="text-sm text-slate-600">${endDate}</span></td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 text-[11px] font-bold rounded-full bg-emerald-100 text-emerald-700">ACTIVE</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-slate-400 hover:text-rose-600 p-2 transition"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                        </td>
                    `;
                    tableBody.prepend(newRow);
                });

                showToast(`Đã gán thành công ${checkedVouchers.length} Voucher cho ${userName}`);
            }, 400);
        });

        // Voucher Search Logic
        document.getElementById('voucherSearch').addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            const items = document.querySelectorAll('#voucherGrid label');
            items.forEach(item => {
                const text = item.innerText.toLowerCase();
                item.style.display = text.includes(term) ? 'block' : 'none';
            });
        });

        assignModal.addEventListener('click', (e) => {
            if (e.target === assignModal) closeAssignModal();
        });
    </script>
</body>
</html>

