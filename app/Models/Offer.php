<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Piedāvājuma modelis (piem., vebinārs vai detailing pasākums).
 */
class Offer extends Model
{
    // Aizpildāmie lauki masveida piešķiršanai (fillable).
    protected $fillable = [
        'title',
        'type',                 // 'webinar' vai 'detailing'
        'format',
        'description',
        'event_date',
        'is_limited',
        'capacity',
        'registrations_count',
        'has_timeslots',
        'is_active',
    ];

    // Datubāzes lauku tipu pārveidošana (casts).
    protected $casts = [
        'is_limited'        => 'boolean',
        'has_timeslots'     => 'boolean',
        'is_active'         => 'boolean',
        'capacity'          => 'integer',
        'registrations_count' => 'integer',
    ];

    /**
     * Saite uz lietotāju reģistrācijām šim piedāvājumam.
     */
    public function registrations()
    {
        return $this->hasMany(OfferRegistration::class);
    }

    /**
     * Saite uz rezervācijām, ja piedāvājums ir detailing tipa.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
