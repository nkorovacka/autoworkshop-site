<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Aizpildāmie lauki masveida piešķiršanai (fillable).
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * Lauki, kas jāslēpj serializācijā (piem., JSON atbildēs).
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Lauku tipu pārveidošana (casts).
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Nosaka, vai lietotājs ir administrators.
     */
    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    /**
     * Lietotāja vebināru pieteikumi.
     */
    public function offerRegistrations()
    {
        return $this->hasMany(OfferRegistration::class);
    }

    /**
     * Lietotāja pakalpojumu rezervācijas.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Lietotāja pasūtījumi.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
