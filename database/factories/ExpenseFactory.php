<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'user_id' => User::factory(), // Generates a valid user ID (assuming you have a User model factory)
            'expense_category_id' => ExpenseCategory::factory(), // Generates a valid category ID (assuming you have a Category model factory)
        ];
    }
}
