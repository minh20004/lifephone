<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listNews = News::all();
        return view('admin.page.new.index', compact('listNews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category_news = DB::table('category_news')->get();
        $author_id = DB::table('users')->get();
        return view('admin.page.new.create', ['category_news' => $category_news], ['author_id' => $author_id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|file|mimes:jpeg,png,gif|max:2048', // Giới hạn kích thước và kiểu file
            'content' => 'required|string',
            'short_content' => 'required|string|max:100',
            'category_news_id' => 'required|integer|exists:categories,id',
            'published_at' => 'required|date',
            'status' => 'required|string|in:Công khai,Đã lên lịch,Bản nháp',
            'author_id'=>'required'
        ]);

        if ($request->hasFile('thumbnail')) {
            // Lưu file vào thư mục 'uploads/news_img' trong 'storage/app/public'
            $thumbnail = $request->file('thumbnail')->store('uploads/news_img', 'public');
        }

        $news = News::create([
            'title' => $validateData['title'],
            'thumbnail' => $thumbnail, // Sử dụng biến $thumbnail đã được lưu
            'short_content' => $validateData['short_content'],
            'content' => $validateData['content'],
            'category_news_id' => $validateData['category_news_id'],
            'published_at' => $validateData['published_at'],
            'status' => $validateData['status'],
             'author_id'=>$validateData['author_id']
        ]);

        return redirect()->route('new.create')->with('success', 'Tin tức đã được lưu thành công!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function clientIndex()
    {
        // Lấy tất cả các bản tin có trạng thái 'Công khai'
        $allNews = News::where('status', 'Công khai')
            ->paginate(6); // Sử dụng paginate để giới hạn 10 bản tin mỗi trang
        $mostViewedNews = News::where('status', 'Công khai')
            ->orderBy('views', 'desc')
            ->first();

        // Lấy 3 bài viết tiếp theo có lượt xem cao sau bài viết nhiều view nhất
        $additionalMostViewedNews = News::where('status', 'Công khai')
            ->where('id', '!=', $mostViewedNews->id) // Loại bỏ bài viết có nhiều view nhất
            ->orderBy('views', 'desc')
            ->take(3)
            ->get();
            
            $latestNews = News::latest()->take(5)->get();
            
        // Lấy 3 bản tin có trạng thái 'Công khai' và lượt xem cao nhất
        return view('client.page.news.news', compact('allNews', 'additionalMostViewedNews', 'mostViewedNews','latestNews'));
    }


    // Phương thức cho client - Hiển thị chi tiết một bản tin
    public function clientShow($id)
    {
        $news = News::findOrFail(id: $id);
        $latestNews = News::where('id', '!=', $id) // Tránh lấy bài viết hiện tại
        ->orderBy('published_at', 'desc') // Sắp xếp theo ngày xuất bản giảm dần
        ->take(6) // Giới hạn số lượng bài viết mới nhất (có thể điều chỉnh theo ý muốn)
        ->get();
        
        return view('client.page.news.news', compact('news','latestNews'));
    }
}
