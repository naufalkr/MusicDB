<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Episode;
use App\Models\Show;
use App\Services\SpotifyService;

class EpisodesTableSeeder extends Seeder
{
    protected $spotifyService; // Asumsikan Anda memiliki SpotifyService

    public function __construct()
    {
        $this->spotifyService = app(SpotifyService::class); // Atur sesuai dengan service Spotify Anda
    }

    public function run()
    {
        // Daftar Spotify Episode ID yang ingin Anda tambahkan
        $spotifyEpisodeIds = [
            // '6tvmDNeUPl2vO00vbK2viA',
            // '5biepeD3eUeZGn76fC6d5x',
            // '7bqv8dhiXpo3YYV5fZrdDK', 
            '46deyZlBRfOvcSzT9NO10r',
            '4SgmT9ppqzPs70go6p1wWi',
            '5pC8KcAn0UcCa1VZ8hQkN9', 
            '5T5nd4LNIwry6r3xxE3e8j',
            '3NSZFXwP3DF1OZKucpDFZK',
            '2UUqPLyLFBjHcaOE75i3cs', 
            '06PnBaAA89FU8C8IGBBu7L',
            '1aId1wEkAnRwZiE2IrjyvX',
            '2ktrxl3umBaSOOtcIFvnUm', 
            '3dY7Qu5YGpSmOkZUmyN3hE',
            '2uAJX8j4llVc3ZOJZsrDZ3',
            '5JppZmezjt3yggRXKy4S1m', 
            '67dQ2LlrY05ojmUpyC0zy5',
            '2XEHzU3AjDemMgk6rdmEfn',
            '0zqZo2ogsgpb4k6QvgvPK0',            
            '4UfbpEokRax7zGFYk256ay',
            '3mDwtXiOEyr7etNEbudLDb', 
            '5qPe6lQmByARK2IaigJVkN',
            '2d60qSgNyoZt1vdSuPXJjg',
            '4ripSPuKowSNicnQgunYWZ', 
        ];

        foreach ($spotifyEpisodeIds as $episodeId) {
            // Fetch episode data from Spotify
            $spotifyEpisode = $this->spotifyService->getEpisodeById($episodeId);

            // Extract necessary IDs
            $spotify_show_id = $spotifyEpisode['show']['id'];

            // Fetch additional data for the show
            $spotifyShow = $this->spotifyService->getShowById($spotify_show_id);

            // Check if the show already exists by name
            $show = Show::firstOrCreate(
                ['nama' => $spotifyShow['name']], // Check by show name
                [
                    'release_date' => $spotifyShow['publisher'], // Adjust if needed
                    'image_url' => $spotifyShow['images'][0]['url'] ?? null
                ]
            );

            // Create the episode
            Episode::create([
                'title' => $spotifyEpisode['name'],
                'podcast_id' => $show->id,
                'year' => (int) date('Y', strtotime($spotifyEpisode['release_date'])), // Extract year
                'release_date' => $spotifyEpisode['release_date'],
                'duration' => (int) ($spotifyEpisode['duration_ms'] / 1000),
                'description' => $spotifyEpisode['description'] ?? null,
            ]);
        }
    }
}
