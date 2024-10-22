<?php

namespace App\Http\Controllers;

use App\Models\News;
use Carbon\Carbon;
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
        foreach ($listNews as $news) {
            // Kiểm tra xem trạng thái có phải là "Đã lên lịch" không và ngày đã đến chưa
            if ($news->status === 'Đã lên lịch' && $news->scheduled_at <= Carbon::now()) {
                // Cập nhật trạng thái thành "Công khai"
                $news->status = 'Công khai';
                $news->published_at = Carbon::now(); // Ghi lại ngày hiện tại
                $news->save(); // Lưu lại thay đổi
            }
        return view('admin.page.new.index', compact('listNews'));
    }
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
            'status' => 'required|string|in:Công khai,Đã lên lịch,Bản nháp',
            'author_id'=>'required'
        ]);

        if ($request->hasFile('thumbnail')) {
            // Lưu file vào thư mục 'uploads/news_img' trong 'storage/app/public'
            $thumbnail = $request->file('thumbnail')->store('uploads/news_img', 'public');
        }
        $publishedAt = null;
$scheduledAt = null;
        // Xử lý trạng thái
        if ($validateData['status'] === 'Công khai') {
            $publishedAt = now(); // Đặt ngày hiện tại
        } elseif ($validateData['status'] === 'Đã lên lịch') {
            $scheduledAt = $request->input('scheduled_at'); // Lấy ngày đã lên lịch từ request
        }
        $news = News::create([
            'title' => $validateData['title'],
            'thumbnail' => $thumbnail, // Sử dụng biến $thumbnail đã được lưu
            'short_content' => $validateData['short_content'],
            'content' => $validateData['content'],
            'category_news_id' => $validateData['category_news_id'],
            'published_at' => $publishedAt,
            'status' => $validateData['status'],
             'author_id'=>$validateData['author_id'],
             'scheduled_at' => $scheduledAt,
             
        ]);

        return redirect()->route('new.index')->with('success', 'Tin tức đã được lưu thành công!');
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
    public function clientShow1($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();
        return view('client.page.news.news', compact('news'));
    }
}
