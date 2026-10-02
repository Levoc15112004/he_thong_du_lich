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

                                        @php
                                            $bookedTransport = null;
                                            if ($order->note && preg_match('/\[Phương tiện:\s*([^\]|]+)/u', $order->note, $tm)) {
                                                $bookedTransport = trim($tm[1]);
                                            }
                                        @endphp
                                        @if($bookedTransport)
                                            <div class="flex items-center text-sm text-gray-600 mt-1">
                                                <i data-lucide="plane" class="w-4 h-4 mr-2 text-indigo-500"></i>
                                                Phương tiện:
                                                <span class="font-medium ml-1 text-slate-800">
                                                    {{ $bookedTransport }}
                                                </span>
                                            </div>
                                        @endif
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

                                    <div id="interactiveMap" class="w-full h-full min-h-[24rem] z-0"></div>

                                    <!-- DIRECTION BUTTON -->
                                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-[1000] w-max">
                                        <a id="directionsButton" target="_blank"
                                            class="flex items-center gap-2 px-5 py-2.5
                                      bg-slate-900/90 hover:bg-slate-900 text-white font-bold rounded-full shadow-lg transition border border-white/20 text-xs sm:text-sm">
                                            <i class="fa-solid fa-route text-emerald-400"></i>
                                            Mở chỉ đường Google Maps
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


    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const modal = document.getElementById('itineraryModal');
        const modalContent = document.getElementById('modalContent');
        const timeline = document.getElementById('itineraryTimeline');
        const directionsBtn = document.getElementById('directionsButton');

        let leafletMap = null, markersGroup = null, polylineRoute = null;

        function openItineraryModal(orderId) {
            showModal();
            timeline.innerHTML = '<div class="text-center py-10 text-slate-400"><i class="fa-solid fa-spinner fa-spin text-xl mr-2 text-indigo-500"></i> Đang tải dữ liệu...</div>';

            fetch(`/my-tours/schedule/${orderId}/json`)
                .then(res => res.json())
                .then(data => {
                    renderTimeline(data.schedules);
                    initBookedMap(data.schedules, data.center);
                })
                .catch(err => {
                    timeline.innerHTML = '<div class="text-center py-8 text-rose-500 font-semibold text-xs">Không thể tải lịch trình. Vui lòng thử lại!</div>';
                });
        }

        function renderTimeline(schedules) {
            timeline.innerHTML = '';
            if (!schedules || schedules.length === 0) {
                timeline.innerHTML = '<div class="text-center py-8 text-slate-400 text-xs">Chưa có lịch trình chi tiết.</div>';
                return;
            }

            schedules.forEach((item, index) => {
                const div = document.createElement('div');
                div.className =
                    `p-4 rounded-2xl border transition-all cursor-pointer ${index === 0 ? 'bg-indigo-50/70 border-indigo-300 shadow-sm' : 'bg-white border-slate-200 hover:border-indigo-200 hover:bg-slate-50'}`;
                div.innerHTML = `
                <div class="flex gap-3">
                    <div class="w-8 h-8 shrink-0 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                        ${item.day_number}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-bold text-slate-900 mb-1 line-clamp-1">${item.title}</h4>
                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 mb-2">${item.description || ''}</p>
                        ${item.location_name ? `
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-indigo-700 bg-indigo-100/60 px-2 py-0.5 rounded-md">
                                <i class="fas fa-location-dot"></i> ${item.location_name}
                            </span>
                        ` : ''}
                    </div>
                </div>
            `;
                div.onclick = () => {
                    document.querySelectorAll('#itineraryTimeline > div').forEach(d => {
                        d.classList.remove('bg-indigo-50/70', 'border-indigo-300', 'shadow-sm');
                        d.classList.add('bg-white', 'border-slate-200');
                    });
                    div.classList.remove('bg-white', 'border-slate-200');
                    div.classList.add('bg-indigo-50/70', 'border-indigo-300', 'shadow-sm');
                    if (leafletMap && item.latitude && item.longitude) {
                        leafletMap.flyTo([item.latitude, item.longitude], 14, { duration: 1 });
                    }
                };
                timeline.appendChild(div);
            });
        }

        function initBookedMap(schedules, defaultCenter) {
            const center = defaultCenter || [16.0544, 108.2022];

            if (!leafletMap) {
                leafletMap = L.map('interactiveMap').setView(center, 12);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap'
                }).addTo(leafletMap);
                markersGroup = L.featureGroup().addTo(leafletMap);
            } else {
                markersGroup.clearLayers();
                if (polylineRoute) {
                    leafletMap.removeLayer(polylineRoute);
                    polylineRoute = null;
                }
            }

            const validPoints = (schedules || []).filter(s => s.latitude && s.longitude);
            const latlngs = [];

            if (validPoints.length > 0) {
                validPoints.forEach(pt => {
                    const latlng = [parseFloat(pt.latitude), parseFloat(pt.longitude)];
                    latlngs.push(latlng);

                    const customIcon = L.divIcon({
                        className: 'custom-map-pin',
                        html: `<div style="background:#4f46e5;color:#fff;font-size:11px;font-weight:800;width:26px;height:26px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(0,0,0,0.35);border:2px solid #fff;">${pt.day_number}</div>`,
                        iconSize: [26, 26],
                        iconAnchor: [13, 13]
                    });

                    const marker = L.marker(latlng, { icon: customIcon }).addTo(markersGroup);
                    marker.bindPopup(`
                        <div style="font-family: inherit; min-width: 170px;">
                            <div style="font-weight: 800; font-size: 12px; color: #1e293b;">Ngày ${pt.day_number}: ${pt.title}</div>
                            <div style="font-size: 11px; color: #4f46e5; font-weight: 600; margin-top: 3px;"><i class="fa-solid fa-location-dot"></i> ${pt.location_name || ''}</div>
                        </div>
                    `);
                });

                if (latlngs.length > 1) {
                    polylineRoute = L.polyline(latlngs, {
                        color: '#4f46e5',
                        weight: 4,
                        opacity: 0.85,
                        dashArray: '6, 8'
                    }).addTo(leafletMap);
                }

                try {
                    leafletMap.fitBounds(markersGroup.getBounds().pad(0.2));
                } catch(e) {
                    leafletMap.setView(latlngs[0], 12);
                }

                const origin = validPoints[0];
                const destination = validPoints[validPoints.length - 1];
                const waypoints = validPoints.slice(1, -1);
                let dirUrl = `https://www.google.com/maps/dir/?api=1&origin=${origin.latitude},${origin.longitude}&destination=${destination.latitude},${destination.longitude}`;
                if (waypoints.length > 0) {
                    dirUrl += `&waypoints=${waypoints.map(w => `${w.latitude},${w.longitude}`).join('%7C')}`;
                }
                directionsBtn.href = dirUrl;
            } else {
                leafletMap.setView(center, 12);
                directionsBtn.href = `https://www.google.com/maps/search/?api=1&query=${center[0]},${center[1]}`;
            }

            setTimeout(() => { if (leafletMap) leafletMap.invalidateSize(); }, 300);
        }

        function showModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
                if (leafletMap) leafletMap.invalidateSize();
            }, 50);
        }

        function closeItineraryModal() {
            modalContent.classList.replace('scale-100', 'scale-95');
            modalContent.classList.replace('opacity-100', 'opacity-0');
            setTimeout(() => {
                modal.classList.replace('flex', 'hidden');
            }, 250);
        }
    </script>
@endsection
