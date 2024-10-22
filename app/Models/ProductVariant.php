<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'variant_name', 'variant_value', 'price_difference', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id'); // 'color_id' là khoá ngoại trong bảng product_variants
    }
    public function capacity()
    {
        return $this->belongsTo(Capacity::class, 'capacity_id'); // 'capacity_id' là khoá ngoại trong bảng product_variants
    }
}
