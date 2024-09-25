<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'stock', 'category_id', 'image_url'];

    // Một sản phẩm thuộc về một danh mục
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Một sản phẩm có thể có nhiều biến thể
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Một sản phẩm có thể xuất hiện trong nhiều đơn hàng (thông qua order_items)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Một sản phẩm có thể có nhiều đánh giá
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
