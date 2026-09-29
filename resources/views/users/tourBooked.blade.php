@extends('users.master')

@section('home')
    <div class="relative pt-24 overflow-hidden">

        <main class="max-w-7xl mx-auto  sm:px-6 lg:px-8 ">

            {{-- THÔNG BÁO --}}
            @if (session('success'))
                <div class="mb-6 flex items-center rounded-lg border border-green-300 bg-green-100 px-6 py-4 text-green-800">
                    <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 flex items-center rounded-lg border border-red-300 bg-red-100 px-6 py-4 text-red-800">
                    <svg class="w-5 h-5 mr-3 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif


            <h1 class="text-2xl font-bold text-gray-800 mb-10 flex items-center">
                <i data-lucide="shopping-cart" class="w-9 h-9 mr-4 text-cyan-500"></i>
                Giỏ Hàng Của Bạn
                <span class="ml-3 text-sm font-medium text-gray-500">
                    ({{ $orders->count() }} Tour đã đặt)
                </span>
            </h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                <section class="lg:col-span-2 max-h-[75vh] overflow-y-auto pr-3 custom-scrollbar space-y-4">

                    @foreach ($orders as $order)
                        @php
                            $payment = $order->paymentInfo;
                            $tour = $order->tour;
                        @endphp

                        <div class="bg-white p-4 rounded-3xl soft-shadow border border-indigo-100">

                            <div class="flex flex-col md:flex-row gap-5">

                                <!-- ẢNH TOUR -->
                                <div class="flex-shrink-0">
                                    <img src="{{ $tour->image ?? 'https://placehold.co/150x150' }}"
                                        alt="{{ $tour->title }}"
                                        class="w-full h-40 md:w-40 md:h-40 object-cover rounded-2xl border-2 border-indigo-100">
                                </div>

                                <!-- THÔNG TIN TOUR -->
                                <div class="flex-grow">

                                    <div class="flex justify-between items-start">
                                        <h2 class="text-lg font-bold text-gray-800">
                                            {{ $tour->name }}
                                        </h2>

                                        <!-- TRẠNG THÁI THANH TOÁN -->
                                        @if ($order->status == 2 || $order->status == 3 || $order->status == 4)
                                            <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">
                                                ĐÃ THANH TOÁN
                                            </span>
                                        @elseif ($order->status == 1)
                                            <span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full">
                                                CẦN THANH TOÁN
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full">
                                                CHƯA THANH TOÁN
                                            </span>
                                        @endif
                                    </div>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Mã đặt chỗ:
                                        <span class="font-mono text-gray-700">#{{ $order->id }}</span>
                                    </p>

                                    <!-- Chi tiết -->
                                    <div class="mt-4 grid grid-cols-2 gap-y-1 gap-x-8 text-sm">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <i data-lucide="calendar-check" class="w-4 h-4 mr-2 text-indigo-500"></i>
                                            Khởi hành:
                                            <span class="font-medium ml-1">
                                                {{ date('d/m/Y', strtotime($tour->start_date)) }}
                                            </span>
                                        </div>

                                        <div class="flex items-center text-sm text-gray-600">
                                            <i data-lucide="user-plus" class="w-4 h-4 mr-2 text-indigo-500"></i>
                                            Số lượng:
                                            <span class="font-medium ml-1">
                                                {{ $order->quantity }} khách
                                            </span>
                                        </div>

                                        <div class="flex items-center text-sm text-gray-600 mt-1">
                                            <i data-lucide="receipt-text" class="w-4 h-4 mr-2 text-indigo-500"></i>
                                            Tổng giá:
                                            <span class="font-bold ml-1">
                                                {{ number_format($payment['total_price']) }}₫
                                            </span>
                                        </div>

                                        @if ($order->status >= 1)
                                            <div class="flex items-center text-sm text-gray-600 mt-1">
                                                <i data-lucide="wallet" class="w-4 h-4 mr-2 text-green-500"></i>
                                                Đã cọc:
                                                <span class="font-bold ml-1 text-green-600">
                                                    {{ number_format($payment['deposit_paid'] > 0 ? $payment['deposit_paid'] : $payment['total_price'] * 0.3) }}₫
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <!-- FOOTER -->
                            <div class="mt-2 pt-4 border-t border-gray-100 flex justify-between items-center">

                                <div class="text-sm font-bold text-gray-800">
                                    @if ($order->status < 2)
                                        Còn lại:
                                        <span class="text-red-600">
                                            @php
                                                $paid_amount = $payment['total_paid'] > 0 ? $payment['total_paid'] : ($order->status == 1 ? $payment['total_price'] * 0.3 : 0);
                                            @endphp
                                            {{ number_format($payment['total_price'] - $paid_amount) }}₫
                                        </span>
                                    @else
                                        <span class="text-green-600">Đã thanh toán đủ</span>
                                    @endif
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <button onclick="openItineraryModal({{ $order->id }})"
                                        class="flex items-center justify-center px-4 py-2 bg-white hover:bg-gray-100 text-indigo-600 text-sm font-bold rounded-xl transition border border-indigo-200 shadow-sm">
                                        <i data-lucide="route" class="w-4 h-4 mr-2"></i>
                                        Xem Lịch Trình & Bản Đồ
                                    </button>

                                    <form action="{{ route('order.cancel', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn chắc chắn muốn hủy tour? Nếu đã thanh toán, tiền sẽ được hoàn lại.')">

                                        @csrf

                                        <button type="submit"
                                            class="flex items-center justify-center px-4 py-2
                                        bg-red-50 hover:bg-red-100
                                        text-red-600 text-sm font-bold
                                        rounded-xl transition
                                        border border-red-200 shadow-sm">

                                            <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                                            Hủy Tour
                                        </button>
                                    </form>

                                    {{-- CHƯA THANH TOÁN GÌ → CỌC 30% --}}
                                    @if ($order->status == 0)
                                        <a href="{{ route('user.tour.deposit', $order->id) }}"
                                            class="flex items-center justify-center px-5 py-2
                                            text-white text-sm font-bold rounded-xl
                                            transition bg-gradient-to-r from-orange-400 to-orange-600 hover:opacity-90">
                                            Thanh toán cọc 30%
                                        </a>

                                        {{-- ĐÃ CỌC → THANH TOÁN PHẦN CÒN LẠI --}}
                                    @elseif ($order->status == 1)
                                        <a href="{{ route('user.payment.final', $order->id) }}"
                                            class="flex items-center justify-center px-5 py-2
                                        text-white text-sm font-bold rounded-xl
                                        transition bg-gradient-to-r from-teal-400 to-blue-500 text-white">
                                            Thanh toán phần còn lại
                                        </a>
                                    @endif

                                </div>
                            </div>

                        </div>
                    @endforeach

                </section>

                <!-- ========== CỘT PHẢI – TỔNG KẾT GIỎ HÀNG ========== -->
                <aside>
                    <div
                        class="bg-white p-6 rounded-3xl shadow-xl border border-slate-100
               sticky top-10 space-y-6">

                        <!-- TITLE -->
                        <h3 class="text-xl font-bold text-gray-800 flex items-center gap-3">
                            <i class="fa-solid fa-cart-shopping text-indigo-600"></i>
                            Tổng kết giỏ hàng
                        </h3>

                        <!-- SUMMARY -->
                        <div class="space-y-4 text-sm">

                            <div class="flex justify-between items-center text-gray-600">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-user text-gray-400"></i>
                                    Khách hàng
                                </span>
                                <span class="font-bold text-gray-800">
                                    {{ $user->name }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center text-gray-600">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-suitcase-rolling text-gray-400"></i>
                                    Tổng số đơn
                                </span>
                                <span class="font-semibold text-gray-800">
                                    {{ $orders->count() }} tour
                                </span>
                            </div>

                            <div class="flex justify-between items-center text-gray-600">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-receipt text-gray-400"></i>
                                    Tổng giá trị
                                </span>
                                <span class="font-semibold text-gray-800">
                                    {{ number_format($total_price_all) }}₫
                                </span>
                            </div>

                            <!-- PAID -->
                            <div class="flex justify-between items-center bg-emerald-50 p-3 rounded-xl">
                                <span class="flex items-center gap-2 text-emerald-700 font-medium">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Đã thanh toán
                                </span>
                                <span class="font-bold text-emerald-700">
                                    {{ number_format($total_paid_all) }}₫
                                </span>
                            </div>

                            <!-- REMAIN -->
                            <div
                                class="flex justify-between items-center bg-red-50 p-4 rounded-xl
                       border border-red-100">
                                <span class="flex items-center gap-2 text-red-600 font-semibold">
                                    <i class="fa-solid fa-wallet"></i>
                                    Chưa thanh toán
                                </span>
                                <span class="text-xl font-bold text-red-600">
                                    {{ number_format($total_remaining_all) }}₫
                                </span>
                            </div>

                        </div>

                        <!-- SUPPORT -->
                        <div class="pt-5 border-t border-slate-100 space-y-4">

                            <h4 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <i class="fa-solid fa-headset text-cyan-500"></i>
                                Hỗ trợ khách hàng
                            </h4>

                            <div class="space-y-2 text-sm text-gray-600">

                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-phone text-indigo-500"></i>
                                    <span>
                                        Hotline:
                                        <span class="font-semibold text-indigo-600">
                                            1900 123 456
                                        </span>
                                    </span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-envelope text-indigo-500"></i>
                                    <span>
                                        Email:
                                        <span class="font-semibold text-indigo-600">
                                            travelgo@gmail.com
                                        </span>
                                    </span>
                                </div>

                            </div>

                        </div>

                    </div>
                </aside>


            </div>


            <!-- ITINERARY MODAL -->
            <div id="itineraryModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60">

                <!-- MODAL WRAPPER -->
                <div id="modalContent"
                    class="bg-white w-full max-w-6xl mx-4 rounded-3xl shadow-2xl
                max-h-[80vh] flex flex-col
                transform scale-95 opacity-0 transition-all duration-300">

                    <!-- HEADER -->
                    <div class="flex items-center justify-between p-6 border-b shrink-0">
                        <h3 class="text-2xl font-extrabold text-indigo-600 flex items-center gap-3">
                            <i class="fa-solid fa-route"></i>
                            Lịch Trình Chi Tiết Tour
                        </h3>

                        <button onclick="closeItineraryModal()"
                            class="w-10 h-10 flex items-center justify-center
                           rounded-full text-gray-500 hover:text-red-500
                           hover:bg-red-50 transition">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>

                    <!-- CONTENT -->
                    <div class="flex-1 p-6 overflow-hidden">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 h-full">

                            <!-- LEFT: TIMELINE -->
                            <div id="itineraryTimeline"
                                class="relative space-y-8 overflow-y-auto pr-4
                            max-h-[calc(80vh-180px)]
                            max-w-[520px] mx-auto
                            custom-scrollbar">
                            </div>

                            <!-- RIGHT: MAP -->
                            <div class="relative">
                                <div
                                    class="sticky top-4 h-[24rem] rounded-2xl overflow-hidden
                                border border-gray-200 bg-white shadow">

                                    <iframe id="googleMapFrame" class="w-full h-full border-0" loading="lazy"></iframe>

                                    <!-- DIRECTION BUTTON -->
                                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2">
                                        <a id="directionsButton" target="_blank"
                                            class="flex items-center gap-2 px-5 py-2.5
                                      bg-indigo-600 hover:bg-indigo-700
                                      text-white font-bold rounded-full shadow-lg transition">
                                            <i class="fa-solid fa-location-arrow"></i>
                                            Mở chỉ đường
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- FOOTER -->
                    <div class="p-5 border-t text-right shrink-0">
                        <button onclick="closeItineraryModal()"
                            class="px-6 py-2 rounded-xl font-semibold
                           bg-gray-200 hover:bg-gray-300 text-gray-700 transition">
                            <i class="fa-solid fa-circle-xmark mr-1"></i>
                            Đóng
                        </button>
                    </div>

                </div>
            </div>



        </main>
    </div>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8fafc;
        }

        .text-gradient {
            background: linear-gradient(to right, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .tour-item-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tour-item-card:hover {
            transform: translateX(8px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
    </style>


    <script>
        const modal = document.getElementById('itineraryModal');
        const modalContent = document.getElementById('modalContent');
        const timeline = document.getElementById('itineraryTimeline');
        const mapFrame = document.getElementById('googleMapFrame');
        const directionsBtn = document.getElementById('directionsButton');

        let currentLocation = null;

        function openItineraryModal(orderId) {
            fetch(`/my-tours/schedule/${orderId}/json`)
                .then(res => res.json())
                .then(data => {
                    renderTimeline(data.schedules);
                    showModal();
                });
        }

        function renderTimeline(schedules) {
            timeline.innerHTML = '';
            schedules.forEach((item, index) => {
                const div = document.createElement('div');
                div.className =
                    `p-6 rounded-3xl border border-slate-100 transition-all duration-300 cursor-pointer hover:bg-blue-50/50 group ${index === 0 ? 'bg-blue-50/30 border-blue-100' : 'bg-white'}`;
                div.innerHTML = `
                <div class="flex gap-4">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-white flex items-center justify-center text-blue-600 font-bold shadow-sm group-hover:scale-110 transition">
                        ${item.day_number}
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">${item.title}</h4>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium mb-3">${item.description}</p>
                        ${item.location_name ? `
                                    <span class="inline-flex items-center gap-2 text-[10px] font-bold uppercase text-blue-600 bg-white px-3 py-1.5 rounded-lg shadow-sm">
                                        <i class="fas fa-location-dot"></i> ${item.location_name}
                                    </span>
                                ` : ''}
                    </div>
                </div>
            `;
                div.onclick = () => {
                    document.querySelectorAll('#itineraryTimeline > div').forEach(d => d.classList.replace(
                        'bg-blue-50/30', 'bg-white'));
                    div.classList.replace('bg-white', 'bg-blue-50/30');
                    loadMap(item.latitude, item.longitude);
                };
                timeline.appendChild(div);
                if (index === 0) loadMap(item.latitude, item.longitude);
            });
        }

        function loadMap(lat, lng) {
            mapFrame.src = `https://www.google.com/maps?q=${lat},${lng}&output=embed`;
            directionsBtn.href = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;
        }

        function showModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeItineraryModal() {
            modalContent.classList.replace('scale-100', 'scale-95');
            modalContent.classList.replace('opacity-100', 'opacity-0');
            setTimeout(() => {
                modal.classList.replace('flex', 'hidden');
            }, 500);
        }
    </script>
@endsection
