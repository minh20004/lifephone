<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['product_id', 'customer_id', 'rating', 'comment'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public $table="reviews";
    protected $dates=['delete_at'];
    public function loadAllProduct(){
        return $this->belongsTo(Product::class,'product_id' );
    }
    public function loadAlluser(){
        return $this->belongsTo(User::class,'user_id' );
    }
    public function loadAllCustomer(){
        return $this->belongsTo(Customer::class,'customer_id' );
    }
    public function reviews()
{
    return $this->hasMany(Review::class);
}
public function color()
{
    return $this->belongsTo(Color::class);
}

public function capacity()
{
    return $this->belongsTo(Capacity::class);
}
}
