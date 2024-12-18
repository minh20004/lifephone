@extends('admin.layout.master')
@section('content')
@if ($errors->any())
    
    <script>
        alert('da co nguoi xac nhan don hang!')
    </script>
@endif
<div class="page-content">
    <div class="container-fluid">
        <div class="card">
            <div class="m-3" style="margin-left: 20px">
                <a href="{{ route('orders.index') }}"><b class="fs-4 fw-bold">Danh Sách Đơn Hàng</b></a>
            </div>
        </div>

        <!-- Search Form -->
        <div class="card mb-3">
            <form action="{{ route('orders.index') }}" method="GET" class="m-3">
                <div class="row">
                    <div class="col-md-11">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo mã đơn hàng hoặc tên người nhận" value="{{ request()->input('search') }}">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card d-flex ">
            <ul class="nav nav-pills  m-3" id="pills-tab" role="tablist">
                @foreach($groupedOrders as $status => $orders)
                    <li class="nav-item" role="presentation">
                        <button style="background:#9df99d;" 
                                class="me-3 {{ $loop->first ? 'active' : '' }} btn fs-6 fw-bold text-dark"
                                id="pills-{{ Str::slug($status) }}-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#pills-{{ Str::slug($status) }}"
                                type="button"
                                role="tab"
                                aria-controls="pills-{{ Str::slug($status) }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            {{ $status }} 
                            <span class="text-danger fw-normal">({{ $orderCounts[$status] }})</span>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Tabs Content -->
        <div class="tab-content" id="pills-tabContent">
            @foreach($groupedOrders as $status => $orders)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                     id="pills-{{ Str::slug($status) }}" 
                     role="tabpanel" 
                     aria-labelledby="pills-{{ Str::slug($status) }}-tab">
                    @if($orders->count() > 0)
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                    @forelse ($orders as $order)
                                        <div class=" card shadow-sm mb-4">
                                            
                                            <div class="card-body">
                                                <div class="d-flex align-items-center border-bottom">
                                                @foreach ($order->orderItems as $item)
                                                    <div class="col-md">
                                                        @if (!empty($item->product->image_url))  <!-- Kiểm tra nếu image_url không rỗng hoặc null -->
                                                            <img src="{{ asset('storage/' . $item->product->image_url) }}" width="40px" height="40px" alt="Product" class="img-fluid rounded">
                                                        @else
                                                            Không có ảnh
                                                        @endif
                                                    </div>
                                                @endforeach
                                                    <div class="col-md-9">
                                                        <p class="mb-1 ms-3 fw-bold">Mã đơn hàng: {{ $order->order_code }}</p>
                                                        <p class="mb-1 ms-3 text-muted">Tên người nhận: {{ $order->name }}</p>
                                                        <p class="mb-1 ms-3 text-danger fw-600">Tổng tiền: {{ number_format($order->total_price, 0, ',', '.') }} đ</p>

                                                    </div>
                                                    <div class="col-md-2 text-end">
                                                        <form action="{{ route('order.updateStatus', $order->id) }}" method="POST">
                                                            @csrf
                                                            @if ($order->status === 'Thanh toán thất bại')
                                                                <select name="status" class="form-control border-danger fw-bold text-danger" disabled>
                                                                    <option value="Thanh toán thất bại" selected>Thanh toán thất bại</option>
                                                                </select>
                                                            @else
                                                                <!-- Trạng thái cho các đơn hàng khác -->
                                                                <select name="status" class="form-control
                                                                    @if($order->status === 'Chờ xác nhận') border-danger fw-bold text-danger 
                                                                    @elseif($order->status === 'Đã xác nhận') border-success fw-bold text-success
                                                                    @elseif($order->status === 'Đang giao hàng') border-warning fw-bold text-warning
                                                                    @elseif($order->status === 'Đã hoàn thành') border-primary fw-bold text-primary
                                                                    @elseif($order->status === 'Đã hủy') border-danger fw-bold text-danger
                                                                    @endif" onchange="this.form.submit()">
                                                                    
                                                                    <option value="Chờ xác nhận" 
                                                                        {{ $order->status === 'Chờ xác nhận' ? 'selected' : 'disabled' }}>Chờ xác nhận</option>
                                                                
                                                                    <option value="Đã xác nhận" 
                                                                        {{ $order->status === 'Đã xác nhận' ? 'selected' : ($order->status !== 'Chờ xác nhận' ? 'disabled' : '') }}>Đã xác nhận</option>
                                                                
                                                                    <option value="Đang giao hàng" 
                                                                        {{ $order->status === 'Đang giao hàng' ? 'selected' : ($order->status !== 'Đã xác nhận' ? 'disabled' : '') }}>Đang giao hàng</option>
                                                                
                                                                    <option value="Đã hoàn thành" 
                                                                        {{ $order->status === 'Đã hoàn thành' ? 'selected' : ($order->status !== 'Đang giao hàng' ? 'disabled' : '') }}>Đã hoàn thành</option>
                                                                
                                                                    <option value="Đã hủy" 
                                                                        {{ $order->status === 'Đã hủy' ? 'selected' : ($order->status !== 'Chờ xác nhận' && $order->status !== 'Đã xác nhận' && $order->status !== 'Đang giao hàng' ? 'disabled' : '') }}>Đã hủy</option>
                                                                </select>
                                                            @endif
                                                        </form>
                                                    </div>
                                                    
                                                    
                                                </div>
                                                <div class="mt-3">
                                                    
                                                    <div class="text-end mt-3 d-flex justify-content-between gap-2">
                                                        <p style="font-size:13px;">Ngày đặt hàng: {{ $order->created_at->format('d/m/Y ') }}</p>
                                                        <div class="d-flex gap-2">
                                                            <div>
                                                                
                                                            </div>
                                                            <div><a href="{{ route('order.show', $order->id) }}" class="btn border border-danger btn-sm text-dark">Xem Chi Tiết Đơn Hàng</a></div>
                                                            
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
                                    
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">Không có đơn hàng trong trạng thái này.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
