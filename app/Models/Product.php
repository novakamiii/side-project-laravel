<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'desc', 'stock', 'origin', 'tag', 'sale'];
    protected $casts = ['sale' => 'boolean'];
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
}
