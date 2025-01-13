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
                <h4 class="display-2 mb-2 text-light">Iphone 15 VNA</h4>
                <p class="text-body fw-medium mb-4 text-light"> Trở nên chuyên nghiệp ở mọi nơi</p>
                <a class="btn btn-sm btn-primary" href="#!">
                    Giá: 19.690.000đ
                    <i class="ci-arrow-up-right fs-base ms-1 me-n1"></i>
                </a>
            </div>
            </aside>
            <div class="col-lg-9">
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <strong>Lỗi!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

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
                                <div class="progress-container">
                                    <div class="progress-step">
                                        <div class="icon {{ in_array($order->status, ['Chờ xác nhận', 'Đã xác nhận', 'Đang giao hàng', 'Đã hoàn thành']) ? 'completed' : ($order->status === 'Đã hủy' ? 'cancelled' : '') }}">
                                            <i class="bi bi-receipt"></i>
                                        </div>
                                        <p class="mt-2 mb-0">Chờ xác nhận</p>
                                    </div>
                                    <div class="progress-line {{ in_array($order->status, ['Đã xác nhận', 'Đang giao hàng', 'Đã hoàn thành']) ? 'completed' : ($order->status === 'Đã hủy' ? 'cancelled' : '') }}"></div>
                                    <div class="progress-step">
                                        <div class="icon {{ in_array($order->status, ['Đã xác nhận', 'Đang giao hàng', 'Đã hoàn thành']) ? 'completed' : ($order->status === 'Đã hủy' ? 'cancelled' : '') }}">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <p class="mt-2 mb-0">Đã xác nhận</p>
                                    </div>
                                    <div class="progress-line {{ in_array($order->status, ['Đang giao hàng', 'Đã hoàn thành']) ? 'completed' : ($order->status === 'Đã hủy' ? 'cancelled' : '') }}"></div>
                                    <div class="progress-step">
                                        <div class="icon {{ in_array($order->status, ['Đang giao hàng', 'Đã hoàn thành']) ? 'completed' : ($order->status === 'Đã hủy' ? 'cancelled' : '') }}">
                                            <i class="bi bi-truck"></i>
                                        </div>
                                        <p class="mt-2 mb-0">Đang giao hàng</p>
                                    </div>
                                    <div class="progress-line {{ $order->status === 'Đã hoàn thành' ? 'completed' : ($order->status === 'Đã hủy' ? 'cancelled' : '') }}"></div>
                                    <div class="progress-step">
                                        <div class="icon {{ $order->status === 'Đã hoàn thành' ? 'completed-filled' : ($order->status === 'Đã hủy' ? 'cancelled' : '') }}">
                                            <i class="bi bi-box"></i>
                                        </div>
                                        <p class="mt-2 mb-0">Đã hoàn thành</p>
                                    </div>
                                    <div class="progress-line {{ $order->status === 'Đã hủy' ? 'cancelled' : ($order->status === 'Đã hoàn thành' ? 'completed' : '') }}"></div>
                                    <div class="progress-step">
                                        <div class="icon {{ $order->status === 'Đã hoàn thành' ? 'completed-filled' : ($order->status === 'Đã hủy' ? 'cancelled' : '') }}">
                                            <i class="bi bi-star"></i>
                                        </div>
                                        <p class="mt-2 mb-0">{{ $order->status === 'Đã hoàn thành' ? 'Đánh giá' : 'Đã hủy' }}</p>
                                    </div>
                                </div>
                                <div>
                                    <p style="font-size:13px;">Ngày đặt hàng: {{ $order->created_at->format('d/m/Y ') }}</p>
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
