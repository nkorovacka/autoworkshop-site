<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'car_model',
        'condition',
        'interior_material',
        'interior_condition',
        'date',
        'time_slot',
        'services',
        'total_price',
        'status',
        'offer_id', // svarīgi: sasaistīts ar piedāvājumu
    ];

    public function offer()
    {
        // Offer modelis ir tajā pašā App\Models namespace,
        // tāpēc varam vienkārši izmantot Offer::class
        return $this->belongsTo(Offer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
