<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointment::factory()
        ->count(100)
        ->create();
    }
}
