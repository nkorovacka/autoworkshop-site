<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'title',
        'type',
        'description',
        'event_date',
        'is_limited',
        'capacity',
        'registrations_count',
        'has_timeslots',
        'is_active',
    ];

    public function registrations()
    {
        return $this->hasMany(OfferRegistration::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
