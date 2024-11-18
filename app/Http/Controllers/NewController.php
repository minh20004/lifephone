<?php

namespace App\Http\Controllers;

use App\Models\Category_new;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class NewController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listNews = News::paginate(10);
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
        // Validate dữ liệu từ request
        $validateData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'author_id' => 'required|exists:users,id',
            'thumbnail' => 'nullable|file|mimes:png,jpg,jpeg,gif|max:2048',
            'category_news_id' => 'required|exists:category_news,id',
            'status' => 'required|in:Công khai,Đã lên lịch,Bản nháp',
            'published_at' => 'nullable|date',
            'views' => 'nullable|integer|min:0',
            'short_content' => 'nullable|string',
            'scheduled_at' => 'nullable|date|after_or_equal:today',
        ], [
            'title.required' => 'Tiêu đề không được để trống.',
            'content.required' => 'Nội dung không được để trống.',
            'author_id.required' => 'Tác giả không được để trống.',
            'author_id.exists' => 'Tác giả không tồn tại trong cơ sở dữ liệu.',
            'thumbnail.file' => 'Ảnh đại diện phải là một file.',
            'thumbnail.mimes' => 'Ảnh đại diện phải có định dạng: png, jpg, jpeg, hoặc gif.',
            'thumbnail.max' => 'Ảnh đại diện không được vượt quá 2MB.',
            'category_news_id.required' => 'Danh mục tin tức không được để trống.',
            'category_news_id.exists' => 'Danh mục tin tức không tồn tại trong cơ sở dữ liệu.',
            'status.required' => 'Tình trạng tin tức không được để trống.',
            'status.in' => 'Tình trạng tin tức không hợp lệ.',
            'published_at.date' => 'Ngày đăng phải là một ngày hợp lệ.',
            'views.integer' => 'Lượt xem phải là một số nguyên.',
            'views.min' => 'Lượt xem không được nhỏ hơn 0.',
            'short_content.string' => 'Tóm tắt nội dung phải là một chuỗi.',
            'scheduled_at.date' => 'Ngày đăng tin phải là một ngày hợp lệ.',
            'scheduled_at.after_or_equal' => 'Ngày đăng tin phải là hôm nay hoặc sau hôm nay.',
            'slug.required' => 'Slug không được để trống.',
            'slug.unique' => 'Slug đã tồn tại. Vui lòng chọn một slug khác.',
        ]);

        // Xử lý file thumbnail nếu có
        $thumbnail = $request->hasFile('thumbnail') ? $request->file('thumbnail')->store('uploads/thumbnail', 'public') : null;

        $slug = Str::slug($validateData['title']);
        $publishedAt = $request->status == 'Công khai' ? now() : null;
        $scheduledAt = $request->status == 'Đã lên lịch' ? $validateData['scheduled_at'] : null;

        try {
            $news = News::create([
                'title' => $validateData['title'],
                'thumbnail' => $thumbnail,
                'short_content' => $validateData['short_content'],
                'content' => $validateData['content'],
                'category_news_id' => $validateData['category_news_id'],
                'published_at' => $publishedAt,
                'status' => $validateData['status'],
                'author_id' => $validateData['author_id'],
                'scheduled_at' => $scheduledAt,
                'slug' => $slug,
                'views' => $validateData['views'] ?? 0,
            ]);

            return redirect()->route('new_admin.index')->with('success', 'Tin tức đã được lưu thành công!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra khi lưu tin tức: ' . $e->getMessage()]);
        }
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
        $news = News::findOrFail($id);
        $category_news = DB::table('category_news')->get();
        $author_id = DB::table('users')->get();
        return view('admin.page.new.update', compact('news', 'category_news', 'author_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $news = News::findOrFail($id);

        // Validate dữ liệu từ request
        $validateData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'author_id' => 'nullable|exists:users,id', // Thay đổi 'required' thành 'nullable'
            'thumbnail' => 'nullable|file|mimes:png,jpg,jpeg,gif|max:2048',
            'category_news_id' => 'required|exists:category_news,id',
            'status' => 'required|in:Công khai,Đã lên lịch,Bản nháp',
            'published_at' => 'nullable|date',
            'views' => 'nullable|integer|min:0',
            'short_content' => 'nullable|string',
            'scheduled_at' => 'nullable|date|after_or_equal:today',
            'slug' => 'required|unique:news,slug,' . $news->id,
        ], [
            // Các thông báo lỗi không thay đổi
            'title.required' => 'Tiêu đề không được để trống.',
            'content.required' => 'Nội dung không được để trống.',
            'author_id.exists' => 'Tác giả không tồn tại trong cơ sở dữ liệu.',
            'thumbnail.file' => 'Ảnh đại diện phải là một file.',
            'thumbnail.mimes' => 'Ảnh đại diện phải có định dạng: png, jpg, jpeg, hoặc gif.',
            'thumbnail.max' => 'Ảnh đại diện không được vượt quá 2MB.',
            'category_news_id.required' => 'Danh mục tin tức không được để trống.',
            'category_news_id.exists' => 'Danh mục tin tức không tồn tại trong cơ sở dữ liệu.',
            'status.required' => 'Tình trạng tin tức không được để trống.',
            'status.in' => 'Tình trạng tin tức không hợp lệ.',
            'published_at.date' => 'Ngày đăng phải là một ngày hợp lệ.',
            'views.integer' => 'Lượt xem phải là một số nguyên.',
            'views.min' => 'Lượt xem không được nhỏ hơn 0.',
            'short_content.string' => 'Tóm tắt nội dung phải là một chuỗi.',
            'scheduled_at.date' => 'Ngày đăng tin phải là một ngày hợp lệ.',
            'scheduled_at.after_or_equal' => 'Ngày đăng tin phải là hôm nay hoặc sau hôm nay.',
            'slug.required' => 'Slug không được để trống.',
            'slug.unique' => 'Slug đã tồn tại. Vui lòng chọn một slug khác.',
        ]);
        
        // Xử lý file thumbnail nếu có
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->store('uploads/thumbnail', 'public');
        } else {
            $thumbnail = $news->thumbnail; // Giữ lại thumbnail cũ nếu không có file mới
        }
        
        $slug = Str::slug($validateData['title']);
        $publishedAt = $request->status == 'Công khai' ? now() : $news->published_at;
        $scheduledAt = $request->status == 'Đã lên lịch' ? $validateData['scheduled_at'] : null;
        
        try {
            // Cập nhật dữ liệu của bài viết
            $news->update([
                'title' => $validateData['title'],
                'thumbnail' => $thumbnail,
                'short_content' => $validateData['short_content'],
                'content' => $validateData['content'],
                'category_news_id' => $validateData['category_news_id'],
                'published_at' => $publishedAt,
                'status' => $validateData['status'],
                'author_id' => $validateData['author_id'] ?? $news->author_id, // Giữ lại author_id nếu không được truyền
                'scheduled_at' => $scheduledAt,
                'slug' => $slug,
                'views' => $validateData['views'] ?? $news->views,
            ]);
        
            return redirect()->route('new_admin.index')->with('success', 'Tin tức đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra khi cập nhật tin tức: ' . $e->getMessage()]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
   
        $News=News::findOrFail($id);
        $News->delete();
        return redirect()->route('new_admin.index');
    }
    public function clientIndex()
    {
        
        $category_news = DB::table('category_news')->get();
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
        return view('client.page.news.news', compact('allNews', 'additionalMostViewedNews', 'mostViewedNews', 'latestNews'));
    }


    // Phương thức cho client - Hiển thị chi tiết một bản tin
    public function clientShow($id)
    {
        $news = News::findOrFail(id: $id);
        $latestNews = News::where('id', '!=', $id) // Tránh lấy bài viết hiện tại
            ->orderBy('published_at', 'desc') // Sắp xếp theo ngày xuất bản giảm dần
            ->take(6) // Giới hạn số lượng bài viết mới nhất (có thể điều chỉnh theo ý muốn)
            ->get();

        return view('client.page.news.news', compact('news', 'latestNews'));
    }
    public function singlepost($slug)
    {
        // Tìm bài viết theo slug
        $news = News::where('slug', $slug)->firstOrFail();
        $relatedPost = News::where('category_news_id', $news->category_news_id)
                        ->where('id', '!=', $news->id) // Loại bỏ bài viết hiện tại
                        ->limit(5) // Giới hạn số bài viết liên quan
                        ->get();
        // Trả về view hiển thị bài viết
        $categories = Category_new::limit(6)->get(); 
        return view('client.page.news.show', compact('news','relatedPost','categories'));
    }
    public function categoryNewsBlog($slug)
    {
    
        $category = Category_new::where('slug', $slug)->firstOrFail();

      
        $posts = News::where('category_news_id', $category->id)
                      ->where('status', 'Công khai') 
                      ->orderBy('published_at', 'desc') 
                      ->paginate(6); 
      
        return view('client.page.news.categoryNewsBlog', compact('category', 'posts'));
    }
}


