<!-- resources/views/checkout/confirmation.blade.php -->
@extends('client.layout.master')

@section('title', 'Xác Nhận Đơn Hàng')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Cảm ơn bạn đã đặt hàng!</h2>
    <p class="text-center mb-5">Đơn hàng của bạn đã được ghi nhận và sẽ sớm được xử lý.</p>

    <div class="order-details">
        <h4 class="mb-3">Thông tin đơn hàng</h4>
        <ul class="list-group mb-4">
            <li class="list-group-item">
                <strong>Mã đơn hàng:</strong> #{{ $order->id }}
            </li>
            <li class="list-group-item">
                <strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}
            </li>
            <li class="list-group-item">
                <strong>Phương thức thanh toán:</strong> {{ $order->payment_method }}
            </li>
            <li class="list-group-item">
                <strong>Phương thức vận chuyển:</strong> {{ $order->shipping_method }}
            </li>
            <li class="list-group-item">
                <strong>Tổng giá trị đơn hàng:</strong> {{ number_format($order->total_price, 0, ',', '.') }} đ
            </li>
            <li class="list-group-item">
                <strong>Phí vận chuyển:</strong> {{ number_format($order->shipping_fee, 0, ',', '.') }} đ
            </li>
            <li class="list-group-item">
                <strong>Voucher:</strong> 
                @if ($order->voucher_id)
                    Voucher ID: {{ $order->voucher_id }}
                @else
                    Không sử dụng
                @endif
            </li>
        </ul>
    </div>

    <div class="order-items">
        <h4 class="mb-3">Chi tiết sản phẩm</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $orderItem)
                    <tr>
                        <td>{{ $orderItem->product->name }}</td>
                        <td>{{ number_format($orderItem->price, 0, ',', '.') }} đ</td>
                        <td>{{ $orderItem->quantity }}</td>
                        <td>{{ number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }} đ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('home') }}" class="btn btn-primary">Quay lại trang chủ</a>
    </div>
</div>
@endsection
