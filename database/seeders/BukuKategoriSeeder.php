<?php

namespace Database\Seeders;

use App\Models\Song;
use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class SongKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Seed Kategori Table
        $kategoris = [
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
        
        $kategoriIds = [];

        foreach ($kategoris as $kategori) {
            $kategoriModel = Kategori::create([
                'nama' => $kategori,
            ]);
            $kategoriIds[] = $kategoriModel->id;
        }

        // Seed Song Table and attach Kategori
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
            $randomKategoriIds = $faker->randomElements($kategoriIds, $faker->numberBetween(1, count($kategoris)));
            $song->kategoris()->attach($randomKategoriIds);
        }
    }
}
