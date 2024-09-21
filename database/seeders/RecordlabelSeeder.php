<?php

namespace Database\Seeders;

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

        // Menambahkan 100 record label ke tabel recordlabels
        foreach (range(1, 100) as $index) {
            Recordlabel::create([
                'nama' => $faker->company, // Menghasilkan nama perusahaan
                'country' => $faker->country, // Menghasilkan negara
            ]);
        }
    }
}
