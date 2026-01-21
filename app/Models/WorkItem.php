<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'tag',
        'description',
        'before_image',
        'after_image',
        'position',
        'is_visible',
    ];
}
