<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'title',
        'type',                 // 'webinar' vai 'detailing'
        'description',
        'event_date',
        'is_limited',
        'capacity',
        'registrations_count',
        'has_timeslots',
        'is_active',
    ];

    protected $casts = [
        'is_limited'        => 'boolean',
        'has_timeslots'     => 'boolean',
        'is_active'         => 'boolean',
        'capacity'          => 'integer',
        'registrations_count' => 'integer',
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
