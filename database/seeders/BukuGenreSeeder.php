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
                'title' => $faker->words($faker->numberBetween(2, 4), true), // Judul lagu antara 2-4 kata
                'artist_id' => $faker->randomElement($singerIds), // ID penyanyi dari tabel singer
                'albm_id' => $faker->randomElement($albumIds), // ID album dari tabel album
                'year' => $faker->year($max = 'now'), // Tahun rilis yang acak dari masa lalu hingga sekarang
                'duration' => $faker->numberBetween(180, 420), // Durasi lagu antara 3 hingga 7 menit dalam detik
                'rl_id' => $faker->randomElement($recordlabelIds), // ID label rekaman dari tabel record label
                'description' => $faker->realText($faker->numberBetween(50, 150)), // Deskripsi singkat antara 50-150 karakter
            ]);

            // Assign 1 to 3 random genres to each song
            $randomGenreIds = $faker->randomElements($genreIds, $faker->numberBetween(1, 3));
            $song->genres()->attach($randomGenreIds);
        }
    }
}
