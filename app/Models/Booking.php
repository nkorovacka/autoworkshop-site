<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Rezervācijas modelis auto pakalpojumu pieteikumiem un piedāvājumiem.
 */
class Booking extends Model
{
    // Aizpildāmie lauki masveida piešķiršanai (fillable).
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

    /**
     * Saite uz piedāvājumu, ja rezervācija veikta no akcijas/pasākuma.
     */
    public function offer()
    {
        // Offer modelis ir tajā pašā App\Models namespace,
        // tāpēc varam vienkārši izmantot Offer::class
        return $this->belongsTo(Offer::class);
    }

    /**
     * Saite uz lietotāju, kurš izveidoja rezervāciju.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
