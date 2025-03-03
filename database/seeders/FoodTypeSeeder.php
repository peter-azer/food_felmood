<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foodTypes = ['fast food', 'sea food', 'grill', 'oriental', 'dessert', 'drinks', 'fried chicken'];

        foreach($foodTypes as $foodType){
            \App\Models\FoodType::factory()->create([
                'type' => $foodType
            ]);
        }
    }
}
