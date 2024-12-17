<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'product_code',
        'name',
        'views',
        'description',
        'price',
        'stock',
        'category_id',
        'image_url',
        'gallery_image'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function product()
{
    return $this->belongsTo(Product::class);
}

public function loadAllCustomer(){
    return $this->belongsTo(Customer::class,'customer_id' );
}
public function order()
{
    return $this->belongsTo(Order::class);
}
}
