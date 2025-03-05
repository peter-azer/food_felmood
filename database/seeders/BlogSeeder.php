<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fake = Faker::create();

        foreach (range(0, 10) as $index) {
            Db::table('blogs')->insert([
                "title" => $fake->title,
                "content" => $fake->text,
                "cover" => $fake->imageUrl,
            ]);
        }
    }
}
