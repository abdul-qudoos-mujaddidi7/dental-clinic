<?php

namespace Database\Seeders;

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
        DB::table('system_settings')->insert([
            
                'name' => 'Health Solutions Ltd.',
                'email' => 'info@healthsolution.com',
                'phone' => '0987654321',
                'photo' => 'img.jpeg',
                'address' => '456 Wellness Street, New York, NY',
        ]);
    }
}
