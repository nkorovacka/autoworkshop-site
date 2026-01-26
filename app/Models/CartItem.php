<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Groza vienuma modelis, kas glabā produkta daudzumu un cenu grozā.
 */
class CartItem extends Model
{
    use HasFactory;

    // Aizpildāmie lauki masveida piešķiršanai (fillable).
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    /**
     * Saite uz produktu, kurš atrodas grozā.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
