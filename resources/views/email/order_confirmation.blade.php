<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
</head>
<body>
    <h1>Xin chào {{ $order->name }},</h1>
    <p>Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi. Dưới đây là thông tin đơn hàng của bạn:</p>
    <ul>
        <li>Mã đơn hàng: {{ $order->order_code }}</li>
        <li>Tên người nhận: {{ $order->name }}</li>
        <li>Địa chỉ: {{ $order->address }}</li>
        <li>Email: {{ $order->email }}</li>
        <li>Ngày tạo: {{ $order->created_at->format('d/m/Y H:i:s') }}</li>
        <li>Khuyến mãi: {{ $order->voucher->discount_percentage ?? '0' }} 
            (Mã: {{ $order->voucher->code ?? 'Không có' }})</li>
        <li>Phương thức thanh toán: {{ $order->payment_method }}</li>
        <li class="text-danger"><strong>Tổng tiền thanh toán:</strong> {{ number_format($order->total_price, 0, ',', '.') }} đ</li>
    </ul>
    <h3>Chi tiết đơn hàng:</h3>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Màu sắc</th>
                <th>Số lượng</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->variant->color->name ?? 'Không có màu' }}</td>
                    <td>{{ $item->variant->capacity->name ?? 'Không có màu' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                    <td>{{ number_format($item->total_price, 0, ',', '.') }} đ</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Chúng tôi sẽ liên hệ với bạn sớm nhất để xác nhận đơn hàng.</p>
    <p>Trân trọng,</p>
    <p><strong>Đội ngũ hỗ trợ</strong></p>
</body>
</html>

