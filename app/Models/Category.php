<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'categories';

    protected $fillable = ['name'];

    public function getAll(){
        return self::all(); // Sử dụng Eloquent
    }

    public function updateCategory($data, $id){
        DB::table('categories')
        ->where('id', $id)
        ->update($data);
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
