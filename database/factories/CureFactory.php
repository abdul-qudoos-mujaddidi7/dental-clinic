<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cure>
 */
class CureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => rand(1,3),
            'start_date' => $this->faker->date(),
            'grand_total' => $this->faker->randomFloat(2, 100, 10000), // Random total between 100 and 10000
            'paid' => 0,
            'status' => $this->faker->randomElement(['Pending', 'Completed', 'In Progress', 'Canceled']), // Random status
            'description' => $this->faker->optional()->sentence(),
        ];
    }
}
