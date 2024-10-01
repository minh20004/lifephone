<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
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

        $product = Product::create([
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

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
    
    }

    public function restore($id){
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('product.trashed')->with('success','Sản phẩm đã được khôi phục thành công');
    }

    
}
