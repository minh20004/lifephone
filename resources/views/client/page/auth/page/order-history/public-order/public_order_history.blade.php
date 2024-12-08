@extends('client.layout.master')

@section('title', 'Tra cứu đơn hàng')

@section('content')
    <div class="container  mt-n2 mt-sm-0">
        <div class="row pt-md-2 pt-lg-3 pb-sm-2 pb-md-3 pb-lg-4 pb-xl-5">
            <aside class="col-lg-3">
                <div class="d-flex flex-column align-items-center justify-content-end h-100 text-center overflow-hidden rounded-5 px-4 px-lg-3 pt-4 pb-5"
                style="background: #1d2c41 url('client/img/home/electronics/banner/background.jpg') center/cover no-repeat">
                <div class="ratio animate-up-down position-relative z-2 me-lg-4"
                    style="max-width: 320px; margin-bottom: -19%; --cz-aspect-ratio: calc(690 / 640 * 100%)">
                    <img src="client/img/home/electronics/timkiem.png" alt="Laptop">
                </div>
                <h3 class="display-2 mb-2">Iphone 15 VNA</h3>
                <p class="text-body fw-medium mb-4"> Trở nên chuyên nghiệp ở mọi nơi</p>
                <a class="btn btn-sm btn-primary" href="#!">
                    Giá: 19.690.000đ
                    <i class="ci-arrow-up-right fs-base ms-1 me-n1"></i>
                </a>
            </div>
            </aside>
            <div class="col-lg-9">
                
                    <div class=" d-flex justify-content-between align-items-center border rounded">
                        <p class="m-3 fs-6 fw-bold text-danger">Tìm kiếm đơn hàng của bạn</p>
                        <form action="{{ route('order.publicHistory') }}" method="GET" class=" m-3">
                            <div class="row">
                                <div class="col">
                                    <input type="text" name="order_code" class="form-control " placeholder="Nhập mã đơn hàng của bạn" value="{{ request('order_code') }}">
                                </div>
                                {{-- <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                                </div> --}}
                            </div>
                        </form>
                    </div>
                    
            
                @if ($orders->isEmpty() && request('order_code'))
                    <div class="alert alert-danger">Không tìm thấy đơn hàng nào với mã "{{ request('order_code') }}".</div>
                @elseif ($orders->isNotEmpty())
                    <div class="mt-3">
                        @forelse ($orders as $order)
                            <div class="card shadow-sm mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fa-solid fa-shop"></i>
                                        <b>LifePhone</b>
                                    </div>
                                    <span class="text-danger"><span class="text-dark">Mã đơn hàng: {{ $order->order_code }}</span> | {{ $order->status }}</span>
                                </div>
                                <div class="card-body">
                                    <div class=" align-items-center">
                                        @foreach ($order->orderItems as $item)
                                            <div class="col-12 mb-3 border-bottom pb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        @if ($item->product->image_url)
                                                            <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="Product" class="img-fluid rounded" style="max-width: 80px; height: auto;">
                                                        @else
                                                            Không có ảnh
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p class="mb-1 fw-bold">{{ $item->product->name }}</p>
                                                        <p class="mb-1 text-muted">Phân loại hàng: {{ $item->variant->color->name ?? 'Không có màu' }}, {{ $item->variant->capacity->name ?? 'Không có dung lượng' }}</p>
                                                        <p class="mb-1 text-dark">x{{ $item->quantity }}</p>
                                                    </div>
                                                    <div class="text-end">
                                                        <p class="mb-1 text-danger fw-600">{{ number_format($item->price, 0, ',', '.') }} đ</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <p>Thành tiền: </p>
                                            <p class="fs-5 ms-2 fw-bold text-danger">{{ number_format($order->total_price, 0, ',', '.') }} đ</p>
                                        </div>
                                        <div class="text-end mt-3 d-flex justify-content-between gap-2">
                                            <p style="font-size:13px;">Ngày đặt hàng: {{ $order->created_at->format('d/m/Y ') }}</p>
                                            <div class="d-flex gap-2">
                                                <div><a href="{{ route('order.publicDetail', $order->id) }}" class="btn border border-danger btn-sm text-dark">Xem Chi Tiết Đơn Hàng</a></div>
                                                <div>
                                                    @if($order->status == 'Chờ xác nhận')
                                                        <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                                                            @csrf
                                                            <button class="btn btn-outline-danger btn-sm">Hủy Đơn Hàng</button>
                                                        </form>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <p class="text-center">
                            @if($tabId === 'home' && isset($searchCode) && $searchCode)
                                Không tìm thấy đơn hàng nào với mã: "{{ $searchCode }}".
                            @else
                                Không có đơn hàng nào.
                            @endif
                        </p>
                        @endforelse
                    </div>
                    
                @endif
            </div>
        </div>
    </div>
    
@endsection
