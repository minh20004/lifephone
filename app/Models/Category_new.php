<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category_new extends Model
{
    use HasFactory,SoftDeletes;
    public $table = "Category_news";
    protected $fillable = ['title','slug'];
    protected $dates=['delete_at'];
    
    public function News()
    {
        return $this->hasMany(News::class, 'category_news_id', 'id');
    }
    
}
