<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Playlist;
use Faker\Factory as Faker;

class PlaylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Misal kita ingin menambahkan 10 penyanyi ke tabel playlists
        foreach (range(1, 7) as $index) {
            Playlist::create([
                'nama' => $faker->name,
                'release_date' => $faker->paragraph(3), // bio dengan 3 paragraf acak
            ]);
        }
    }
}
