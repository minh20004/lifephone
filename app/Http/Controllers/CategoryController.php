<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public $categories;

    public function __construct()
    {
        $this->categories = new Category();
    }


    public function index()
    {
        $listCategory = $this->categories->getAll();
        return view('admin.page.category.index', ['categories' => $listCategory]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.page.category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Kiểm tra nếu danh mục đã tồn tại
    $existingCategory = $this->categories->where('name', $request->name)->first();

    if ($existingCategory) {
        // Nếu danh mục đã tồn tại, trả về thông báo lỗi
        if ($request->ajax()) {
            return response()->json(['error' => 'Danh mục đã tồn tại!'], 400);
        }

        return redirect()->route('category.index')->with('error', 'Danh mục đã tồn tại!');
    }
    
        $this->categories->create([
            'name' => $request->name,
        ]);

        // Nếu là AJAX request, trả về phản hồi JSON
    if ($request->ajax()) {
        return response()->json(['success' => 'Danh mục đã được thêm thành công!']);
    }
        
        return redirect()->route('category.index');
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
        $category = $this->categories->find($id);
        return view('admin.page.category.update', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = $this->categories->find($id);

        $dataUpdateCate = [
            'name' => $request->name,
        ];

        $category->updateCategory($dataUpdateCate, $id);

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {


        $category = Category::FindorFail($id);

        if ($category->products()->withTrashed()->count() > 0) {
            return redirect()->route('category.index')->with('error', 'Không thể xóa danh mục vì vẫn còn sản phẩm trong danh mục này.');
        }

        $category->delete();
        return redirect()->route('category.index')->with('success', 'Danh mục đã được xóa thành công.');
    }

    public function trashed()
    {
        $categories = Category::onlyTrashed()->get();

        return view('admin.page.category.trashed', compact('categories'));
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('category.trashed')->with('success', 'Danh mục đã được khôi phục thành công.');
    }
}
