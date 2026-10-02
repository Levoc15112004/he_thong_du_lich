<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hóa đơn #{{ $order->id }}</title>

    <style>
        body {
            font-family: 'Roboto', 'DejaVu Sans', sans-serif;
            font-size: 13px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #0ea5e9;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            color: #0ea5e9;
        }

        .invoice-info {
            text-align: right;
        }

        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin: 20px 0;
        }

        .info {
            margin-bottom: 15px;
        }

        .info p {
            margin: 3px 0;
        }

        .box {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th {
            background: #f3f4f6;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        .total {
            text-align: right;
            margin-top: 15px;
            font-size: 15px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }

        .status {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">

    {{-- HEADER --}}
    <div class="header">
        <div>
            <img class="logo">WanderVibe</div>
            <p>Website du lịch uy tín</p>
        </div>

        <div class="invoice-info">
            <p><strong>Hóa đơn:</strong> #{{ $order->id }}</p>
            <p><strong>Ngày:</strong> {{ $order->updated_at->format('d/m/Y') }}</p>
        </div>
    </div>

    {{-- TITLE --}}
    <div class="title">HÓA ĐƠN THANH TOÁN</div>

    {{-- CUSTOMER --}}
    <div class="box">
        <strong>Thông tin khách hàng</strong>
        <div class="info">
            <p><strong>Họ tên:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>SĐT:</strong> {{ $order->phone ?? '---' }}</p>
        </div>
    </div>

    {{-- TOUR INFO --}}
    <div class="box">
        <strong>Thông tin tour</strong>
        <div class="info">
            <p><strong>Tên tour:</strong> {{ $tour->name }}</p>
            <p><strong>Điểm đi:</strong> {{ $tour->start_location }}</p>
            <p><strong>Điểm đến:</strong> {{ $tour->end_location }}</p>

            <p>
                <strong>Ngày khởi hành:</strong>
                {{ $tour->start_date?->format('d/m/Y') ?? '---' }}
            </p>

            <p><strong>Thời gian:</strong> {{ $tour->time }}</p>
        </div>
    </div>

    {{-- TABLE --}}
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Nội dung</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>{{ $tour->name }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ number_format($tour->sale_price)}}₫</td>
                <td>{{ number_format($order->total_price) }}₫</td>
            </tr>
        </tbody>
    </table>

    {{-- TOTAL --}}
    <div class="total">
        Tổng thanh toán: {{ number_format($order->total_price) }}₫
    </div>

    {{-- STATUS --}}
    <p class="status">
        ✔ Đã thanh toán thành công
    </p>

    {{-- FOOTER --}}
    <div class="footer">
        Cảm ơn quý khách đã sử dụng dịch vụ của <strong>WanderVibe</strong> ✈️ <br>
        Hotline: 0123 456 789 | Email: travelgo@gmail.com
    </div>

</div>

</body>
</html>
