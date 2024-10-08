<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

<<<<<<< HEAD
    protected $fillable = ['product_code','name', 'description', 'price', 'stock', 'category_id', 'image_url'];
=======
    protected $fillable = ['product_code','name', 'description', 'price', 'stock', 'category_id', 'image_url', 'gallery_image'];
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
