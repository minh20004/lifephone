<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'title',
        'content',
        'author_id',
        'thumbnail',
        'category_news_id',
        'status',
        'published_at',
        'views',
        'short_content',
        'scheduled_at',
    ];

    public $table = "news";

    protected $dates = ['delete_at', 'published_at', 'scheduled_at'];

    public function categoryNews()
    {
        return $this->belongsTo(Category_new::class, 'category_news_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
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
