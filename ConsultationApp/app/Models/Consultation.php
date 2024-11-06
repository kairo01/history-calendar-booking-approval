<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'course',
        'purpose',
        'consultant',
        'meeting_mode',
        'online_platform',
        'schedule',
        'status',
    ];

    protected $casts = [
        'schedule' => 'datetime',  // Casts schedule to a datetime instance
    ];
}

