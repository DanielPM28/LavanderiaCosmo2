<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { 
        $date = $this->faker->dateTimeBetween('-1 years', 'now');
        $scheduled_date = $date->format('Y-m-d');
        $scheduled_time = $date->format('H:i:s');
        $types = ['LLevar','Recoger'];
        $driversID = User::conductores()->pluck('id'); 
        $productionID = User::producciones()->pluck('id'); 
        $statuses = ['Completada','Cancelada'];
         return [
             'scheduled_date' => $scheduled_date,
             'scheduled_time' => $scheduled_time,
             'type' =>$this->faker->randomElement($types),
             'direccion' =>$this->faker->sentence(5),
             'conductor_id' =>$this->faker->randomElement($driversID),
             'production_id' =>$this->faker->randomElement($productionID),
             'producers_id'=>$this->faker->numberBetween(1,5),
             'status' =>$this->faker->randomElement($statuses),
        ];
    }
}
