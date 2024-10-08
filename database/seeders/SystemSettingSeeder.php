<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemSetting::create([
            'name' => 'Health Solutions Ltd.',
            'email' => 'info@healthsolution.com',
            'phone' => '0987654321',
            'image' => "images/company/jawad.jpg",
            'address' => '456 Wellness Street, New York, NY',

        ]);
    }
}
