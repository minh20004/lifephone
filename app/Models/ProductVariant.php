<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'color_id', 'capacity_id', 'price_difference', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    // public function capacity() {
    //     return $this->belongsTo(Capacity::class);
    // }
    // public function color() {
    //     return $this->belongsTo(Color::class);
    // }
    public function capacity()
    {
        return $this->belongsTo(Capacity::class, 'capacity_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    
}
// class ProductVariant extends Model
// {
//     use HasFactory;

//     protected $fillable = ['product_id', 'color_id', 'capacity_id', 'price_difference', 'stock'];

//     // Kiểm tra và cập nhật số lượng sản phẩm trong kho
//     public function updateStock(int $quantity)
//     {
//         if ($this->stock >= $quantity) {
//             $this->stock -= $quantity;
//             $this->save();
//             return true;
//         }
//         return false;  // Nếu không đủ số lượng
//     }

//     // Quan hệ với bảng Product
//     public function product()
//     {
//         return $this->belongsTo(Product::class);
//     }

//     // Quan hệ với bảng OrderItem
//     public function orderItems()
//     {
//         return $this->hasMany(OrderItem::class);
//     }

//     // Quan hệ với bảng Capacity
//     public function capacity()
//     {
//         return $this->belongsTo(Capacity::class);
//     }

//     // Quan hệ với bảng Color
//     public function color()
//     {
//         return $this->belongsTo(Color::class);
//     }
// }