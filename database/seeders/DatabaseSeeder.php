<?php

namespace Database\Seeders;

use App\Models\Cure;
use App\Models\Lead;
use App\Models\User;
use App\Models\Stage;
use App\Models\People;
use App\Models\Dentist;
use App\Models\Expense;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Service;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\BillExpense;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\MoneyAccount;
use App\Models\PeopleAccount;
use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;
use PHPUnit\Event\Telemetry\System;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(SystemSettingSeeder::class);

        MoneyAccount::create([
            "name" => 'Main Account',
        ]);

        // User::factory(3)->create();
        // Supplier::factory(3)->create();

        // ExpenseCategory::factory(3)->create();
        // Expense::factory(3)->create();
        // Product::factory(3)->create();

        // // Lead
        // Stage::factory(3)->create();
        // Category::factory(3)->create();
        // Lead::factory(3)->create();
        
        // People::create([
        //     "name" => "Mohammad jan naser",
        //     "type" => 'customer'
        // ]);

        // PeopleAccount::create([
        //     'people_id' => 1,
        //     "name" => 'account name'
        // ]);

    
        // $this->call(SystemSettingSeeder::class);
        // Patient::factory(3)->create();
        // Dentist::factory(3)->create();
        // Service::factory(2)->create();
        // Cure::factory(2)->create();
    }
}
