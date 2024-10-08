<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
<<<<<<< HEAD
    /**
     * Display a listing of the resource.
     */
=======
    
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6

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

        return view('admin.page.product.index', ['products' => $listProduct , 'search' => $search]);

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = DB::table('categories')->get();
        return view('admin.page.product.add', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    

    public function store(Request $request)
    {
        $validateData = $request->validate([
<<<<<<< HEAD
            'product_code' => 'required',
            'name' => 'required',
            'image_url' => 'nullable|file|mimes:png,jpg,jpeg,gif|max:2048',
            'price' => 'required',
            'description' =>'required',
            'category_id' => 'required',
        ]);

        if($request->hasFile('image_url')){
            $coverImage = $request->file('image_url')->store('uploads/avtproduct', 'public');
        }else{
            $coverImage = null;
        }

=======
            'product_code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|file|mimes:png,jpg,jpeg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'gallery_image.*' => 'nullable|file|mimes:png,jpg,jpeg,gif|max:2048', 
        ]);
    
        $coverImage = null;
        if ($request->hasFile('image_url')) {
            $coverImage = $request->file('image_url')->store('uploads/avtproduct', 'public');
        }
    
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
        $product = Product::create([
            'product_code' => $validateData['product_code'],
            'name' => $validateData['name'],
            'image_url' => $coverImage,
            'price' => $validateData['price'],
<<<<<<< HEAD
            'description' =>$validateData['description'],
            'category_id' => $validateData['category_id'],
        ]);
        // $product = Product::create($dataInsertProduct);
        return redirect()->route('product.index');
=======
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
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
    }
   

    


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

<<<<<<< HEAD
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $product = Product::FindorFail($id);
        // $product = $this->products->find($id);
        $categories= DB::table('categories')->get();
        return view('admin.page.product.update', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'product_code' => 'required',
            'name' => 'required',
            'image_url' => 'nullable|file|mimes:png,jpg,jpeg,gif|max:2048',
            'price' => 'required',
            'description' =>'required',
            'category_id' => 'required',
        ]);

        $product = Product::FindorFail($id);

        if($request->hasFile('image_url')){
            if($product->image_url){
                Storage::disk('public')->delete($product->image_url);
            }
            $coverImage = $request->file('image_url')->store('uploads/avtproduct', 'public');
        }else{
            $coverImage = $product->image_url;
        }

        $product->update([
            'product_code' => $validateData['product_code'],
            'name' => $validateData['name'],
            'image_url' => $coverImage,
            'price' => $validateData['price'],
            'description' =>$validateData['description'],
            'category_id' => $validateData['category_id'],
        ]);
        // $product = Product::create($dataInsertProduct);
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $product = $this->products->find($id);

        // if(!$product){
        //     return redirect()->route('product.index');
        // }

        // if($product->image_url){
        //     Storage::disk('public')->delete($product->image_url);
        // }

        // $product->delete();

        $product = Product::FindorFail($id);

        $product->delete();

        return redirect()->route('product.index');
    }

    public function trashed(){
        $listProduct = Product::onlyTrashed()->with('category')->get();

        return view('admin.page.product.trashed', ['products' => $listProduct]);
    
=======
    
    public function edit(string $id)
    {
        $product = Product::FindorFail($id);
        $categories= DB::table('categories')->get();
        return view('admin.page.product.update', compact('product', 'categories'));
    }

   
    

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'product_code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
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

            // Gộp các ảnh cũ với ảnh mới
            $allGalleryImages = array_merge($existingGalleryImages, $galleryImages);

            // Cập nhật gallery_image
            $product->update(['gallery_image' => json_encode($allGalleryImages)]);
        }

        return redirect()->route('product.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }



    
    public function destroy(string $id)
    {
        $product = Product::FindorFail($id);

        $product->delete();

        return redirect()->route('product.index');
    }

    public function trashed(Request $request){
        $listProduct = Product::onlyTrashed()->with('category')->paginate(10);

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
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
    }

    public function restore($id){
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('product.trashed')->with('success','Sản phẩm đã được khôi phục thành công');
    }

    
}
