<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Produkta modelis e-veikala katalogam.
 */
class Product extends Model
{
    // Aizpildāmie lauki masveida piešķiršanai (fillable).
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',

        'stock',
        'is_visible',
        'supplier',
        'origin_country',
        'usage_instructions',
        'long_description',
    ];

    /**
     * Saite uz pasūtījumiem, kuros šis produkts ir iekļauts.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
