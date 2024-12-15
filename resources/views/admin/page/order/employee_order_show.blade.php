@extends('admin.layout.master')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Thông tin đơn hàng -->
        <h1>Chi tiết đơn hàng #{{ $order->id }}</h1>
        <p>Ngày tạo: {{ $order->created_at }}</p>
        <p>Trạng thái: {{ $order->status }}</p>
        <p>Tổng giá trị đơn hàng: {{ number_format($order->total_price, 0, ',', '.') }} VND</p>

        <!-- Danh sách sản phẩm trong đơn hàng -->
        <h2>Sản phẩm trong đơn hàng</h2>
        @foreach ($order->orderItems as $orderItem)
            <div>
                <h3>{{ $orderItem->product->name }} ({{ $orderItem->variant->name ?? 'Không có biến thể' }})</h3>
                <p>Số lượng: {{ $orderItem->quantity }}</p>
                <p>Đơn giá: {{ number_format($orderItem->price, 0, ',', '.') }} VND</p>
            </div>
        @endforeach

    </div>
</div>
@endsection
