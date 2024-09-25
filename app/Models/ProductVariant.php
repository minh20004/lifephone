<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'variant_name', 'variant_value', 'price_difference', 'stock'];

    // Một biến thể thuộc về một sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Một biến thể có thể xuất hiện trong nhiều đơn hàng (thông qua order_items)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
