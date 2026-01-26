<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Pasūtījuma modelis, kas glabā kopējo informāciju par pirkumu.
 */
class Order extends Model
{
    use HasFactory;

    // Aizpildāmie lauki masveida piešķiršanai (fillable).
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'product_id',
        'total_price',
        'total_items',
        'status',
        'shipping_method',
        'shipping_address',
        'payment_method',
        'card_holder',
        'card_last4',
        'items_summary',
        'notes',
    ];

    /**
     * Saite uz lietotāju, kurš veica pasūtījumu.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Pasūtījuma pozīcijas (preces) ar daudzumu un cenu.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
