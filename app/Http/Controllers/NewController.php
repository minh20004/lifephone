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
        $listNews=News::all();
        return view('admin.page.new.index',compact('listNews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category_news= DB::table( 'category_news')->get();
        $author_id= DB::table( 'users')->get();
        return view('admin.page.new.create', ['category_news' => $category_news],['author_id' => $author_id]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData=$request->validate([
            'title'=>'required',
             'thumbnail'=>'required',
            'content'=>'required',
            'short_content'=>'required',
            'category_news_id'=>'required',
            'published_at'=>'required'
        ]);
        if($request->hasFile('thumbnail')){
           $thumbnail=$request->file('thumbnail')->store('uploads/news_img','public');
        }
        $news=News::create([
           'title'=>$validateData['title'],
             'thumbnail'=>$thumbnail,
            'short_content'=>$validateData['short_content'],
            'content'=>$validateData['content'],
            'category_news_id'=>$validateData['category_news_id'], 
            'published_at'=>$validateData['published_at'],
        ]);
        return redirect()->route( 'new.index');
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
   ->paginate(5); // Sử dụng paginate để giới hạn 10 bản tin mỗi trang
   $mostViewedNews = News::where('status', 'Công khai')
   ->orderBy('views', 'desc')
   ->first();

// Lấy 3 bài viết tiếp theo có lượt xem cao sau bài viết nhiều view nhất
$additionalMostViewedNews = News::where('status', 'Công khai')
   ->where('id', '!=', $mostViewedNews->id) // Loại bỏ bài viết có nhiều view nhất
   ->orderBy('views', 'desc')
   ->take(3)
   ->get();
   // Lấy 3 bản tin có trạng thái 'Công khai' và lượt xem cao nhất
               return view('client.page.news.news', compact('allNews', 'additionalMostViewedNews', 'mostViewedNews'));
}


    // Phương thức cho client - Hiển thị chi tiết một bản tin
    public function clientShow($id)
    {
        $news = News::findOrFail(id: $id);
        return view('client.page.news.news', compact('news'));
    }
}
