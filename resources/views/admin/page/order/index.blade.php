{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="m-3" style="margin-left: 20px">
                    <a href="{{ route('orders.index') }}"><b class="fs-4 fw-bold">Danh Sách Đơn Hàng</b></a>
                </div>
            </div>
            <div class="card">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <th>STT</th>
                            <th>Mã Đơn hàng</th>
                            <th>Tên người nhận</th>
                            <th>Tổng tiền </th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>

                        </thead>
                        <tbody>
                            @foreach($orders as $index => $order)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $order->order_code }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                                    <td>
                                        
                                        <form action="{{ route('order.updateStatus', $order->id) }}" method="POST">
                                            @csrf
                                            <select name="status" class="form-control" onchange="this.form.submit()">
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
                                        </form>
                                        
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('order.show', $order->id) }}" class="btn btn-dark"><i class="bi bi-eye-fill"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <div class="d-flex justify-content-end">
                        <nav>
                            <ul class="pagination">
                                {{-- Trang trước --}}
                                @if ($orders->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Lùi</span></li>
                                @else
                                    <li class="page-item"><a href="{{ $orders->previousPageUrl() }}"
                                            class="page-link">Lùi</a></li>
                                @endif

                                {{-- Các trang số --}}
                                @foreach ($orders->links()->elements[0] as $page => $url)
                                    @if ($page == $orders->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item"><a href="{{ $url }}"
                                                class="page-link">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Trang sau --}}
                                @if ($orders->hasMorePages())
                                    <li class="page-item"><a href="{{ $orders->nextPageUrl() }}"
                                            class="page-link">Tiến</a></li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">Tiến</span></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
