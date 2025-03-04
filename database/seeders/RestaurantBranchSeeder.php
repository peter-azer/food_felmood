<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class RestaurantBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fake = Faker::create();
        
        foreach(range(0, 1000) as $index){
            Db::table('restaurant_branches')->insert([
                "restaurant_id" => $fake->numberBetween(1, 101),
                "area_id" => $fake->randomElement([1, 2, 3, 4, 5, 6, 7]),
                "branch_code"=> $fake->randomElement([1, 2, 3, 4, 5]),
                "phone_number"=> $fake->phoneNumber,
                "optional_phone_number"=> $fake->phoneNumber,
                "location"=> $fake->url,
                "address"=> $fake->address,
                "menu"=> $fake->imageUrl,
            ]);}
    }
}
