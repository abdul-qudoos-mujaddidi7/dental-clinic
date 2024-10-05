<?php

namespace Database\Seeders;

use App\Models\BillExpense;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        ExpenseCategory::factory(5)->create();
        Expense::factory(5)->create();
        BillExpense::factory(5)->create();
        Product::factory(3)->create();


        // Supplier::factory(3)->create();
        $this->call(SystemSettingSeeder::class);
        $this->call(AdminSeeder::class);
    }
}
