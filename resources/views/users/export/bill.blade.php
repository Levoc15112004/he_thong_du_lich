<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th colspan="4" style="text-align:center; font-weight:bold;">
                HÓA ĐƠN TOUR DU LỊCH
            </th>
        </tr>
        <tr>
            <th colspan="4" style="text-align:center;">
                Mã đơn hàng: #ORDER-{{ $order->id }}
            </th>
        </tr>
    </thead>

    <tbody>
        {{-- THÔNG TIN KHÁCH HÀNG --}}
        <tr>
            <td colspan="4" style="font-weight:bold;">THÔNG TIN KHÁCH HÀNG</td>
        </tr>

        <tr>
            <td>Họ và tên</td>
            <td colspan="3">{{ $order->name }}</td>
        </tr>

        <tr>
            <td>Số điện thoại</td>
            <td colspan="3">{{ $order->phone }}</td>
        </tr>

        <tr>
            <td>Địa chỉ</td>
            <td colspan="3">{{ $order->address }}
        </tr>

        <tr>
            <td>Ghi chú</td>
            <td colspan="3">{{ $order->note }}</td>
        </tr>

        {{-- THÔNG TIN TOUR --}}
        <tr>
            <td colspan="4" style="font-weight:bold;">THÔNG TIN TOUR</td>
        </tr>

        <tr>
            <td style="text-align:center">1</td>
            <td>Tên tour</td>
            <td colspan="2">{{ $tour->name }}</td>
        </tr>

        <tr>
            <td style="text-align:center">2</td>
            <td>Số lượng khách</td>
            <td colspan="2">{{ $order->quantity }}</td>
        </tr>

        <tr>
            <td style="text-align:center">3</td>
            <td>Tổng tiền</td>
            <td>{{ number_format($order->total_price, 0, ',', '.') }}</td>
            <td>VNĐ</td>
        </tr>

        <tr>
            <td style="text-align:center">4</td>
            <td>Ngày thanh toán</td>
            <td colspan="2">{{ $order->updated_at->format('d/m/Y') }}</td>
        </tr>
    </tbody>

    <tfoot>
        <tr>
            <td colspan="2"><strong>TỔNG CỘNG</strong></td>
            <td colspan="2">
                <strong>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</strong>
            </td>
        </tr>
    </tfoot>
</table>
