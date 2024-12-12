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
</style>

@extends('admin.layout.master')
@section('title')
    Trang quản trị
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col">

                <div class="h-100">

                    {{-- lọc theo ngày tháng năm --}}
                    <div class="row mb-3 pb-1">
                        <div class="col-12">
                            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                <div class="flex-grow-1">
                                    <h4 class="fs-16 mb-1">Xin chào, <strong style="color: red">{{ Auth::user()->name }}</strong>!</h4>
                                    <p class="text-muted mb-0">Sau đây là những gì đang diễn ra tại cửa hàng của bạn ngày hôm nay.</p>
                                </div>
                                <div class="mt-3 mt-lg-0">
                                    <form action="{{ route('admin.home') }}" method="GET" class="mb-4">
                                        <div class="row">
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
                                                <button type="submit" class="btn btn-primary w-100">Xem thống kê</button>
                                            </div>

                                            {{-- <div class="col-auto mt-4">
                                                <a href="{{ route('product-admin.create') }}" class="btn btn-soft-success"><i class="ri-add-circle-line align-middle me-1"></i> Thêm sản phẩm mới</a>
                                            </div>
                                            
                                            <div class="col-auto mt-4">
                                                <button type="button" class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-pulse-line"></i></button>
                                            </div> --}}
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                            <!-- end card header -->
                        </div>
                    </div>
                    <!--end row-->

                    {{-- biểu đồ --}}
                    <h3 class="text-center mb-4">Biểu đồ thống kê từ: 
                        <span class="text-danger">{{ $formattedStartDate }}</span> đến 
                        <span class="text-danger">{{ $formattedEndDate }}</span> 
                    </h3>
                    {{-- Biểu đồ số lượng đơn hàng theo trạng thái --}}
                    <div class="row">
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

                    <h3 class="text-center mb-4 mt-5">Danh sách thống kê từ: 
                        <span class="text-danger">{{ $formattedStartDate }}</span> đến 
                        <span class="text-danger">{{ $formattedEndDate }}</span> 
                    </h3>

                    {{-- danh sách --}}
                    <div class="row">
                        {{-- Đơn hàng --}}
                        <div class="col-md-3">
                            <!-- card -->
                            <div class="card card-animate" style="height: 424px">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn hàng chờ xác nhận</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="{{ $orderChangePercentage['Chờ xác nhận'] >= 0 ? 'text-success' : 'text-danger' }} fs-14 mb-0">
                                                <i class="ri-arrow-{{ $orderChangePercentage['Chờ xác nhận'] >= 0 ? 'right-up' : 'right-down' }}-line fs-13 align-middle"></i>
                                                {{ number_format(abs($orderChangePercentage['Chờ xác nhận']), 2) }} %
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4 mb-3">
                                        <div>
                                            <a href="{{ route('orders.index') }}" class="text-decoration-underline">Xem tất cả đơn hàng</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                                <i class="bx bx-shopping-bag text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="don-hang">
                                        <table class="table">
                                            <tbody>
                                                @foreach ($currentOrdersByStatus as $status => $count)
                                                    <tr>
                                                        <td>{{ $status }}:</td>
                                                        <td style="color: rgb(248, 0, 0)"><strong>{{ $count }}</strong></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- khách hàng đăng kí --}}
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate" style="height: 424px">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Khách hàng đăng ký</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="{{ $customerChangePercentage >= 0 ? 'text-success' : 'text-danger' }} fs-14 mb-0">
                                                <i class="{{ $customerChangePercentage >= 0 ? 'ri-arrow-right-up-line' : 'ri-arrow-right-down-line' }} fs-13 align-middle"></i>
                                                {{ number_format(abs($customerChangePercentage), 2) }} %
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mb-3">
                                        <div>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0 mt-4 ">
                                            <span class="avatar-title bg-warning-subtle rounded fs-3 text-end">
                                                <i class="bx bx-user-circle text-warning"></i>
                                            </span>
                                        </div>
                                    </div>

                                       

                                        <div class="mt-3">
                                            <h4 class="mb-4"><i class="fa-solid fa-user"></i> Người đăng kí: <span class="fw-bold" style="color: red">{{ $totalCustomers }}</span></h4>
                                            <h4 class="mb-4"><i class="fa-solid fa-fire"></i> MỚi: <span class="fw-bold" style="color: red">{{ $currentCustomerCount }}</span></h4>
                                        </div>
                                        

                                </div>
                            </div>
                        </div>

                        <!-- Tổng thu nhập -->
                        <div class="col-6">
                            <!-- card -->
                            <div class="card card-animate" >
                                <div class="card-body">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <p class="fs-22 fw-semibold ff-secondary mb-4">
                                                Tổng thu nhập từ <span>{{ $formattedStartDate }}</span> đến 
                                                <span >{{ $formattedEndDate }}: </span> <br>
                                                <span class="text-danger">{{ number_format($totalIncome ?? 0, 0, ',', '.') }} VNĐ</span>
                                            </p>
                                            
                                            {{-- <a href="" class="text-decoration-underline">Xem tất cả</a> --}}
                                        </div>
                                        {{-- <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                <i class="bx bx-dollar-circle text-success"></i>
                                            </span>
                                        </div> --}}
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <h5 class="{{ $incomeChangePercentage >= 0 ? 'text-success' : 'text-danger' }} fs-14 mb-0">
                                                <div style="max-height: 300px; overflow-y: auto;">
                                                    <table class="table col">
                                                        <thead>
                                                            <tr>
                                                                <th>Ngày</th>
                                                                <th>Ngày trước (VND)</th>
                                                                <th>Hiện tại (VND)</th>
                                                                <th>% thay đổi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($dailyChanges as $change): ?>
                                                                <tr>
                                                                    <td><?php echo $change['date']; ?></td>
                                                                    <td><?php echo $change['previous_income']; ?></td>
                                                                    <td><?php echo $change['current_income']; ?></td>
                                                                    <td>
                                                                        <?php
                                                                        if ($change['percentage_change'] === 'Không có dữ liệu ngày trước') {
                                                                            echo "<span class='text-danger'>Không thể tính toán</span>";
                                                                        } else {
                                                                            echo $change['percentage_change'] . '%';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </h5>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div> 

            </div>
        </div>

    </div>
    <!-- container-fluid -->
</div>

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
                data: [{{ $currentOrdersByStatus['Chờ xác nhận'] }}, {{ $currentOrdersByStatus['Đã xác nhận'] }}, {{ $currentOrdersByStatus['Đang giao hàng'] }}, {{ $currentOrdersByStatus['Đã hoàn thành'] }}, {{ $currentOrdersByStatus['Đã hủy'] }}],
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
    // var incomeCtx = document.getElementById('incomeChart').getContext('2d');
    // var incomeChart = new Chart(incomeCtx, {
    //     type: 'line',
    //     data: {
    //         labels: ['Ngày 1', 'Ngày 2', 'Ngày 3', 'Ngày 4', 'Ngày 5', 'Ngày 6', 'Ngày 7'],
    //         datasets: [{
    //             label: 'Thu nhập',
    //             data: [{{ $currentIncome }}, {{ $previousIncome }}, 0, 0, 0, 0, 0],
    //             fill: false,
    //             borderColor: 'rgba(75, 192, 192, 1)',
    //             tension: 0.1
    //         }]
    //     },
    //     options: {
    //         responsive: true
    //     }
    // });
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

</script>

<script>
    document.querySelectorAll('.counter-value').forEach(function (counter) {
    const target = +counter.getAttribute('data-target');
    counter.innerHTML = target.toLocaleString();
    });
</script>
@endsection