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

        // Lấy các sản phẩm, phân trang và load danh mục, biến thể sản phẩm với màu sắc
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
            ->paginate(9); // Phân trang 10 sản phẩm mỗi trang

        // Trả về view với các dữ liệu cần thiết
        return view('client.categories.shop-catalog', compact('latestProducts', 'categories', 'colors', 'capacities'));
    }


    public function getProductsByCategory($id, $colorId = null)
    {
        // Lấy danh sách danh mục kèm số lượng sản phẩm
        $categories = Category::withCount('products')->get();

        // Lấy danh sách màu sắc và dung lượng
        $colors = Color::all();
        $capacities = Capacity::withCount('products')->get();

        // Lọc sản phẩm theo danh mục `$id` và lấy thông tin từ bảng `product_variants`
        $productsByCategory = Product::where('category_id', $id)
            ->when($colorId, function ($query) use ($colorId) {
                $query->where('color_id', $colorId);
            })
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
            ->paginate(9);

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
    public function filter(Request $request)
{
    $products = Product::whereIn('capacity_id', $request->capacities)->get();
    return response()->json($products);
}



// public function getProductsByCategory($id)
    // {
    //     $products = Product::where('category_id', $id)->get();
    //     dd($products); // Dừng lại và hiển thị kết quả
    // }
    public function search(Request $request)
    {
        $searchTerm = $request->query('search');

        // Lấy tất cả danh mục, màu sắc và dung lượng (nếu cần)
        $categories = Category::withCount('products')->get();
        $colors = Color::all();
        $capacities = Capacity::withCount('products')->get();

        // Lấy danh sách sản phẩm cùng với danh mục và các biến thể
        $latestProducts = Product::with([
            'category:id,name', // Eager load danh mục với id và name
            'variants.color:id,name', // Eager load màu sắc (color) thông qua biến thể sản phẩm
            'variants.capacity:id,name' // Eager load dung lượng (capacity)
        ])
        ->when($searchTerm, function ($query) use ($searchTerm) {
            return $query->where(function($q) use ($searchTerm) {
                // Tìm kiếm trong tên, mã sản phẩm và mô tả
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('product_code', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhereHas('category', function($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('variants.color', function($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('variants.capacity', function($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        })
        ->orderByRaw('CASE WHEN name LIKE ? THEN 0 ELSE 1 END', ["%{$searchTerm}%"])
        ->orderByRaw('CASE WHEN product_code LIKE ? THEN 0 ELSE 1 END', ["%{$searchTerm}%"])
        ->orderBy('category_id')
        ->paginate(10);

        return view('client.categories.searchProduct', compact('latestProducts', 'categories', 'colors', 'capacities'));
    }
}