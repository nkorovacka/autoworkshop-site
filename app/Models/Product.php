<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',

        'stock',
        'supplier',
        'origin_country',
        'usage_instructions',
        'long_description',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
