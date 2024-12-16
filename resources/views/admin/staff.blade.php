
<style>
    .table {
    width: 100%;
    border-collapse: collapse;
    }

    .table th, .table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    .table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }
    .table thead {
        position: sticky;
        top: 0;
        background-color: #fff;
        z-index: 1;
    }
    .container{
        margin-top: 100px;
    }
    .bieu-do{
        margin-bottom: 200px;
    }
</style>
@extends('admin.layout.master')
@section('title')
    Trang quản trị nhân viên
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h3 class=" mb-1">Xin chào <strong style="color: red">{{ Auth::user()->name }}</strong>!</h3>
            <form method="get" action="{{ route('admin.staff') }}">
                <form action="{{ route('admin.home') }}" method="GET" class="mb-4">
                    <div class="row mt-4">
                        <!-- Chọn ngày bắt đầu -->
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Ngày bắt đầu</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" 
                                   value="{{ request('start_date', Carbon\Carbon::now()->startOfMonth()->format('Y-m-d')) }}">
                        </div>
                
                        <!-- Chọn ngày kết thúc -->
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">Ngày kết thúc</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" 
                                   value="{{ request('end_date', Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')) }}">
                        </div>
                
                        <!-- Nút submit -->
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Xem thống kê</button>
                        </div>

                        {{-- <div class="col-auto mt-4">
                            <a href="{{ route('product-admin.create') }}" class="btn btn-soft-success"><i class="ri-add-circle-line align-middle me-1"></i> Thêm sản phẩm mới</a>
                        </div>
                        
                        <div class="col-auto mt-4">
                            <button type="button" class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-pulse-line"></i></button>
                        </div> --}}
                    </div>
                </form>
            </form>

            <div class="row mt-4">
                <!-- Tổng quan đơn hàng -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Tổng quan đơn hàng</h5>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Trạng thái</th>
                                        <th>Số lượng</th>
                                        <th>Thay đổi (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($currentOrdersByStatus as $status => $count)
                                        <tr>
                                            <td><strong>{{ $status }}</strong></td>
                                            <td>{{ $count }} đơn</td>
                                            <td>
                                                <span class="{{ $orderChangePercentage[$status] >= 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ $orderChangePercentage[$status] }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            
                <!-- Thu nhập -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Thu nhập</h5>
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Thu nhập hiện tại</th>
                                        <td>{{ number_format($currentIncome, 0) }} VND</td>
                                    </tr>
                                    <tr>
                                        <th>Thu nhập trước đó</th>
                                        <td>{{ number_format($previousIncome, 0) }} VND</td>
                                    </tr>
                                    <tr>
                                        <th>Thay đổi thu nhập</th>
                                        <td>
                                            <span class="{{ $incomeChangePercentage >= 0 ? 'text-success' : 'text-danger' }}">
                                                {{ $incomeChangePercentage }}%
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection
