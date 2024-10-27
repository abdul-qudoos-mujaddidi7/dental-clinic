<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone' => $this->faker->phoneNumber(),
            'address'=>$this->faker->address(),
            // 'date_of_birth' => $this->faker->date(),
            // 'gender' => $this->faker->randomElement(['Male', 'Female']),
            // 'doctor_warning' => $this->faker->sentence(),
    ];
}
}