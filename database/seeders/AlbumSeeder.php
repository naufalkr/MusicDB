<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Album;
use Faker\Factory as Faker;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $imageUrls = [
            'https://i.pinimg.com/564x/fe/44/b3/fe44b3bd43a6b957a8ccea170c13f168.jpg',
            'https://i.pinimg.com/236x/23/88/2a/23882a01739ff8024e793bee3313b426.jpg',
            'https://i.pinimg.com/236x/cf/94/73/cf94731a56400bb953d7c7975628ba38.jpg',
            'https://i.pinimg.com/236x/a1/4a/a2/a14aa253fbdc08fa9d0892b7f8fd0d4c.jpg',
            'https://i.pinimg.com/236x/9c/65/41/9c65411771fc80247ccc055362da7f8d.jpg',
            'https://i.pinimg.com/236x/5e/7a/7d/5e7a7da9fe5941eac650f6fc48988ec0.jpg',
            'https://i.pinimg.com/236x/a3/96/de/a396de840cc2bf7c21d03d1086f77206.jpg',
            'https://i.pinimg.com/236x/3f/00/3c/3f003c7f7e6857be02d0f0fcae23e8e6.jpg',
            'https://i.pinimg.com/236x/ed/5e/85/ed5e8567d1f09f35e4a210510929ecbd.jpg',
            'https://i.pinimg.com/236x/9b/75/77/9b75771739bfdd164451683f29c78c0d.jpg',
            'https://i.pinimg.com/236x/66/2a/26/662a263374fe24bb1b3a65818ed214b6.jpg',
        ];

        // Tambahkan 100 album ke tabel albums
        foreach (range(1, 100) as $index) {
            Album::create([
                'nama' => $faker->sentence(3), // Nama album dengan 3 kata
                'release_date' => $faker->date(), // Tanggal rilis album
                'image_url' => $faker->randomElement($imageUrls), // Pilih link gambar secara acak
            ]);
        }
    }
}
