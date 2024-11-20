<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Category;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        // Nếu không có danh mục nào, dừng việc chèn sản phẩm
        if ($categories->isEmpty()) {
            return;
        }

        // Thêm sản phẩm mẫu vào bảng 'products'
        DB::table('products')->insert([
            [
                'name' => 'iPhone 14 Pro Max',
                'category_id' => $categories->random()->id, // Chọn ngẫu nhiên một category từ bảng categories
                'description' => 'Mô tả chi tiết về sản phẩm iPhone 14 Pro Max.',
                'gallery_image' => 'https://example.com/path/to/gallery_image1.jpg',
                'gallery_images' => json_encode(['https://example.com/path/to/gallery_image1.jpg', 'https://example.com/path/to/gallery_image2.jpg']),
                'image_url' => 'https://example.com/path/to/image.jpg',
                'price' => 10990000.00,
                'product_code' => 'IP14PM123',
                'views' => 150,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],
            [
                'name' => 'Samsung Galaxy S22 Ultra',
                'category_id' => $categories->random()->id, // Chọn ngẫu nhiên một category từ bảng categories
                'description' => 'Mô tả chi tiết về sản phẩm Samsung Galaxy S22 Ultra.',
                'gallery_image' => 'https://example.com/path/to/gallery_image3.jpg',
                'gallery_images' => json_encode(['https://example.com/path/to/gallery_image3.jpg', 'https://example.com/path/to/gallery_image4.jpg']),
                'image_url' => 'https://example.com/path/to/image2.jpg',
                'price' => 27990000.00,
                'product_code' => 'SGS22U123',
                'views' => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],
            [
                'name' => 'Xiaomi 13 Pro',
                'category_id' => $categories->random()->id, // Chọn ngẫu nhiên một category từ bảng categories
                'description' => 'Mô tả chi tiết về sản phẩm Xiaomi 13 Pro.',
                'gallery_image' => 'https://example.com/path/to/gallery_image5.jpg',
                'gallery_images' => json_encode(['https://example.com/path/to/gallery_image5.jpg', 'https://example.com/path/to/gallery_image6.jpg']),
                'image_url' => 'https://example.com/path/to/image3.jpg',
                'price' => 15990000.00,
                'product_code' => 'XM13P123',
                'views' => 120,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
