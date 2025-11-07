<?php

namespace Database\Factories\Infrastructure\Models;

use App\Infrastructure\Models\Appointment;
use App\Infrastructure\Models\Patient;
use App\Infrastructure\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<\App\Infrastructure\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(['scheduled','completed','canceled']);
        $scheduled = $this->faker->dateTimeBetween('-7 days', '+7 days');
        return [
            'patient_id' => optional(Patient::inRandomOrder()->first())->id ?? Patient::factory(),
            'doctor_id' => optional(Doctor::inRandomOrder()->first())->id ?? Doctor::factory(),
            'scheduled_at' => $scheduled,
            'status' => $status,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }

    public function scheduledToday(): self
    {
        return $this->state(function () {
            return [
                'scheduled_at' => Carbon::today()->addMinutes(rand(8*60, 17*60)),
                'status' => 'scheduled',
            ];
        });
    }
}