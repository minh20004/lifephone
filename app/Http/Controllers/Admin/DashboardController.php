<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Lấy ngày hiện tại hoặc ngày mặc định
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // Kiểm tra nếu người dùng chọn khoảng thời gian
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
        }

        // Thống kê thu nhập
        $income = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total_amount');

        // Thống kê số lượng đơn hàng
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();

        // Truyền dữ liệu vào view
        return view('admin.index', [
            'income' => number_format($income, 2),
            'totalOrders' => $totalOrders,
            'startDate' => $startDate->format('d M, Y'),
            'endDate' => $endDate->format('d M, Y')
        ]);
    }
}
