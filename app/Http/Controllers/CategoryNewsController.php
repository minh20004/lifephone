<?php

namespace App\Http\Controllers;

use App\Models\Category_new;
use Illuminate\Http\Request;

class CategoryNewsController extends Controller
{
    protected $Category_new;

    public function __construct(Category_new $Category_new)
    {
        $this->Category_new = $Category_new;
    }
    public function index()
    {
        $cate = Category_new::all();
        return view('admin.page.category_news.index', compact('cate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Category_news = Category_new::where('status', 1)->get();
        return view('admin.page.Category_news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required|unique:Category_news,title',
        ]);


if ($this->Category_new) {
    $existingCategory = $this->Category_new->where('title', $request->title)->first();
} else {
    // Xử lý khi Category_new là null, ví dụ như báo lỗi
    return response()->json(['error' => 'Category_new chưa được khởi tạo.']);
}
        // Kiểm tra nếu danh mục đã tồn tại
        $existingCategory = $this->Category_new->where('title', $request->title)->first();

        if ($existingCategory) {
            // Nếu danh mục đã tồn tại, trả về thông báo lỗi
            if ($request->ajax()) {
                return response()->json(['error' => 'Danh mục đã tồn tại!'], 400);
            }

            return redirect()->route('category_news.index')->with('error', 'Danh mục đã tồn tại!');
        }

        $this->Category_new->create([
            'title' => $validateData['title'],
        ]);

        // sử lý thêm danh mục bên add sản phẩm
        if ($request->ajax()) {
            return response()->json(['success' => 'Danh mục đã được thêm thành công!']);
        }

        return redirect()->route('category_news.index')->with('success', 'Danh mục đã được thêm thành công !');
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
        $Category_new = Category_new::FindOrFail($id);
        return view('admin.page.Category_news.update', compact('Category_new'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Category_new = Category_new::FindOrFail($id);

        $validateData = $request->validate([
            'title' => 'required|unique:category_news,title,' . $Category_new->id,
        ], [
            'title.required' => 'Vui lòng nhập tên danh mục!',
            'title.unique' => 'Tên danh mục này đã tồn tại!',
        ]);



        $Category_new->update([
            'title' => $validateData['title'],
        ]);


        return redirect()->route('category_news.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Category_new = Category_new::FindorFail($id);

        if ($Category_new->News()->withTrashed()->count() > 0) {
            return redirect()->route('Category_new.index')->with('error', 'Không thể xóa danh mục vì vẫn còn sản phẩm trong danh mục này.');
        }

        $Category_new->status = 0;
        $Category_new->save();

        $Category_new->delete();
        return redirect()->route('Category_new.index')->with('success', 'Danh mục đã được xóa thành công.');
    }
}
