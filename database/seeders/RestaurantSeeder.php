<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fake = Faker::create();
        
        foreach(range(0, 100) as $index){
            Db::table('restaurants')->insert([
                'name' => $fake->name,
                'name_ar' => $fake->name,
                'logo' => $fake->imageUrl,
                'thumbnail' => $fake->imageUrl,
                'description' => $fake->text,
                'description_ar' => $fake->text,
                'slug' => $fake->name,
                'slug_ar' => $fake->name,
                'Rank' => $fake->randomElement([1, 2, 3, 4, 5]),
                'recommendation' => $fake->randomElement([1, 2, 3, 4, 5]),
                'cost' => $fake->randomElement([1000, 2000, 3000, 4000, 5000]),
                'restaurant_code' => $fake->randomElement([1, 2, 3, 4, 5]),
                'food_type_ids' => $fake->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                'images' => $fake->imageUrl,
                'hotline' => $fake->phoneNumber,
                'created_at' => $fake->dateTime,
                'updated_at' => $fake->dateTime,
            ]);
        }
    }
}
