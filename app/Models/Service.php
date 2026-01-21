<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'base_price',
    ];

    protected $appends = ['slug'];

    public function getSlugAttribute(): string
    {
        return Str::slug($this->name);
    }
}
