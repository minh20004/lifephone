<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy các order_id từ bảng orders
        $orders = DB::table('orders')->pluck('id')->toArray();

        // Lấy các product_id từ bảng products
        $products = DB::table('products')->pluck('id')->toArray();

        // Lấy các variant_id từ bảng product_variants (nếu có)
        $variants = DB::table('product_variants')->pluck('id')->toArray();

        // Mảng chứa dữ liệu order_items
        $orderItems = [];

        foreach ($orders as $orderId) {
            // Số lượng order_items cho mỗi đơn hàng (ngẫu nhiên từ 1 đến 5 sản phẩm)
            $numItems = rand(1, 5);

            for ($i = 0; $i < $numItems; $i++) {
                // Chọn ngẫu nhiên product_id
                $productId = $products[array_rand($products)];

                // Nếu có biến thể, chọn ngẫu nhiên variant_id hoặc null
                $variantId = $variants ? $variants[array_rand($variants)] : null;

                // Tạo số lượng ngẫu nhiên từ 1 đến 3
                $quantity = rand(1, 3);

                // Giá ngẫu nhiên, bạn có thể tùy chỉnh theo cách tính giá sản phẩm
                $price = DB::table('products')->where('id', $productId)->value('price');

                // Tạo dữ liệu order_item
                $orderItems[] = [
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                    'quantity' => $quantity,
                    'price' => $price,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        // Chèn dữ liệu vào bảng order_items
        DB::table('order_items')->insert($orderItems);
    }
}
