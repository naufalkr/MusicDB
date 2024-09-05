<?php

namespace Database\Seeders;

use App\Models\Song;
use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BukuGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Seed Genre Table
        $genres = [
            'Fiction', 
            'Non-Fiction', 
            'Science', 
            'History', 
            'Biography', 
            'Fantasy', 
            'Mystery', 
            'Romance', 
            'Thriller', 
            'Self-Help', 
            'Philosophy', 
            'Art', 
            'Travel', 
            'Cooking', 
            'Health', 
            'Business', 
            'Technology', 
            'Poetry', 
            'Children', 
            'Graphic Novels'
        ];
        
        $genreIds = [];

        foreach ($genres as $genre) {
            $genreModel = Genre::create([
                'nama' => $genre,
            ]);
            $genreIds[] = $genreModel->id;
        }

        // Seed Song Table and attach Genre
        foreach (range(1, 100) as $index) {
            $song = Song::create([
                'title' => $faker->sentence,
                'artist' => $faker->name,
                'album' => $faker->sentence,
                'year' => $faker->year,
                'duration' => $faker->numberBetween(100, 500),
                'music_company' => $faker->company,
                'description' => $faker->paragraph,
            ]);

            // Assign 1 to 3 random categories to each book
            $randomGenreIds = $faker->randomElements($genreIds, $faker->numberBetween(1, count($genres)));
            $song->genres()->attach($randomGenreIds);
        }
    }
}
