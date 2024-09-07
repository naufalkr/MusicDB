<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Singer;
use Faker\Factory as Faker;

class SingerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Misal kita ingin menambahkan 10 penyanyi ke tabel singers
        foreach (range(1, 100) as $index) {
            Singer::create([
                'nama' => $faker->name,
                'bio' => $faker->paragraph(3), // bio dengan 3 paragraf acak
            ]);
        }
    }
}
