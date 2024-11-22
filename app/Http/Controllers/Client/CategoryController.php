<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Capacity;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class   CategoryController extends Controller
{
    // Phương thức lấy tất cả các danh mục

    // Phương thức lấy 10 sản phẩm mới nhất cùng với thông tin danh mục của chúng
    public function shop()
    {
        // Lấy danh sách các danh mục và đếm số lượng sản phẩm trong mỗi danh mục
        $categories = Category::withCount('products')->get();
        $colors = Color::all();
        $capacities = Capacity::withCount('products')->get();

        // Lấy 10 sản phẩm mới nhất và load danh mục và biến thể sản phẩm với màu sắc
        // Lấy 10 sản phẩm mới nhất, load danh mục, biến thể sản phẩm cùng giá và màu sắc
        $latestProducts = Product::with([
            'variants' => function ($query) {
                $query->select('id', 'product_id', 'price_difference', 'color_id', 'capacity_id') // Lấy giá và các thông tin cần thiết
                    ->with([
                        'color:id,name',     // Thông tin màu sắc
                        'capacity:id,name'  // Thông tin dung lượng
                    ]);
            }
        ])
            ->select('id', 'name', 'image_url', 'category_id') // Chỉ lấy các cột cần thiết từ bảng products
            ->orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo
            ->take(10) // Giới hạn 10 sản phẩm mới nhất
            ->get();
        // Trả về view với các dữ liệu cần thiết
        return view('client.categories.shop-catalog', compact('latestProducts', 'categories', 'colors', 'capacities'));
    }


    public function getProductsByCategory($id)
    {
        // Lấy danh sách danh mục kèm số lượng sản phẩm
        $categories = Category::withCount('products')->get();

        // Lấy danh sách màu sắc và dung lượng
        $colors = Color::all();
        $capacities = Capacity::withCount('products')->get();

        // Lọc sản phẩm theo danh mục `$id` và lấy thông tin từ bảng `product_variants`
        $productsByCategory = Product::where('category_id', $id)
            ->with([
                'category:id,name', // Lấy thông tin danh mục (id, name)
                'variants' => function ($query) {
                    $query->select('id', 'product_id', 'price_difference', 'color_id', 'capacity_id')
                        ->with([
                            'color:id,name',     // Thông tin màu sắc
                            'capacity:id,name'  // Thông tin dung lượng
                        ]);
                }
            ])
            ->select('id', 'name', 'image_url', 'category_id') // Chỉ lấy các cột cần thiết từ bảng products
            ->orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo
            ->get();

        // Lấy thông tin danh mục hiện tại
        $currentCategory = Category::findOrFail($id);
        // Lấy số lượng sản phẩm trong danh mục
        $productCount = Product::where('category_id', $id)->count();

        // Trả về view với các dữ liệu cần thiết
        return view('client.categories.products', compact(
            'productsByCategory',
            'categories',
            'colors',
            'capacities',
            'currentCategory',
            'productCount'
        ));
    }
}
