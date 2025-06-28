<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    'nama',
    'slug',
    'deskripsi',
    'harga',
    'stok',
    'gambar',
    'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
