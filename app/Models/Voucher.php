<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'discount_percentage', 'max_discount_amount', 'min_order_value', 'start_date', 'end_date', 'usage_limit'];

    // Một voucher có thể áp dụng cho nhiều đơn hàng
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
