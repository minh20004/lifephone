<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

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
        return view('admin.page.new.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData=$request->validate([
            'title'=>'required',
            // 'banner'=>'required',
            'content'=>'required',
            'short_content'=>'required',
            // 'description'=>'required',
        ]);
        if($request->hasFile('news_img')){
           $news_img=$request->file('news_img')->store('uploads/news_img','public');
        }
        $news=News::create([
           'title'=>$validateData['title'],
            // 'banner'=>$banner,
            'short_content'=>$validateData['short_content'],
            'content'=>$validateData['content'],
            // 'description'=>$validateData['description'], 
        ]);
        return redirect()->route('new.index');
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
}
