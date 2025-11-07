<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'doctor_id', 'type', 'scheduled_date', 'performed_date', 'status', 'result'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'performed_date' => 'date',
    ];
}