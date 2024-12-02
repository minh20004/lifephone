<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vouchers')->insert([
            [
                'code' => 'VOUCHER2024',
                'discount_percentage' => 15.00,
                'start_date' => Carbon::now()->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(30)->format('Y-m-d'), // Tự động tạo ngày hết hạn sau 30 ngày
                'max_discount_amount' => 100000.00,
                'min_order_value' => 200000.00,
                'usage_limit' => 100,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'NEWYEAR11/11',
                'discount_percentage' => 20.00,
                'start_date' => Carbon::now()->addDays(1)->format('Y-m-d'), // Bắt đầu từ ngày mai
                'end_date' => Carbon::now()->addDays(60)->format('Y-m-d'), // Hết hạn sau 60 ngày
                'max_discount_amount' => 500000.00,
                'min_order_value' => 1000000.00,
                'usage_limit' => 50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'BLACKFRIDAY10/10',
                'discount_percentage' => 50.00,
                'start_date' => Carbon::now()->addDays(10)->format('Y-m-d'), // Bắt đầu sau 10 ngày
                'end_date' => Carbon::now()->addDays(40)->format('Y-m-d'), // Hết hạn sau 40 ngày
                'max_discount_amount' => 200000.00,
                'min_order_value' => 500000.00,
                'usage_limit' => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

    }
}
