@extends('client.page.auth.layout.master')


@section('content')
<div class="container  mt-n2 mt-sm-0">
    <div class="row pt-md-2 pt-lg-3 pb-sm-2 pb-md-3 pb-lg-4 pb-xl-5">
        <aside class="col-lg-3">
            <div class="d-flex flex-column align-items-center justify-content-end h-100 text-center overflow-hidden rounded-5 px-4 px-lg-3 pt-4 pb-5"
            style="background: #1d2c41 url('client/img/home/electronics/banner/background.jpg') center/cover no-repeat">
            <div class="ratio animate-up-down position-relative z-2 me-lg-4"
                style="max-width: 320px; margin-bottom: -19%; --cz-aspect-ratio: calc(690 / 640 * 100%)">
                <img src="../client/img/home/electronics/timkiem.png" alt="Laptop">
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
            <div class="container my-4">
                <!-- Header -->

                <div class="d-flex justify-content-between border align-items-center rounded-bottom">
                    <div class="m-3" style="margin-left: 20px">
                        <a class="text-decoration-none fs-6 text-danger" href="{{ route('order.publicHistory') }}" ><i class="fa-solid fa-arrow-left"></i> Trở lại</a>
                    </div>
                    <div class="pe-3">
                        <span class="text-danger"><span class="text-dark">Mã đơn hàng: {{ $order->order_code }}</span> | {{ $order->status }}</span>
                    </div>
                </div>
                <div class="card shadow-sm ">
                    <div>
                        <div class="d-flex align-items-center justify-content-start pe-3  border-bottom">
                            <div class="w-25 p-3"><span>Tên người nhận</span></div>
                            <div class=" border-start p-3">
                                <div>{{ $order->name }}</div>
                            </div>
                        </div>
                            <div class="d-flex align-items-center justify-content-start pe-3  border-bottom">
                                <div class="w-25 p-3"><span>Số điện thoại</span></div>
                                <div class=" border-start p-3">
                                    <div>{{ $order->phone }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-start pe-3  border-bottom">
                                <div class="w-25 p-3"><span>Địa Chỉ</span></div>
                                <div class=" border-start p-3">
                                    <div>{{ $order->address }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-start pe-3 ">
                                <div class="w-25 p-3"><span>Email</span></div>
                                <div class=" border-start p-3">
                                    <div class="fs-6">{{ $order->email ?? 'Không có' }}</div>
                                </div>
                            </div>
                    </div>
                    <div style="
                        background-image: repeating-linear-gradient(45deg, #e53bdc, #d51e55 33px, transparent 0, transparent 41px, #0bf373 0, #20c2e7 74px, transparent 0, transparent 82px);
                        background-position-x: -1.875rem;
                        background-size: 7.25rem .1875rem;
                        height: .1875rem;
                        width: 100%;">
                    </div>
                    <div class="pt-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa-solid fa-shop"></i>
                                <b>LifePhone</b>
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center ">
                            @foreach ($order->orderItems as $item)
                            <div class="col-md-1">
                                @if ($item->product->image_url)
                                    <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="Product" class="img-fluid rounded">
                                @else
                                    Không có ảnh
                                @endif
                            </div>
                            <div class="col-md-5">
                                <p class="mb-1 ms-3 fw-bold">{{ $item->product->name }}</p>
                                <p class="mb-1 ms-3 text-muted">Phân loại hàng: {{ $item->variant->color->name ?? 'Không có màu' }}, {{ $item->variant->capacity->name ?? 'Không có dung lượng' }}</p>
                                <p class="mb-1 ms-3 text-dark">x{{ $item->quantity }}</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <p class="mb-1 text-danger fw-600 ">{{ number_format($item->price, 0, ',', '.') }} đ</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                        <div class="border-top">
                            <div class="d-flex align-items-center justify-content-end pe-3 text-end border-bottom">
                                <div class="pe-3"><span>Tổng tiền hàng</span></div>
                                <div class="w-25 border-start p-3">
                                    <div>{{ number_format($item->total_price, 0, ',', '.') }} đ</div>
                                </div>
                            </div>
                                <div class="d-flex align-items-center justify-content-end pe-3 text-end border-bottom">
                                    <div class="pe-3"><span>Giảm giá</span></div>
                                    <div class="w-25 border-start p-3">
                                        <div >{{ $order->voucher->discount_percentage ?? '0' }} %</div>
                                        
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-end pe-3 text-end border-bottom">
                                    <div class="pe-3"><span>Thành tiền</span></div>
                                    <div class="w-25 border-start p-3">
                                        <div class="fs-5 fw-bold text-danger">{{ number_format($order->total_price, 0, ',', '.') }} đ</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-end pe-3 text-end border-bottom">
                                    <div class="pe-3"><span>Phương thức thanh toán</span></div>
                                    <div class="w-25 border-start p-3">
                                        <div class="fs-6"><b>Thanh toán khi nhận hàng</b></div>
                                    </div>
                                </div>
                        </div>
                    </div>
               
        </div>
    </div>
</div>
                
@endsection