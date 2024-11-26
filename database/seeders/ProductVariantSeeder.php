<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = DB::table('products')->pluck('id'); // Lấy tất cả id của sản phẩm
        $capacities = DB::table('capacities')->pluck('id'); // Lấy tất cả id của dung lượng
        $colors = DB::table('colors')->pluck('id'); // Lấy tất cả id của màu sắc

        // Chèn dữ liệu vào bảng product_variants
        foreach ($products as $product_id) {
            foreach ($capacities as $capacity_id) {
                foreach ($colors as $color_id) {
                    DB::table('product_variants')->insert([
                        'product_id' => $product_id, // Lấy id sản phẩm
                        'capacity_id' => $capacity_id, // Lấy id dung lượng
                        'color_id' => $color_id, // Lấy id màu sắc
                        'price_difference' => rand(100000, 2000000) / 100, // Chênh lệch giá ngẫu nhiên
                        'stock' => rand(10, 100), // Số lượng tồn kho ngẫu nhiên
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }
    }
}
