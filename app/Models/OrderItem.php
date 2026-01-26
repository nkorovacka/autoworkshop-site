<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Pasūtījuma rindas (pozīcijas) modelis.
 */
class OrderItem extends Model
{
    use HasFactory;

    // Aizpildāmie lauki masveida piešķiršanai (fillable).
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    /**
     * Saite uz pasūtījumu, kuram šī pozīcija pieder.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Saite uz produktu, kas atbilst šai pasūtījuma pozīcijai.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
