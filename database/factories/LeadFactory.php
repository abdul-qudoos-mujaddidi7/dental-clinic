<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,                         // Random name
            'phone' => $this->faker->phoneNumber,                 // Random phone number
            'gender' => $this->faker->randomElement(['Male', 'Female']),  // Random gender
            'address' => $this->faker->address,                   // Random address
            'date' => $this->faker->date,                         // Random date
            'category_id' => rand(1,3),                 // Creates and associates a Category
            'stage_id' => rand(1,3),                       // Creates and associates a Stage
            'note' => $this->faker->sentence,   
        ];
    }
}
