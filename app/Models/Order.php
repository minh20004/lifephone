<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class Order extends Model
// {
//     use HasFactory;
    
//     protected $fillable = ['user_id', 'total_price', 'status', 'voucher_id'];
//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }
//     public function orderItems()
//     {
//         return $this->hasMany(OrderItem::class);
//     }

//     public function voucher()
//     {
//         return $this->belongsTo(Voucher::class);
//     }
// }

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    // Các trường có thể điền được
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone',
        'description',
        'payment_method',
        'shipping_method',
        'shipping_fee',
        'total_price',
        'status',
        'voucher_id'
    ];

    // Quan hệ với bảng User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với bảng OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Quan hệ với bảng Voucher
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
