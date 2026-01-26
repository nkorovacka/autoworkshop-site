<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * "Mūsu darbi" sadaļas vienuma modelis ar pirms/pēc attēliem.
 */
class WorkItem extends Model
{
    use HasFactory;

    // Aizpildāmie lauki masveida piešķiršanai (fillable).
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
