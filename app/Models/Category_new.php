<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category_new extends Model
{
    use HasFactory,SoftDeletes;
    public $table = "Category_news";
    protected $fillable = ['title'];
    protected $dates=['delete_at'];
    
    public function news()
    {
        return $this->hasMany(News::class);
    }
}
