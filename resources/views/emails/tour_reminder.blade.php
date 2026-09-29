<h2>Xin chào {{ $order->name }}</h2>

<p>Tour <strong>{{ $order->tour->name }}</strong> sẽ khởi hành vào ngày 
<strong>{{ \Carbon\Carbon::parse($order->tour->start_date)->format('d/m/Y') }}</strong>.</p>

<p>Vui lòng chuẩn bị hành lý và đến đúng giờ.</p>

<p>Chúc bạn có chuyến đi vui vẻ!</p>