<?php

namespace Database\Seeders;

use App\Models\producers;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class producersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $producers =[
            'RCN',
            'Caracol',
            'Fox',
            'RTVC',
            'CANAL 1'
        ];
        foreach($producers as $produName){
           $produ = producers::create([
                'name' => $produName
            ]);
            $produ->users()->saveMany(
                User::factory(4)->state(['role' => 'conductor'])->make()
            );
        }
        User::find(2)->producers()->save($produ);
    }
}
