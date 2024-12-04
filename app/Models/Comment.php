<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['review_id', 'customer_id', 'comment'];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function loadAllCustomer(){
        return $this->belongsTo(Customer::class,'customer_id' );
    }
    public function replies()
{
    return $this->hasMany(Comment::class, 'review_id');
}
}
