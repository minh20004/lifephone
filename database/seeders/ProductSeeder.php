<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Product A',
                'description' => 'Description for product A',
                'price' => 100.00,
                // 'stock' => 10,
                'category_id' => 1, // Giả sử bạn đã có danh mục với ID 1
                'image_url' => 'product-a.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product B',
                'description' => 'Description for product B',
                'price' => 150.50,
                // 'stock' => 20,
                'category_id' => 1,
                'image_url' => 'product-b.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product C',
                'description' => 'Description for product C',
                'price' => 200.00,
                // 'stock' => 5,
                'category_id' => 2, // Giả sử danh mục có ID 2
                'image_url' => 'product-c.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}