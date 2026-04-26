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
        'total_price',
        'status',
    ];

    /**
     * Saite uz lietotāju, kurš izveidoja rezervāciju.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Rezervācijai piesaistītie pakalpojumi.
     */
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
