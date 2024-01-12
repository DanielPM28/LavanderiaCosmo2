<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Daniel Pardo',
            'email' => 'daniel_pardo_murcia@hotmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('Solomillos14'),
            'remember_token' => '123456',
            'cedula' => '1022431461',
            'address' => 'Cra.117',
            'role' =>'admin',
        ]);
        User::create([
            'name' => 'William Pardo',
            'email' => 'wpardo@hotmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
            'remember_token' => '123456',
            'role' =>'conductor',
        ]);
        User::create([
            'name' => 'Produccion 1',
            'email' => 'produccion1@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
            'remember_token' => '123456',
            'role' =>'produccion',
        ]);
        User::factory()
            ->count(20)
            ->state(['role' => 'produccion'])
            ->create();
    }
}