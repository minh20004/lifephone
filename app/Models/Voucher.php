<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'vouchers';
    public $timestamps = true;
    protected $dates = 'delete_at';
    protected $fillable = [
        'code',
        'discount_percentage',
        'max_discount_amount',
        'min_order_value',
        'start_date',
        'end_date',
        'usage_limit',
        'image'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
