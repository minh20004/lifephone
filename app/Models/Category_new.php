<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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
    public static function boot()
    {
        parent::boot();

        static::saving(function ($news) {
            if (empty($news->slug)) {
                $baseSlug = Str::slug($news->title);
                $slug = $baseSlug;
                $count = 1;

                // Tạo slug duy nhất nếu có trùng lặp
                while (News::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }

                $news->slug = $slug;
            }
        });
    }
}
