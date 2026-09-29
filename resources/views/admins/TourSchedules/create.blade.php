@extends('admins.master')

@section('title', 'Thêm lịch trình Tour')

@section('home')

    {{-- Leaflet & Geocoder CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-5xl mx-auto space-y-8">

            {{-- HEADER --}}
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-teal-200">
                        <i class="fa-solid fa-calendar-plus text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-700 to-emerald-600">
                            Thêm lịch trình mới
                        </h4>
                        <p class="text-sm text-slate-500 mt-1">Xây dựng kế hoạch điểm đến cho Tour du lịch</p>
                    </div>
                </div>

                <a href="{{ route('admin.tour_schedules.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-xl transition-all duration-300 shadow-sm group">
                    <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    <span>Quay lại danh sách</span>
                </a>
            </div>

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="rounded-2xl border border-rose-200 bg-rose-50/50 p-5 backdrop-blur-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
                        <p class="font-semibold text-rose-700 text-base">Vui lòng kiểm tra lại thông tin:</p>
                    </div>
                    <ul class="list-disc list-inside text-rose-600 text-sm space-y-1 ml-7">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM CARD --}}
            <div class="bg-white/90 backdrop-blur-xl border border-white shadow-2xl shadow-slate-200/50 rounded-3xl overflow-hidden relative">
                <div class="absolute top-0 left-0 p-32 bg-emerald-50 rounded-full blur-3xl opacity-60 -z-10 -translate-y-1/2 -translate-x-1/3"></div>
                
                <form action="{{ route('admin.tour_schedules.store') }}" method="POST" enctype="multipart/form-data" class="relative z-10 p-6 sm:p-10 space-y-8">
                    @csrf

                    {{-- ===== THÔNG TIN CHÍNH ===== --}}
                    <section>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                                <i class="fa-solid fa-circle-info text-sm"></i>
                            </div>
                            <h5 class="text-lg font-bold text-slate-800">Thông tin chi tiết</h5>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Chọn tour --}}
                            <div>
                                <label class="block text-slate-700 font-semibold mb-2">
                                    Giải đoạn / Tour <span class="text-rose-500">*</span>
                                </label>
                                <select name="tour_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 cursor-pointer">
                                    <option value="">-- Chọn Tour cần lên lịch --</option>
                                    @foreach ($tours as $tour)
                                        <option value="{{ $tour->id }}" {{ old('tour_id') == $tour->id ? 'selected' : '' }}>
                                            {{ $tour->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Ngày --}}
                            <div>
                                <label class="block text-slate-700 font-semibold mb-2">
                                    Lịch trình Ngày thứ <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 font-medium"><i class="fa-regular fa-sun"></i></span>
                                    <input type="number" min="1" name="day_number" value="{{ old('day_number') }}" placeholder="VD: 1, 2, 3..." class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-12 pr-4 py-3 text-slate-700 font-bold focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300">
                                </div>
                            </div>

                            {{-- Tiêu đề --}}
                            <div class="md:col-span-2">
                                <label class="block text-slate-700 font-semibold mb-2">
                                    Tiêu đề (Hoạt động) <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="title" value="{{ old('title') }}" placeholder="VD: Thăm quan Vịnh Hạ Long, Ăn tối hải sản..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300">
                            </div>

                            {{-- Mô tả --}}
                            <div class="md:col-span-2">
                                <label class="block text-slate-700 font-semibold mb-2">Mô tả chi tiết</label>
                                <textarea name="description" rows="4" placeholder="Nhập mô tả cụ thể về các hoạt động, thời gian chi tiết..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </section>
                    
                    <hr class="border-slate-100">

                    {{-- ===== ĐỊA ĐIỂM BẢN ĐỒ ===== --}}
                    <section>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-8 h-8 rounded-lg bg-pink-50 text-pink-500 flex items-center justify-center">
                                <i class="fa-solid fa-map-location-dot text-sm"></i>
                            </div>
                            <h5 class="text-lg font-bold text-slate-800">Định vị & Bản đồ</h5>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-slate-700 font-semibold mb-2">Tên địa điểm / Khu vực</label>
                                <div class="relative">
                                    <i class="fa-solid fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                    <input type="text" name="location_name" value="{{ old('location_name') }}" placeholder="VD: Bến Cảng, Đèo Mã Pí Lèng..." class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300">
                                </div>
                            </div>
                            <div>
                                <label class="block text-slate-700 font-semibold mb-2">Ảnh minh họa (Tại địa điểm)</label>
                                <label class="flex items-center justify-center w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 cursor-pointer hover:bg-slate-100 transition-colors group">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-upload text-slate-400 group-hover:text-teal-500 transition-colors"></i>
                                        <span class="text-sm font-medium text-slate-600 group-hover:text-teal-600 transition-colors" id="file-name">Tải ảnh lên</span>
                                    </div>
                                    <input type="file" name="image" class="hidden" accept="image/*" onchange="previewImage(event)">
                                </label>
                            </div>
                        </div>
                        
                        <img id="image-preview" class="hidden w-full h-48 md:h-64 object-cover rounded-2xl border border-slate-200 shadow-sm mb-6">

                        {{-- Leaflet Map Box --}}
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="font-semibold text-slate-700 flex items-center gap-2">
                                    <i class="fa-solid fa-earth-asia text-teal-500"></i> Ghim vị trí tọa độ
                                </label>
                                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md">Click trực tiếp hoặc tìm kiếm</span>
                            </div>
                            
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

                            <div class="p-2 bg-white rounded-2xl border border-slate-200 shadow-sm">
                                <div id="map" class="w-full h-[300px] sm:h-[400px] rounded-xl z-0"></div>
                            </div>
                        </div>
                    </section>

                    <hr class="border-slate-100">

                    {{-- SUBMIT --}}
                    <div class="flex flex-col sm:flex-row justify-end gap-4 pt-2">
                        <button type="submit"
                            class="inline-flex justify-center items-center gap-2 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-teal-200/50 hover:shadow-xl hover:shadow-teal-300/50 hover:-translate-y-0.5 transition-all duration-300 text-sm">
                            <i class="fa-solid fa-save text-lg"></i> Lưu lịch trình
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        // Image preview
        function previewImage(event) {
            const file = event.target.files[0];
            const fileNameLabel = document.getElementById('file-name');
            const preview = document.getElementById('image-preview');
            
            if (file) {
                fileNameLabel.textContent = file.name;
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        }

        // Map setup
        const defaultLat = 21.0278;
        const defaultLng = 105.8342;

        const map = L.map('map').setView([defaultLat, defaultLng], 13);

        L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            attribution: '&copy; Google Maps',
            maxZoom: 19
        }).addTo(map);

        const customIcon = L.divIcon({
            html: '<div style="background-color: #ef4444; width: 14px; height: 14px; border-radius: 50%; box-shadow: 0 0 0 8px rgba(239, 68, 68, 0.2), 0 0 0 4px rgba(239, 68, 68, 0.4); margin: 8px;"></div>',
            iconSize: [30, 30],
            iconAnchor: [15, 15],
            className: 'custom-pulse-marker'
        });

        let marker = null;

        function setMarker(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng], { icon: customIcon }).addTo(map);
            }
        }

        map.on('click', function(e) {
            setMarker(e.latlng.lat, e.latlng.lng);
        });

        L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: 'Tìm địa điểm...'
        })
        .on('markgeocode', function(e) {
            const latlng = e.geocode.center;
            map.setView(latlng, 15);
            setMarker(latlng.lat, latlng.lng);
        })
        .addTo(map);

        // Resize fix map issue when initially rendered inside a parent hidden or miscalculated layout
        setTimeout(() => { map.invalidateSize(); }, 300);
    </script>
@endsection
