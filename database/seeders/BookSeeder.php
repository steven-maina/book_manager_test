<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            Book::create([
                'name' => $faker->sentence(3),
                'isbn' => $faker->isbn13,
                'author_id' => $faker->numberBetween(1, 10),
            ]);
        }
    }
}
