@extends('client/page/auth/layout/master')

@section('content_customer')

<div class="container mt-4">
    <style>
        .nav-tabs {
            display: flex;
            flex-wrap: nowrap; 
            gap: 10px; 
        }

        .nav-tabs .nav-item .nav-link {
            white-space: nowrap; 
            text-align: center;
            font-size: 13px; 
            padding: 5px 10px; 
            border-radius: 5px; 
        }
        .nav-tabs .nav-link {
            color: #555; 
            border: 1px solid transparent; 
            transition: all 0.3s; 
        }
    </style>
    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active " id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
                Tất Cả <span class="text-danger ms-1">({{ $totalOrders }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                Chờ Xác Nhận <span class="text-danger ms-1">({{ $countOrders['pending'] }})</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
                Đã Xác Nhận <span class="text-danger ms-1">({{ $countOrders['confirmed'] }})</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">
                Đang giao hàng <span class="text-danger ms-1">({{ $countOrders['shipping'] }})</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="false">
                Hoàn Thành <span class="text-danger ms-1">({{ $countOrders['completed'] }})</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab" aria-controls="cancelled" aria-selected="false">
                Đã Hủy <span class="text-danger ms-1">({{ $countOrders['cancelled'] }})</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="refund-tab" data-bs-toggle="tab" data-bs-target="#refund" type="button" role="tab" aria-controls="refund" aria-selected="false">
                Trả hàng/Hoàn tiền <span class="text-danger ms-1">({{ $countOrders['refund'] }})</span>
            </button>
        </li>
    </ul>
  
    
    
    
    <div class="mb-4">
        <form method="GET" action="{{ route('order.history') }}" class="input-group ">
            <input type="text" name="order_code" class="form-control" placeholder="Bạn có thể tìm kiếm them mã đơn hàng của bạn" value="{{ request('order_code') }}">
        </form>
    </div>

    <div class="tab-content" id="myTabContent">
        @php
            $tabs = [
                'home' => $ordersAll,
                'profile' => $ordersPending,
                'contact' => $ordersConfirmed,
                'shipping' => $ordersShipping,
                'completed' => $ordersCompleted,
                'cancelled' => $ordersCancelled,
                'refund' => $ordersRefund,
            ];
        @endphp
    
        @foreach ($tabs as $tabId => $orders)
        <div class="tab-pane fade {{ $tabId === 'home' ? 'show active' : '' }}" id="{{ $tabId }}" role="tabpanel" aria-labelledby="{{ $tabId }}-tab">
            @if($tabId === 'home' && isset($searchCode) && $searchCode)
                <h6 class="fw-bold">Kết quả tìm kiếm cho mã đơn hàng: <strong>"{{ $searchCode }}"</strong></h6>
            @endif
    
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
                                <div>
                                    {{-- @if($order->status == 'Thanh toán thất bại')
                                        <form action="{{ route('order.retryPayment', $order->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-danger btn-sm">Thanh toán lại</button>
                                        </form>
                                    @endif --}}
                                    {{-- <form action="{{ route('order.retryPaymentNow', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Thanh toán lại</button>
                                    </form> --}}
                                    @if($order->status == 'Thanh toán thất bại')
                                        <form action="{{ route('order.retryPayment', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-warning">Thanh toán lại</button>
                                        </form>
                                    @endif

                                    


                                </div>
                                
                                <div><a href="{{ route('order.detail', $order->id) }}" class="btn border border-danger btn-sm text-dark">Xem Chi Tiết Đơn Hàng</a></div>
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
        @endforeach
    </div>
    
</div>


@endsection
