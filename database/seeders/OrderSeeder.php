<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Lấy các user_id từ bảng users
        $users = DB::table('users')->pluck('id')->toArray();

        // Lấy các voucher_id từ bảng vouchers (nếu có)
        $vouchers = DB::table('vouchers')->pluck('id')->toArray();

        // Số lượng đơn hàng cần tạo (ngẫu nhiên từ 30 đến 50)
        $orderCount = rand(30, 50);

        // Mảng chứa dữ liệu đơn hàng
        $orders = [];

        for ($i = 0; $i < $orderCount; $i++) {
            // Tạo thời gian create_at ngẫu nhiên trong vòng 6 tháng qua
            $randomDate = Carbon::now()->subMonths(rand(0, 6))->subDays(rand(0, 30))->format('Y-m-d H:i:s');

            // Tạo dữ liệu đơn hàng
            $orders[] = [
                'user_id' => $users[array_rand($users)], // Chọn ngẫu nhiên user_id
                'voucher_id' => $vouchers ? $vouchers[array_rand($vouchers)] : null, // Chọn ngẫu nhiên voucher_id hoặc null
                'total_price' => rand(200000, 2000000), // Giá trị đơn hàng ngẫu nhiên từ 200k đến 2 triệu
                'status' => $this->getRandomOrderStatus(), // Trạng thái đơn hàng ngẫu nhiên
                'created_at' => $randomDate, // Thời gian tạo đơn hàng
                'updated_at' => Carbon::now(), // Thời gian cập nhật là hiện tại
            ];
        }

        // Chèn dữ liệu vào bảng orders
        DB::table('orders')->insert($orders);
    }

    /**
     * Trả về trạng thái ngẫu nhiên cho đơn hàng từ các giá trị enum ['pending', 'processing', 'completed', 'cancelled'].
     *
     * @return string
     */
    private function getRandomOrderStatus()
    {
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        return $statuses[array_rand($statuses)];
    }
}
