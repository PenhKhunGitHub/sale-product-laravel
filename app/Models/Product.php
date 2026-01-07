<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = [
        'category_id',
        'product_name',
        'title',
        'description',
        'unit_price',
        'sale_price'
    ];
}
