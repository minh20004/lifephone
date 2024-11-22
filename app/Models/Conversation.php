<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'admin_id',
    ];

    // Quan hệ với model User (người dùng tham gia cuộc hội thoại)
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Quan hệ với model Message (các tin nhắn trong cuộc hội thoại)
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
