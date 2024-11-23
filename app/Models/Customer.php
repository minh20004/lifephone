<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'email',
        'phone',
        'address',
        'gender',
        'avatar',
        'password',
        'is_verified',
        'verification_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

