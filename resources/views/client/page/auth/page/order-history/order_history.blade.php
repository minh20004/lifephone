@extends('client/page/auth/layout/master')

@section('content_customer')

<h1>Lịch sử đơn hàng</h1>
<table class="table">
    <thead>
        <tr>
            <th>Mã đơn hàng</th>
            <th>Ngày đặt</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Chi tiết</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->order_code }}</td>
            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
            <td>{{ $order->status }}</td>
            <td><a href="{{ route('order.detail', $order->id) }}" class="btn btn-primary">Xem</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
