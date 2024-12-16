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
    .stat-button {
    padding: 8px 10px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    cursor: pointer;
    font-size: 16px;
    margin-bottom: 20px;
    }

    .stat-button.active {
        background-color: #405189;
        color: white;
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
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- nút xem thống kê --}}
                    <button id="chartButton" class="stat-button active">Thống kê biểu đồ</button>
                    <button id="listButton" class="stat-button">Thống kê danh sách</button>
                    
                    <!-- Biểu đồ -->
                    <div id="chartSection">
                        
                        <div class="row">
                            <div class="col-6 col-xl-6 col-md-6">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <h5 class="card-title">Số lượng đơn hàng theo trạng thái</h5>
                                        <canvas id="orderStatusChart"></canvas>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="col-6 col-xl-6 col-md-6">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <h5 class="card-title">Thu nhập theo ngày</h5>
                                        <canvas id="incomeChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3>Thống kê nhân viên</h3>
                        <div class="row mb-8 mt-4">
                            <div  class="col-6 col-xl-6 col-md-6 pt-3 card">
                                <table class="table" border="1" cellpadding="5" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên nhân viên</th>
                                            <th>Số lượng đơn hàng hoàn thành</th>
                                            <th>Tổng thu nhập</th>
                                            <th>Chi tiết</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employees as $index => $employee)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $employee->name }}</td>
                                                <td>{{ $employee->orders_count }}</td>
                                                <td>{{ number_format($employee->orders_sum_total_price, 0, ',', '.') }} VND</td>
                                                <td><a href="{{ route('employee.orders', $employee->id) }}" class="btn btn-dark btn-sm">Xem</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>

                    </div>
                    
                    <!-- Danh sách -->
                    <div id="listSection" style="display:none;">

                        <!-- Danh sách thống kê từ ... -->
                        <div class="row">
                            <!-- Đơn hàng -->
                            <div class="col-md-3">
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
                    
                            <!-- Khách hàng đăng ký -->
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
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-end justify-content-between">
                                            <div>
                                                <p class="fs-22 fw-semibold ff-secondary mb-4">
                                                    Tổng thu nhập từ <span>{{ $formattedStartDate }}</span> đến 
                                                    <span>{{ $formattedEndDate }}: </span><br>
                                                    <span class="text-danger">{{ number_format($totalIncome ?? 0, 0, ',', '.') }} VNĐ</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <h5 class="{{ $incomeChangePercentage >= 0 ? 'text-success' : 'text-danger' }} fs-14 mb-0">
                                                    <div style="max-height: 300px; width: 580px; overflow-y: auto;">
                                                        <table class="table w-100">
                                                            <thead>
                                                                <tr>
                                                                    <th>Ngày</th>
                                                                    {{-- <th>Ngày trước (VND)</th> --}}
                                                                    <th>Thu nhập (VNĐ)</th>
                                                                    <th>%</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($dailyChanges as $change): ?>
                                                                    <tr>
                                                                        <td><?php echo $change['date']; ?></td>
                                                                        {{-- <td><?php echo $change['previous_income']; ?></td> --}}
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
                        
                        <h3>Thống kê nhân viên</h3>
                        <div class="row mb-8 mt-4">
                            <div  class="col-6 col-xl-6 col-md-6 pt-3 card">
                                <table class="table" border="1" cellpadding="5" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên nhân viên</th>
                                            <th>Số lượng đơn hàng hoàn thành</th>
                                            <th>Tổng thu nhập</th>
                                            <th>Chi tiết</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employees as $index => $employee)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $employee->name }}</td>
                                                <td>{{ $employee->orders_count }}</td>
                                                <td>{{ number_format($employee->orders_sum_total_price, 0, ',', '.') }} VND</td>
                                                <td><a href="{{ route('employee.orders', $employee->id) }}" class="btn btn-dark btn-sm">Xem</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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

<script>
    // Lấy các button và section
    const listButton = document.getElementById('listButton');
    const chartButton = document.getElementById('chartButton');
    const listSection = document.getElementById('listSection');
    const chartSection = document.getElementById('chartSection');

    // Lắng nghe sự kiện click cho mỗi button
    listButton.addEventListener('click', () => {
        // Thay đổi màu sắc button
        listButton.classList.add('active');
        chartButton.classList.remove('active');

        // Hiển thị/ẩn các section tương ứng
        listSection.style.display = 'block';
        chartSection.style.display = 'none';
    });

    chartButton.addEventListener('click', () => {
        // Thay đổi màu sắc button
        chartButton.classList.add('active');
        listButton.classList.remove('active');

        // Hiển thị/ẩn các section tương ứng
        chartSection.style.display = 'block';
        listSection.style.display = 'none';
    });
</script>

@endsection