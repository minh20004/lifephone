<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Capacity extends Model
{
<<<<<<< HEAD
    use HasFactory, SoftDeletes;
=======
    use HasFactory, SoftDeletes; 
>>>>>>> c32c957ea283f4266867dc34e802189c042da2ab
    protected $table = 'capacities';

    protected $fillable = [
        'name',
    ];

<<<<<<< HEAD
    public function getAll()
    {
        return self::all(); // Sử dụng Eloquent
    }

    public function updateCapacity($data, $id)
    {
        DB::table('capacities')
            ->where('id', $id)
            ->update($data);
=======
    public function getAll(){
        return self::all(); // Sử dụng Eloquent
    }

    public function updateCapacity($data, $id){
        DB::table('capacities')
        ->where('id', $id)
        ->update($data);
>>>>>>> c32c957ea283f4266867dc34e802189c042da2ab
    }


    public function products()
    {
<<<<<<< HEAD
        return $this->hasManyThrough(Product::class, ProductVariant::class, 'capacity_id', 'id', 'id', 'product_id');
    }

    public function productVariants()
    {
=======
        return $this->hasMany(Product::class);
    }

    public function productVariants() {
>>>>>>> c32c957ea283f4266867dc34e802189c042da2ab
        return $this->hasMany(ProductVariant::class);
    }
}
