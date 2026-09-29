@extends('users.master')

@section('home')
<div class="min-h-screen bg-gray-50 flex items-center justify-center">

    <div class="max-w-lg w-full bg-white rounded-2xl shadow-xl p-8 text-center">

        <!-- TITLE -->
        <h2 class="text-2xl font-bold text-pink-600 mb-2">
            Thanh toán MoMo bằng QR Code
        </h2>

        <p class="text-gray-600 mb-6">
            Vui lòng mở <span class="font-semibold text-pink-500">ứng dụng MoMo</span> và quét mã bên dưới
        </p>

        <!-- QR CODE -->
        @if(!empty($qrCodeUrl))
            <div class="flex justify-center mb-6">
                <img src="{{ $qrCodeUrl }}"
                     alt="MoMo QR Code"
                     class="w-64 h-64 object-contain border rounded-xl shadow-md">
            </div>
        @else
            <div class="text-red-500 font-semibold mb-6">
                 Không thể tạo mã QR. Vui lòng thử lại.
            </div>
        @endif

        <!-- STATUS -->
        <div class="flex items-center justify-center gap-2 text-gray-600 mb-6">
            <svg class="animate-spin h-5 w-5 text-pink-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
            <span>Đang chờ xác nhận thanh toán…</span>
        </div>

        <!-- NOTE -->
        <div class="text-sm text-gray-500 mb-6">
             Sau khi thanh toán thành công, hệ thống sẽ tự động cập nhật trạng thái đơn hàng.
        </div>

        <!-- ACTION -->
        <div class="flex flex-col gap-3">
            <a href="{{ url()->previous() }}"
               class="inline-block px-6 py-3 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                ⬅ Quay lại
            </a>

            <a href="{{ route('tour.thankyou', request()->route('order') ?? '') }}"
               class="inline-block px-6 py-3 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                Tôi đã thanh toán
            </a>
        </div>

    </div>

</div>

{{-- OPTIONAL: AUTO REFRESH (BẬT NẾU MUỐN) --}}
<script>
    // Tự reload sau 10s để kiểm tra trạng thái (có thể bỏ)
    setTimeout(() => {
        location.reload();
    }, 10000);
</script>
@endsection
