<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['conversationId', 'senderId', 'senderType', 'content', 'iv', 'status'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversationId');
    }

    public function senderUser()
    {
        return $this->belongsTo(User::class, 'senderId')->where('senderType', 'admin');
    }

    public function senderCustomer()
    {
        return $this->belongsTo(Customer::class, 'senderId')->where('senderType', 'customer');
    }
}
