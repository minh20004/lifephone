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
        $latestProducts = Product::with([
            'category:id,name', // Eager load danh mục với id và name
            'variants.color:id,name', // Eager load màu sắc (color) thông qua biến thể sản phẩm
            'variants.capacity:id,name'
        ])
            ->orderBy('created_at', 'desc') // Lấy theo thứ tự mới nhất
            ->take(10) // Giới hạn 10 sản phẩm
            ->get();

        // Trả về view với các dữ liệu cần thiết
        return view('client.categories.shop-catalog', compact('latestProducts', 'categories', 'colors', 'capacities'));
    }


    public function getProducts($id)
    {
        $category = Category::find($id);
        $products = $category->products;
        return view('categories.products', compact('products'));
    }
    public function filter(Request $request)
    {
        $query = Product::with(['variants', 'variants.color', 'variants.capacity']);

        // Lọc theo danh mục
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo khoảng giá
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // Lọc theo dung lượng
        if ($request->has('capacity_ids')) {
            $query->whereIn('capacity_id', $request->capacity_ids);
        }

        // Lọc theo màu sắc
        if ($request->has('color_id')) {
            $query->where('color_id', $request->color_id);
        }

        // Lấy danh sách sản phẩm đã lọc
        $products = $query->get();

        // Trả về danh sách sản phẩm dưới dạng JSON
        return response()->json($products);
    }
}
