@extends('admin.layout.master')
@section('title')
    Danh sách đơn hàng nhân viên
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <h3>Danh sách đơn hàng của: <span class="text-danger">{{ $employee->name }}</span></h3>

        <!-- Hiển thị thông báo nếu có -->
        @if(session('message'))
            <div class="alert alert-warning">{{ session('message') }}</div>
        @endif

        <!-- Form để lọc theo thời gian -->
        <form method="GET" action="{{ url()->current() }}" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label for="start_date">Từ ngày</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date', now()->startOfMonth()->toDateString()) }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date">Đến ngày</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date', now()->endOfMonth()->toDateString()) }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Lọc</button>
                </div>
            </div>
        </form>

        <!-- Hiển thị danh sách đơn hàng -->
        <div class="card p-3">
            @if($orders->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Trạng thái</th>
                        <th>thu nhập</th>
                        <th>Ngày cập nhật</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->total_price }}</td>
                            <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('order.show', $order->id) }}" class="btn btn-dark">Xem</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <p>Không có đơn hàng nào trong khoảng thời gian này.</p>
            @endif
        </div>
        
    </div>
</div>
@endsection
