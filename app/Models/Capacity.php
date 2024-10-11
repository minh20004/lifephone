<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Capacity extends Model
{
    use HasFactory, SoftDeletes; 
    protected $table = 'capacities';

    protected $fillable = [
        'name',
    ];

    public function getAll(){
        return self::all(); // Sử dụng Eloquent
    }

    public function updateCapacity($data, $id){
        DB::table('capacities')
        ->where('id', $id)
        ->update($data);
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function productVariants() {
        return $this->hasMany(ProductVariant::class);
    }
}
