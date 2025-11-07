<?php

namespace Database\Factories\Infrastructure\Models;

use App\Infrastructure\Models\Exam;
use App\Infrastructure\Models\Patient;
use App\Infrastructure\Models\Doctor;
use App\Infrastructure\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<\App\Infrastructure\Models\Exam>
 */
class ExamFactory extends Factory
{
    protected $model = Exam::class;

    public function definition(): array
    {
        $types = ['Hemograma','Raio-X','Ultrassom','Ressonância','Tomografia','Glicose','Colesterol'];
        $status = $this->faker->randomElement(['pending','scheduled','performed','canceled']);
        $scheduled = $this->faker->dateTimeBetween('-10 days', '+14 days');
        $performed = $status === 'performed' ? $this->faker->dateTimeBetween('-10 days', 'now') : null;
        return [
            'patient_id' => optional(Patient::inRandomOrder()->first())->id ?? Patient::factory(),
            'doctor_id' => optional(Doctor::inRandomOrder()->first())->id ?? Doctor::factory(),
            'appointment_id' => optional(Appointment::inRandomOrder()->first())->id,
            'type' => $this->faker->randomElement($types),
            'status' => $status,
            'scheduled_date' => $scheduled,
            'performed_date' => $performed,
            'result' => $status === 'performed' ? $this->faker->optional()->sentence(6) : null,
        ];
    }
}