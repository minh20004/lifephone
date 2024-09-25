<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'total_price', 'status', 'voucher_id'];

    // Một đơn hàng thuộc về một người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Một đơn hàng có thể chứa nhiều sản phẩm (thông qua order_items)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Một đơn hàng có thể áp dụng một voucher
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
