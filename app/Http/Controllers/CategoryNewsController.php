<?php

namespace App\Http\Controllers;

use App\Models\Category_new;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryNewsController extends Controller
{
    protected $Category_new;

    public function __construct(Category_new $Category_new)
    {
        $this->Category_new = $Category_new;
    }
    
    public function index()
    {
        // Sử dụng paginate để phân trang với 10 mục mỗi trang
        $cate_news = $this->Category_new->paginate(5);
    
        // Trả về view với dữ liệu phân trang
        return view('admin.page.category_news.index', compact('cate_news'));
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
        $slug = Str::slug($validateData['title']);

        $this->Category_new->create([
            'title' => $validateData['title'],
            'slug' => $slug,
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
    public function destroy($id)
{
    $Category_new = Category_new::findOrFail($id);

    // Kiểm tra nếu có tin tức liên quan
    if ($Category_new->News()->withTrashed()->count() > 0) {
        return redirect()->route('category_news.index')->with('error', 'Không thể xóa danh mục vì vẫn còn sản phẩm trong danh mục này.');
    }

    // Đánh dấu trạng thái là 0 trước khi xóa
    $Category_new->status = 0;
    $Category_new->save();

    // Xóa mềm danh mục
    $Category_new->delete();

    return redirect()->route('category_news.index')->with('success', 'Danh mục đã được xóa thành công.');
}

    public function categorynewsblog($slug)
    {
        // Tìm danh mục theo slug
        $category = Category_new::where('slug', $slug)->firstOrFail();
        
        // Lấy tất cả bài viết thuộc danh mục này
        $posts = $category->news;  // Giả sử bạn đã thiết lập mối quan hệ với News model

        return view('client.page.category.show', compact('category', 'posts'));
    }
    public function trashed()
    {
        $trashedNews = Category_new::onlyTrashed()->paginate(10);

        return view('admin.page.category_news.trashed', compact('trashedNews'));
    }

    public function restore($id)
    {
        $news = Category_new::withTrashed()->findOrFail($id);

        if ($news->trashed()) {
            $news->restore();
            return redirect()->route('category_news.trashed')->with('success', 'Danh mục tin tức đã được khôi phục.');
        }

        return redirect()->route('category_news.trashed')->with('error', 'Danh mục tin tức không nằm trong thùng rác.');
    }
}
