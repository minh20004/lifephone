<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Color extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'colors';
    protected $fillable = [
        'name',
        'code',
        'status',
        
    ];


    public function getAll(){
        return self::all(); // Sử dụng Eloquent
    }

    public function updateColor($data, $id){
        DB::table('colors')
        ->where('id', $id)
        ->update($data);
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
