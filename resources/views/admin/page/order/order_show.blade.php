{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="m-3" style="margin-left: 20px">
                    <a href="{{ route('orders.index') }}"><b class="fs-4 fw-bold">Chi Tiết Đơn Hàng {{ $order->order_code }}</b></a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <p style="color: #000"><strong>Tên người nhận:</strong> {{ $order->name }}</p>
                    <p style="color: #000"><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                    <p style="color: #000"><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                    <p style="color: #000"><strong>Email:</strong> {{ $order->email ?? 'Không có' }}</p>
                    <p style="color: #000"><strong>Phương thức thanh toán:</strong> {{ $order->payment_method }}</p>
                    <p style="color: #000"><strong>Trạng thái:</strong> {{ $order->status }}</p>
                    <p style="color: #000"><strong>Khuyến Mãi:</strong> {{ $order->voucher->discount_percentage ?? '0' }} 
                        (Mã: {{ $order->voucher->code ?? 'Không có' }})
                    </p>
                </div>
                
            </div>
            <div class="card ">
                <div class="m-3" style="margin-left: 20px">
                    <a href="{{ route('orders.index') }}"><b class="fs-4 fw-bold">Sản Phẩm Trong Đơn Hàng</b></a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Ảnh</th>
                                <th>Màu sắc</th>
                                <th>Dung lượng</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Tổng giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>
                                        @if ($item->product->image_url)
                                            <img src="{{ asset('storage/' . $item->product->image_url) }}"
                                                alt="{{ $item->product->name }}" style="width: 100px; height: auto;">
                                        @else
                                            Không có ảnh
                                        @endif
                                    </td>
                                    <td>{{ $item->variant->color->name ?? 'Không có màu' }}</td>
                                    <td>{{ $item->variant->capacity->name ?? 'Không có dung lượng' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price, 0, ',', '.') }} vnđ</td>
                                    <td>{{ number_format($item->total_price, 0, ',', '.') }} vnđ</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <div>
                        <a href="{{ route('orders.index') }}" class="btn btn-dark"> Quay lại</a>
                    </div>
                    
                </div>
        </div>
    </div>
@endsection
