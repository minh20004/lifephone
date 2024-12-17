<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Capacity;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class ApiProductController extends Controller
{
    public function getSearchSuggestions(Request $request)
    {
        $searchTerm = $request->query('search');

        $product = Product::where('name', 'like', "%{$searchTerm}%")
            ->orWhere('product_code', 'like', "%{$searchTerm}%")
            ->orWhere('description', 'like', "%{$searchTerm}%")
            ->first();  // Chỉ lấy sản phẩm đầu tiên tìm được

        if (!$product) {
            // Nếu không tìm thấy sản phẩm nào, trả về mảng rỗng
            return response()->json([
                'suggestions' => []
            ]);
        }

        if (!$searchTerm) {
            return response()->json([], 400);
        }

        $suggestions = Product::where('category_id', $product->category_id)  // Lọc sản phẩm cùng danh mục
        ->where('id', '!=', $product->id)  // Loại trừ sản phẩm hiện tại (nếu tìm thấy)
        ->take(5)  // Lấy tối đa 5 gợi ý
        ->get(['id', 'name', 'product_code', 'description']);

        return response()->json([
            'suggestions' => $suggestions
        ]);
    }

    public function getTopProductsForSearch()
    {
        $topProducts = Product::orderBy('views', 'desc') // Sắp xếp theo lượt xem giảm dần
                                ->limit(4)             // Lấy 4 sản phẩm đầu tiên
                                ->get(['id', 'name', 'image_url']); // Chỉ lấy các trường id, name, image_url

        return response()->json($topProducts); // Trả về kết quả dưới dạng JSON
    }




}
