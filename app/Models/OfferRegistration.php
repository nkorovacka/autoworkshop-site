<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Piedāvājuma (vebināra) pieteikuma modelis.
 */
class OfferRegistration extends Model
{
    // Aizpildāmie lauki masveida piešķiršanai (fillable).
    protected $fillable = [
        'offer_id',
        'user_id',
        'name',
        'email',
    ];

    /**
     * Saite uz piedāvājumu, kuram lietotājs pieteicies.
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * Saite uz lietotāju, kurš pieteicies.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
