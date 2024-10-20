<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'author_id', 'thumbnail','category_news_id','status','published_at','views','short_content'];

    public $table="news";
    protected $dates=['delete_at'];
    public function loadAllCategoryNews(){
        return $this->belongsTo(Category_new::class,'category_news_id' );
    }
    public function loadAlluser(){
        return $this->belongsTo(User::class,'author_id' );
    }
    
}
