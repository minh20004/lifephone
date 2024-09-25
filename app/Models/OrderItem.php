<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'variant_id', 'quantity', 'price'];

    // Một order_item thuộc về một đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Một order_item thuộc về một sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Một order_item có thể có biến thể (nếu có)
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
