<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $listCategory = Category::paginate(10);
        }

        return view('admin.page.category.index', ['categories' => $listCategory, 'search' => $search]);
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.page.category.add');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,web|max:2048', // Validate ảnh
            'image_page' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,web|max:2048', // Validate ảnh page
        ]);

        // Kiểm tra nếu danh mục đã tồn tại
        $existingCategory = $this->categories->where('name', $request->name)->first();

        if ($existingCategory) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Danh mục đã tồn tại!'], 400);
            }
            return redirect()->route('category.index')->with('error', 'Danh mục đã tồn tại!');
        }

        // Xử lý upload ảnh
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        // Xử lý ảnh page
        $imagePagePath = null;
        if ($request->hasFile('image_page')) {
            $imagePagePath = $request->file('image_page')->store('categories', 'public');
        }

        $this->categories->create([
            'name' => $validateData['name'],
            'image' => $imagePath,
            'image_page' => $imagePagePath, // Lưu ảnh page
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => 'Danh mục đã được thêm thành công!']);
        }

        return redirect()->route('category.index')->with('success', 'Danh mục đã được thêm thành công!');
    }


    public function edit(string $id)
    {
        $category = Category::FindOrFail($id);
        return view('admin.page.category.update', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $category = Category::FindOrFail($id);

        $validateData = $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,web|max:2048', // Validate ảnh
            'image_page' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,web|max:2048', // Validate ảnh page
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục!',
            'name.unique' => 'Tên danh mục này đã tồn tại!',
        ]);

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $category->image = $request->file('image')->store('categories', 'public');
        }

        // Xử lý ảnh page
        if ($request->hasFile('image_page')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($category->image_page) {
                Storage::disk('public')->delete($category->image_page);
            }
            $category->image_page = $request->file('image_page')->store('categories', 'public');
        }

        $category->update([
            'name' => $validateData['name'],
            'image' => $category->image,
            'image_page' => $category->image_page, // Cập nhật ảnh page
        ]);

        return redirect()->route('category.index');
    }


    public function destroy(string $id)
    {
        $category = Category::FindorFail($id);

        if ($category->products()->withTrashed()->count() > 0) {
            return redirect()->route('category.index')->with('error', 'Không thể xóa danh mục vì vẫn còn sản phẩm trong danh mục này.');
        }

        // Xóa ảnh nếu có
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
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
