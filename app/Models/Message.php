<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'conversation_id',
        'message',
        'is_read',
    ];

    // Quan hệ với người gửi
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Quan hệ với người nhận
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // Quan hệ với cuộc hội thoại
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
