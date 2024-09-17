<?php

namespace Database\Seeders;

use App\Models\Song;
use App\Models\Genre;
use App\Models\Singer;
use App\Models\Album;
use App\Models\Recordlabel;
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

        // Ambil semua ID penyanyi dari tabel singers
        $singerIds = Singer::pluck('id')->toArray();

        $albumIds = Album::pluck('id')->toArray();

        $recordlabelIds = Recordlabel::pluck('id')->toArray();

        // Seed Song Table and attach Genre
        foreach (range(1, 100) as $index) {
            $song = Song::create([
                'title' => $faker->sentence($faker->numberBetween(1, 5)), // 1-5 kata untuk title
                'artist_id' => $faker->randomElement($singerIds), // Ambil artist_id dari singer
                // 'album' => $faker->sentence($faker->numberBetween(1, 5)), // 1-5 kata untuk album
                'albm_id' => $faker->randomElement($albumIds), 
                'year' => $faker->year,
                'duration' => $faker->numberBetween(100, 500),
                // 'music_company' => $faker->company,
                'rl_id' => $faker->randomElement($recordlabelIds), 
                'description' => $faker->paragraph,
            ]);

            // Assign 1 to 3 random genres to each song
            $randomGenreIds = $faker->randomElements($genreIds, $faker->numberBetween(1, 3));
            $song->genres()->attach($randomGenreIds);
        }
    }
}
