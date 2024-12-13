
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

             {{-- Biểu đồ số lượng đơn hàng theo trạng thái --}}
             <div class="row bieu-do">
                <div class="col-6 col-xl-6 col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <h5 class="card-title">Số lượng đơn hàng theo trạng thái</h5>
                            <canvas id="orderStatusChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Biểu đồ thu nhập --}}
                <div class="col-6 col-xl-6 col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <h5 class="card-title">Thu nhập theo ngày</h5>
                            <canvas id="incomeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Biểu đồ số lượng đơn hàng theo trạng thái
    var ctx = document.getElementById('orderStatusChart').getContext('2d');
    var orderStatusChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Chờ xác nhận', 'Đã xác nhận', 'Đang giao hàng', 'Đã hoàn thành', 'Đã hủy'],
            datasets: [{
                label: 'Số lượng đơn hàng',
                data: [
                    {{ $currentOrdersByStatus['Chờ xác nhận'] }},
                    {{ $currentOrdersByStatus['Đã xác nhận'] }},
                    {{ $currentOrdersByStatus['Đang giao hàng'] }},
                    {{ $currentOrdersByStatus['Đã hoàn thành'] }},
                    {{ $currentOrdersByStatus['Đã hủy'] }}
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Biểu đồ thu nhập theo ngày
    var incomeCtx = document.getElementById('incomeChart').getContext('2d');
    var incomeChart = new Chart(incomeCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dates) !!}, // Các ngày trong khoảng thời gian
            datasets: [{
                label: 'Thu nhập',
                data: {!! json_encode($incomeData) !!}, // Thu nhập cho từng ngày
                fill: false,
                borderColor: 'rgba(75, 192, 192, 1)', // Màu đường
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString(); // Hiển thị số với dấu phân cách nghìn
                        }
                    }
                }
            }
        }
    });

    // Định dạng các giá trị số với dấu phân cách nghìn
    document.querySelectorAll('.counter-value').forEach(function (counter) {
        const target = +counter.getAttribute('data-target');
        counter.innerHTML = target.toLocaleString();
    });
</script>

@endsection
