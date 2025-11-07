<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'patient_id', 'doctor_id', 'content',
    ];
}