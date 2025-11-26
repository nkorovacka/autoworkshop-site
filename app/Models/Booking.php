<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_email',
        'car_model',
        'condition',
        'date',
        'time_slot',
        'services',
        'total_price',
        'offer_id', // svarīgi: sasaistīts ar piedāvājumu
    ];

    public function offer()
    {
        // Offer modelis ir tajā pašā App\Models namespace,
        // tāpēc varam vienkārši izmantot Offer::class
        return $this->belongsTo(Offer::class);
    }
}
