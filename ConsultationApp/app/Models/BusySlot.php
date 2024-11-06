<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusySlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id', // Foreign key for consultations
        'title',
        'description',
        'date',
        'time',
        'busy_times', // JSON column for selected busy times
    ];
}

