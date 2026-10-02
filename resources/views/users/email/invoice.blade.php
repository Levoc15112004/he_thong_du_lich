<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hóa đơn thanh toán</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Roboto', Arial, sans-serif; background:#f5f5f5; padding:20px">

<div style="max-width:700px; margin:auto; background:#fff; padding:20px; border-radius:8px">

    <h2 style="text-align:center;">HÓA ĐƠN THANH TOÁN</h2>

    <p><strong>Ngày:</strong> {{ now()->format('d/m/Y') }}</p>

    <hr>

    <h3>Thông tin khách hàng</h3>
    <p><strong>Họ tên:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>SĐT:</strong> {{ $order->phone ?? '---' }}</p>

    <hr>

    <h3>Thông tin tour</h3>
    <p><strong>Tên tour:</strong> {{ $tour->name }}</p>
    <p><strong>Điểm đi:</strong> {{ $tour->start_location }}</p>
    <p><strong>Điểm đến:</strong> {{ $tour->end_location }}</p>
    <p><strong>Ngày khởi hành:</strong> {{ $tour->start_date }}</p>
    <p><strong>Thời gian:</strong> {{ $tour->time }} ngày</p>

    <hr>

    <table width="100%" border="1" cellspacing="0" cellpadding="8" style="border-collapse: collapse;">
        <thead style="background:#eee">
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
                <td align="center">1</td>
                <td>{{ $tour->name }}</td>
                <td align="center">1</td>
                <td>{{ number_format($tour->sale_price) }}đ</td>
                <td>{{ number_format($order->total_price) }}đ</td>
            </tr>
        </tbody>
    </table>

    <h3 style="text-align:right; margin-top:20px;">
        Tổng thanh toán: {{ number_format($order->total_price) }}đ
    </h3>

    <p style="color:green;">✔ Đã thanh toán thành công</p>

    <hr>

    <p style="text-align:center;">
        Cảm ơn quý khách đã sử dụng dịch vụ của <strong>WanderVibe</strong><br>
        Hotline: 0123 456 789 | Email: travelgo@gmail.com
    </p>

</div>

</body>
</html>
