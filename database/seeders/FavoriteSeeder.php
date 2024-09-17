<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Favorite;
use Faker\Factory as Faker;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Misal kita ingin menambahkan 10 penyanyi ke tabel favorites
        foreach (range(1, 100) as $index) {
            Favorite::create([
                'nama' => $faker->name,
                'release_date' => $faker->paragraph(3), // bio dengan 3 paragraf acak
            ]);
        }
    }
}
