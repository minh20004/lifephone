<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'user_id', 'rating', 'comment'];

    // Một đánh giá thuộc về một sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Một đánh giá thuộc về một người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
