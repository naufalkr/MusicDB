<?php

namespace Database\Seeders;

use App\Models\Song;
use App\Models\Genre;
use App\Models\Singer; // Import model Singer
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BukuGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Seed Genre Table with Music Genres
        $genres = [
            'Pop', 
            'Rock', 
            'Jazz', 
            'Classical', 
            'Hip-Hop', 
            'Country', 
            'R&B', 
            'Electronic', 
            'Reggae', 
            'Blues', 
            'Metal', 
            'Folk', 
            'Soul', 
            'Punk', 
            'Gospel', 
            'Dance', 
            'Latin', 
            'Alternative', 
            'Indie', 
            'Opera', 
            'Techno'
        ];
        
        $genreIds = [];

        foreach ($genres as $genre) {
            $genreModel = Genre::create([
                'nama' => $genre,
            ]);
            $genreIds[] = $genreModel->id;
        }

        // Ambil semua nama artis dari tabel singers
        $singerNames = Singer::pluck('nama')->toArray();

        // Seed Song Table and attach Genre
        foreach (range(1, 100) as $index) {
            $song = Song::create([
                'title' => $faker->sentences($faker->numberBetween(1, 5), true), // 1-5 kalimat untuk title
                'artist' => $faker->randomElement($singerNames), // Ambil nama artis dari tabel singers
                'album' => $faker->sentences($faker->numberBetween(1, 5), true), // 1-5 kalimat untuk album
                'year' => $faker->year,
                'duration' => $faker->numberBetween(100, 500),
                'music_company' => $faker->company,
                'description' => $faker->paragraph,
            ]);

            // Assign 1 to 3 random genres to each song
            $randomGenreIds = $faker->randomElements($genreIds, $faker->numberBetween(1, 3));
            $song->genres()->attach($randomGenreIds);
        }
    }
}
