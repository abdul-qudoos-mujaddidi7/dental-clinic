<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BillExpense>
 */
class BillExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bill_number' => $this->faker->unique()->numerify('BILL-#####'),
            'bill_date' => $this->faker->date(),
            'paid' => $this->faker->randomFloat(2, 0, 10000), // Example: 0.00 to 10000.00
            'grand_total' => $this->faker->randomFloat(2, 0, 10000), // Example: 0.00 to 10000.00
            'note' => $this->faker->optional()->text(), // Optional text field
            'supplier_id' => Supplier::factory(), // Creates a new Supplier record and uses its ID
            'user_id' => User::factory(), // Creates a new User record and uses its ID
        ];
    }
}
