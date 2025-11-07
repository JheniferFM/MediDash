<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'doctor_id', 'scheduled_at', 'status', 'notes'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];
}