<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            Author::create([
                'name' => $faker->name,
                'gender' => $faker->randomElement(['male', 'female', 'other']),
                'age' => $faker->numberBetween(20, 80),
                'country' => $faker->country,
                'genre' => $faker->word,
            ]);
        }
    }
}
