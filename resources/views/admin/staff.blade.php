
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
</style>
@extends('admin.layout.master')
@section('title')
    Trang quản trị nhân viên
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Thống kê cho nhân viên</h2>
            <form method="get" action="{{ route('admin.staff') }}">
                <div class="form-group row">
                    <label for="start_date" class="col-sm-2 col-form-label">Ngày bắt đầu</label>
                    <div class="col-sm-4">
                        <input type="date" name="start_date" class="form-control" value="{{ $formattedStartDate }}">
                    </div>
                    <label for="end_date" class="col-sm-2 col-form-label">Ngày kết thúc</label>
                    <div class="col-sm-4">
                        <input type="date" name="end_date" class="form-control" value="{{ $formattedEndDate }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Lọc</button>
            </form>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Tổng quan đơn hàng</h5>
                    <ul>
                        @foreach ($currentOrdersByStatus as $status => $count)
                            <li>
                                <strong>{{ $status }}:</strong> 
                                {{ $count }} đơn - 
                                <span class="{{ $orderChangePercentage[$status] >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $orderChangePercentage[$status] }}%
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Thu nhập</h5>
                    <p><strong>Thu nhập hiện tại: </strong>{{ number_format($currentIncome, 0) }} VND</p>
                    <p><strong>Thu nhập trước đó: </strong>{{ number_format($previousIncome, 0) }} VND</p>
                    <p><strong>Thay đổi thu nhập: </strong>
                        <span class="{{ $incomeChangePercentage >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $incomeChangePercentage }}%
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
