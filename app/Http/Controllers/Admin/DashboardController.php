<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function Dashboards(Request $request)
    {
        // Lấy ngày bắt đầu và ngày kết thúc từ request, nếu không có thì mặc định là đầu và cuối tháng hiện tại
        $startDate = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date'))->startOfDay()
            : Carbon::now()->startOfMonth();

        $endDate = $request->input('end_date') 
            ? Carbon::parse($request->input('end_date'))->endOfDay()
            : Carbon::now()->endOfMonth();

        // Thống kê tổng thu nhập từ các đơn hàng có trạng thái "Đã hoàn thành"
        $totalIncome = Order::where('status', 'Đã hoàn thành')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->sum('total_price');

        // Thống kê số lượng đơn hàng có trạng thái "Đã hoàn thành"
        $completedOrders = Order::where('status', 'Đã hoàn thành')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->count();

        // Truyền dữ liệu vào view
        return view('admin.index', compact('totalIncome', 'completedOrders', 'startDate', 'endDate'));
    }

}
