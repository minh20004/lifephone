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



    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $listCategory = Category::where('name', 'LIKE', "%{$search}%");
        } else {
            $listCategory = Category::paginate(5);
        }

        return view('admin.page.category.index', ['categories' => $listCategory, 'search' => $search]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.page.category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:categories,name',
        ],[
            'name.required' => 'Vui lòng nhập tên danh mục!',
            'name.unique' => 'Tên danh mục này đã tồn tại!',
        ]);

        $this->categories->create([
            'name' => $validateData['name'],
        ]);

        // sử lý thêm danh mục bên add sản phẩm
        if ($request->ajax()) {
            return response()->json(['success' => 'Danh mục đã được thêm thành công!']);
        }

        return redirect()->route('category.index')->with('success','Danh mục đã được thêm thành công !');
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
        $category = Category::FindOrFail($id);
        return view('admin.page.category.update', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::FindOrFail($id);
        
        $validateData = $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
        ],[
            'name.required' => 'Vui lòng nhập tên danh mục!',
            'name.unique' => 'Tên danh mục này đã tồn tại!',
        ]);

        

        $category->update([
            'name' => $validateData['name'],
        ]);


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

        $category->status = 0;
        $category->save();

        $category->delete();
        return redirect()->route('category.index')->with('success', 'Danh mục đã được xóa thành công.');
    }

    public function trashed()
    {
        $categories = Category::onlyTrashed()->paginate(5);

        return view('admin.page.category.trashed', compact('categories'));
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();

        $category->status = 1;
        $category->save();
        return redirect()->route('category.trashed')->with('success', 'Danh mục đã được khôi phục thành công.');
    }
}
