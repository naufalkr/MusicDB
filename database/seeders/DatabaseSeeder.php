<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(SingerSeeder::class);
        $this->call(AlbumSeeder::class);
        $this->call(RecordlabelSeeder::class);        
        $this->call(BukuGenreSeeder::class);
        $this->call(PlaylistSeeder::class);
        // $this->call(FavoriteSeeder::class); 
    }
}
