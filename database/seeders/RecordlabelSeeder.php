<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Recordlabel;
use Faker\Factory as Faker;

class RecordlabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Misal kita ingin menambahkan 10 penyanyi ke tabel recordlabels
        foreach (range(1, 100) as $index) {
            Recordlabel::create([
                'nama' => $faker->name,
                'country' => $faker->paragraph(3), // bio dengan 3 paragraf acak
            ]);
        }
    }
}
