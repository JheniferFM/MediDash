<?php

namespace Database\Factories\Infrastructure\Models;

use App\Infrastructure\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Infrastructure\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        $specialties = ['Cardiologia','Clínico Geral','Pediatria','Ortopedia','Dermatologia','Ginecologia','Neurologia'];
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'crm' => 'CRM-' . $this->faker->numberBetween(10000, 99999),
            'specialty' => $this->faker->randomElement($specialties),
        ];
    }
}