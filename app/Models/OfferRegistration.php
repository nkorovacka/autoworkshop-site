<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferRegistration extends Model
{
    protected $fillable = [
        'offer_id',
        'user_id',
        'name',
        'email',
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
