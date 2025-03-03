<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = ['maadi', 'New Cairo', 'nasr city', 'duqqi', '6 october city'];
        $governorates = ['Cairo', 'Giza'];

        foreach($areas as $area){
            foreach($governorates as $governorate){
                \App\Models\Area::factory()->create([
                    'area' => $area,
                    'governorate' => $governorate
                ]);
            }
        }
    }
}
