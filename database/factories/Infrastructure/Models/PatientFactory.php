<?php

namespace Database\Factories\Infrastructure\Models;

use App\Infrastructure\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Infrastructure\Models\Patient>
 */
class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'gender' => $this->faker->randomElement(['M','F']),
        ];
    }
}