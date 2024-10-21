<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use App\Models\Capacity;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    

    public $products;
    public function __construct()
    {
        return $this->products = new Product();
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        // $listProduct = $this->products->with('category')->paginate(10);
        $listProduct = $this->products
        ->with('category')
        ->when($search, function($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('product_code', 'like', "%{$search}%");
        })
        ->paginate(10);

        return view('admin.page.product.index', ['products' => $listProduct, 'search' => $search]);
    }

        
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

    /**
     * Store a newly created resource in storage.
     */
    

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'product_code' => 'required',
            'name' => 'required',
            'image_url' => 'nullable|file|mimes:png,jpg,jpeg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'gallery_image.*' => 'nullable|file|mimes:png,jpg,jpeg,gif|max:2048', 
        ]);
    
        $coverImage = null;
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

    
        return redirect()->route('product.index')->with('success', 'Sản phẩm đã được tạo thành công!');
    }
   

    


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'gallery_image.*' => 'nullable|file|mimes:png,jpg,jpeg,gif|max:2048', 
        ]);

        $product = Product::findOrFail($id);

        $coverImage = null;
        if ($request->hasFile('image_url')) {
            $coverImage = $request->file('image_url')->store('uploads/avtproduct', 'public');
        }

        $product->update([
            'product_code' => $validateData['product_code'],
            'name' => $validateData['name'],
            'image_url' => $coverImage ?? $product->image_url, 
            'price' => $validateData['price'],
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
        

        // $search = $request->input('search');
        // $listProduct = $this->products
        // ->with('category')
        // ->when($search, function($query) use ($search) {
        //     return $query->where('name', 'like', "%{$search}%")
        //                  ->orWhere('product_code', 'like', "%{$search}%");
        // })
        // ->paginate(10);

        // return view('admin.page.product.trashed', ['products' => $listProduct , 'search' => $search]);
    }

    public function restore($id){
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('product.trashed')->with('success', 'Sản phẩm đã được khôi phục thành công');
    }

    
}
