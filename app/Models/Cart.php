<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Bảng liên kết với model
    protected $table = 'carts';

    // Các cột được phép gán giá trị (Mass Assignment)
    protected $fillable = [
        'customer_id',
        'product_id',
        'model_id',
        'color_id',
        'quantity',
        'price',
    ];

    // Thiết lập quan hệ
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function model()
    {
        return $this->belongsTo(Capacity::class, 'model_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
}
