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
        // Lấy tất cả các category
        $categories = Category::all();

        // Mảng tên file ảnh
        $images = [
            'img-1.png', 'img-2.png', 'img-3.png', 'img-4.png', 'img-5.png',
            'img-6.png', 'img-7.png', 'img-8.png', 'img-9.png', 'img-10.png'
        ];

        // Chèn 10 sản phẩm với ảnh ngẫu nhiên
        $products = [];
        for ($i = 0; $i < 10; $i++) {
            $products[] = [
                'name' => 'Product ' . ($i + 1),
                'category_id' => $categories->random()->id, // Chọn ngẫu nhiên một category từ bảng categories
                'description' => 'Mô tả chi tiết về sản phẩm Product ' . ($i + 1) . '.',
                'gallery_image' => asset('assets/images/products/' . $images[array_rand($images)]), // Chọn ngẫu nhiên ảnh từ mảng
                'gallery_images' => json_encode([
                    asset('assets/images/products/' . $images[array_rand($images)]),
                    asset('assets/images/products/' . $images[array_rand($images)])
                ]),
                'image_url' => asset('assets/images/products/' . $images[array_rand($images)]), // Chọn ngẫu nhiên ảnh chính
                'price' => rand(1000000, 30000000), // Giá ngẫu nhiên từ 1 triệu đến 30 triệu
                'product_code' => 'PROD' . str_pad($i + 1, 3, '0', STR_PAD_LEFT), // Mã sản phẩm
                'views' => rand(50, 500), // Lượt xem ngẫu nhiên
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ];
        }

        // Chèn dữ liệu vào bảng products
        DB::table('products')->insert($products);
    }
}
