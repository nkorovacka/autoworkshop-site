<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Pakalpojuma modelis, kas pārstāv auto kopšanas pakalpojumus.
 */
class Service extends Model
{
    // Aizpildāmie lauki masveida piešķiršanai (fillable).
    protected $fillable = [
        'name',
        'description',
        'base_price',
    ];

    // Virtuālais lauks "slug", kas tiek pievienots serializācijā.
    protected $appends = ['slug'];

    /**
     * Ģenerē "slug" vērtību no pakalpojuma nosaukuma.
     */
    public function getSlugAttribute(): string
    {
        return Str::slug($this->name);
    }

    /**
     * Rezervācijas, kurās izvēlēts šis pakalpojums.
     */
    public function bookings()
    {
        return $this->belongsToMany(Booking::class);
    }
}
