<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use App\Models\Capacity;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public $products;
    public function __construct()
    {
        return $this->products = new Product();
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        // Lấy danh sách sản phẩm cùng với danh mục và các biến thể
        $listProduct = Product::with(['category', 'variants'])
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.page.product.index', ['products' => $listProduct, 'search' => $search]);
    }

    // show biến thể sản phẩm
    public function showVariants($id)
    {
        // $product = Product::with('variants.color', 'variants.capacity')->findOrFail($id);

        $product = Product::withTrashed()->find($id);
        $variants = $product->variants;
        return view('admin.page.product.variants', compact('product', 'variants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colors = Color::all();
        $capacities = Capacity::all();
        $categories = DB::table('categories')->where('status', 1)->get();
        return view('admin.page.product.add', ['categories' => $categories, 'colors' => $colors, 'capacities' => $capacities]);
    }



    public function store(Request $request)
    {
        $validateData = $request->validate([
            'product_code' => 'required',
            'name' => 'required',
            'image_url' => 'nullable|file|mimes:png,jpg,jpeg,gif,webp|max:2048',
            'description' => 'required',
            'category_id' => 'required',
            'variants' => 'required|array',
            'variants.*.color_id' => 'required|exists:colors,id',
            'variants.*.capacity_id' => 'required|exists:capacities,id',
            'variants.*.price_difference' => 'required|nullable|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
        ], [
            'product_code.required' => 'Mã sản phẩm không được để trống.',
            'name.required' => 'Tên sản phẩm không được để trống.',
            'image_url.file' => 'Ảnh sản phẩm phải là một file.',
            'image_url.mimes' => 'Ảnh sản phẩm phải có định dạng: png, jpg, jpeg, hoặc gif.',
            'image_url.max' => 'Ảnh sản phẩm không được vượt quá 2MB.',
            'description.required' => 'Mô tả sản phẩm không được để trống.',
            'category_id.required' => 'Danh mục sản phẩm không được để trống.',
            'variants.required' => 'Biến thể sản phẩm không được để trống.',
            'variants.array' => 'Biến thể sản phẩm phải là một mảng.',
            'variants.*.color_id.required' => 'Màu sắc của biến thể không được để trống.',
            'variants.*.color_id.exists' => 'Màu sắc không tồn tại trong cơ sở dữ liệu.',
            'variants.*.capacity_id.required' => 'Dung lượng của biến thể không được để trống.',
            'variants.*.capacity_id.exists' => 'Dung lượng không tồn tại trong cơ sở dữ liệu.',
            'variants.*.price_difference.required' => 'Giá sản phẩm không được để trống.',
            'variants.*.price_difference.numeric' => 'Giá sản phẩm phải là số.',
            'variants.*.price_difference.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
            'variants.*.stock.required' => 'Số lượng không được để trống.',
            'variants.*.stock.integer' => 'Số lượng phải là một số nguyên.',
            'variants.*.stock.min' => 'Số lượng không được nhỏ hơn 0.',
        ]);

        // kiem tra vong lap bien the
        $seenVariants = [];
        $errors = [];

        foreach ($request->variants as $index => $variant) {
            $key = $variant['color_id'] . '-' . $variant['capacity_id'];

            if (isset($seenVariants[$key])) {
                // Nếu đã tồn tại biến thể với id màu sắc và id dung lượng này thông báo lỗi
                $errors["variants.$index.capacity_id"] = "Dung lượng và màu sắc của biến thể đã bị trùng.";
            } else {
                $seenVariants[$key] = true;
            }
        }

        // Nếu có lỗi thông lỗi
        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        if ($request->hasFile('image_url')) {
            $coverImage = $request->file('image_url')->store('uploads/avtproduct', 'public');
        } else {
            $coverImage = null;
        }

        $product = Product::create([
            'product_code' => $validateData['product_code'],
            'name' => $validateData['name'],
            'image_url' => $coverImage,
            'description' => $validateData['description'],
            'category_id' => $validateData['category_id'],
            'gallery_image' => json_encode([]),
        ]);


        if ($request->hasFile('gallery_image')) {
            $galleryImages = [];
            foreach ($request->file('gallery_image') as $image) {
                $imagePath = $image->store('uploads/product_gallery', 'public');
                $galleryImages[] = $imagePath; //lưu mảng
            }
            // Cập nhật gallery_image
            $product->update(['gallery_image' => json_encode($galleryImages)]);
        }

        // Lưu các biến thể của sản phẩm
        foreach ($request->variants as $variant) {
            ProductVariant::create([
                'product_id' => $product->id,
                'color_id' => $variant['color_id'],
                'capacity_id' => $variant['capacity_id'],
                'price_difference' => $variant['price_difference'] ?? 0,
                'stock' => $variant['stock'],
            ]);
        }


        return redirect()->route('product.index')->with('success', 'Sản phẩm đã được tạo thành công!');
    }



    public function show(string $id)
    {
        // Lấy thông tin sản phẩm và các biến thể
        $product = Product::with('variants.color', 'variants.capacity')->findOrFail($id);

        // Tăng lượt xem
        $product->increment('views');

        // Lọc các biến thể còn hàng
        $availableVariants = $product->variants->filter(function ($variant) {
            return $variant->stock > 0; // Chỉ lấy biến thể có số lượng tồn lớn hơn 0
        });

        // Lấy giá nhỏ nhất từ các biến thể còn hàng
        $minPrice = $availableVariants->min('price_difference');

        // Trả về view với dữ liệu sản phẩm và giá nhỏ nhất
        return view('client.page.detail-product.general', compact(
            'product',
            'minPrice'
        ));
    }



    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = DB::table('categories')->where('status', 1)->get();
        $colors = DB::table('colors')->where('status', 1)->get();
        $capacities = DB::table('capacities')->where('status', 1)->get();

        // Lấy các biến thể của sản phẩm
        $variants = ProductVariant::where('product_id', $id)->get();

        return view('admin.page.product.update', compact('product', 'categories', 'variants', 'colors', 'capacities'));
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'product_code' => 'required',
            'name' => 'required',
            'image_url' => 'nullable|file|mimes:png,jpg,jpeg,gif|max:2048',
            'description' => 'required',
            'category_id' => 'required',
            'variants' => 'required|array',
            'variants.*.color_id' => 'required|exists:colors,id',
            'variants.*.capacity_id' => 'required|exists:capacities,id',
            'variants.*.price_difference' => 'required|nullable|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
        ], [
            'product_code.required' => 'Mã sản phẩm không được để trống.',
            'name.required' => 'Tên sản phẩm không được để trống.',
            'image_url.file' => 'Ảnh sản phẩm phải là một file.',
            'image_url.mimes' => 'Ảnh sản phẩm phải có định dạng: png, jpg, jpeg, hoặc gif.',
            'image_url.max' => 'Ảnh sản phẩm không được vượt quá 2MB.',
            'description.required' => 'Mô tả sản phẩm không được để trống.',
            'category_id.required' => 'Danh mục sản phẩm không được để trống.',
            'variants.required' => 'Biến thể sản phẩm không được để trống.',
            'variants.array' => 'Biến thể sản phẩm phải là một mảng.',
            'variants.*.color_id.required' => 'Màu sắc của biến thể không được để trống.',
            'variants.*.color_id.exists' => 'Màu sắc không tồn tại trong cơ sở dữ liệu.',
            'variants.*.capacity_id.required' => 'Dung lượng của biến thể không được để trống.',
            'variants.*.capacity_id.exists' => 'Dung lượng không tồn tại trong cơ sở dữ liệu.',
            'variants.*.price_difference.required' => 'Giá sản phẩm không được để trống.',
            'variants.*.price_difference.numeric' => 'Giá sản phẩm phải là số.',
            'variants.*.price_difference.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
            'variants.*.stock.required' => 'Số lượng không được để trống.',
            'variants.*.stock.integer' => 'Số lượng phải là một số nguyên.',
            'variants.*.stock.min' => 'Số lượng không được nhỏ hơn 0.',
        ]);

        // kiem tra vong lap bien the
        $seenVariants = [];
        $errors = [];

        foreach ($request->variants as $index => $variant) {
            $key = $variant['color_id'] . '-' . $variant['capacity_id'];

            if (isset($seenVariants[$key])) {
                // Nếu đã tồn tại biến thể với id màu sắc và id dung lượng này thông báo lỗi
                $errors["variants.$index.capacity_id"] = "Dung lượng và màu sắc của biến thể đã bị trùng.";
            } else {
                $seenVariants[$key] = true;
            }
        }

        // Nếu có lỗi thông báo lỗi
        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }


        $product = Product::findOrFail($id);

        $coverImage = null;
        if ($request->hasFile('image_url')) {
            $coverImage = $request->file('image_url')->store('uploads/avtproduct', 'public');
        }

        $product->update([
            'product_code' => $validateData['product_code'],
            'name' => $validateData['name'],
            'image_url' => $coverImage ?? $product->image_url,
            'description' => $validateData['description'],
            'category_id' => $validateData['category_id'],
        ]);

        if ($request->hasFile('gallery_image')) {
            $existingGalleryImages = json_decode($product->gallery_image, true) ?? [];
            $galleryImages = [];

            foreach ($request->file('gallery_image') as $image) {
                $imagePath = $image->store('uploads/product_gallery', 'public');
                $galleryImages[] = $imagePath; // Lưu đường dẫn ảnh vào mảng
            }

            $allGalleryImages = array_merge($existingGalleryImages, $galleryImages);

            // Cập nhật gallery_image
            $product->update(['gallery_image' => json_encode($allGalleryImages)]);
        }
        $existingVariantIds = ProductVariant::where('product_id', $product->id)->pluck('id')->toArray();
        $updatedVariantIds = [];
        // Cập nhật các biến thể
        foreach ($request->variants as $variantData) {
            $variant = ProductVariant::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'color_id' => $variantData['color_id'],
                    'capacity_id' => $variantData['capacity_id'],
                ],
                [
                    'price_difference' => $variantData['price_difference'] ?? 0,
                    'stock' => $variantData['stock'],
                ]
            );

            $updatedVariantIds[] = $variant->id;
        }
        // xóa các biến thể kh có trong danh sách
        $variantsToDelete = array_diff($existingVariantIds, $updatedVariantIds);
        if (!empty($variantsToDelete)) {
            ProductVariant::whereIn('id', $variantsToDelete)->delete();
        }

        return redirect()->route('product.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }






    public function destroy(string $id)
    {
        $product = Product::FindorFail($id);

        $product->delete();

        return redirect()->route('product.index');
    }

    public function trashed(Request $request)
    {
        // $listProduct = Product::onlyTrashed()->with('category')->paginate(10);

        // return view('admin.page.product.trashed', ['products' => $listProduct]);


        $search = $request->input('search');

        // Tìm kiếm sản phẩm đã bị xóa
        $query = Product::onlyTrashed()->with('category');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('product_code', 'LIKE', '%' . $search . '%');
            });
        }

        $listProduct = $query->paginate(10);

        return view('admin.page.product.trashed', ['products' => $listProduct]);
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('product.trashed')->with('success', 'Sản phẩm đã được khôi phục thành công');
    }

    public function getProductsByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();

        return view('products.by-category', compact('products'));
    }
    public function filterProducts(Request $request)
    {
        // Xử lý các tham số lọc từ yêu cầu
        $query = Product::query();

        // Lọc theo category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo giá
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Lọc theo dung lượng
        if ($request->has('capacities') && !empty($request->capacities)) {
            $query->whereIn('capacity_id', $request->capacities);
        }

        // Lọc theo màu sắc
        if ($request->has('colors') && !empty($request->colors)) {
            $query->whereIn('color_id', $request->colors);
        }

        // Lấy sản phẩm đã lọc
        $products = $query->get();

        // Trả về danh sách sản phẩm dưới dạng HTML (có thể thay đổi tùy theo nhu cầu)
        $html = view('partials.product-list', compact('products'))->render();

        return response()->json(['html' => $html]);
    }
    public function showProductReviews($id) 
        {
    
            $product = Product::findOrFail($id);
    
     
            $reviews = Review::where('product_id', $id)->get();
    
         
            $reviewCount = $reviews->count();
    
          
            $averageRating = $reviews->avg('rating') ?? 0;
    

            return view('client.page.detail-product.general', compact('product','reviews','reviewCount','averageRating' ));
        }


}
