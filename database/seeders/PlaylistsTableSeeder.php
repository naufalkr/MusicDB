<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Playlist;
use App\Services\SpotifyService;

class PlaylistsTableSeeder extends Seeder
{
    protected $spotifyService; // Asumsikan Anda memiliki SpotifyService

    public function __construct()
    {
        $this->spotifyService = app(SpotifyService::class); // Atur sesuai dengan service Spotify Anda
    }

    public function run()
    {
        // Daftar Spotify Playlist ID yang ingin Anda tambahkan
        $spotifyPlaylistIds = [
            '37i9dQZF1DX2DKrE9X6Abv',
            '37i9dQZF1DWVV27DiNWxkR',
            '37i9dQZF1DWZIQpJDqCc10', // Tambahkan ID lainnya sesuai kebutuhan
        ];

        foreach ($spotifyPlaylistIds as $playlistId) {
            // Fetch playlist data from Spotify
            $spotifyPlaylist = $this->spotifyService->getPlaylistById($playlistId);
        
            // Create a new Playlist instance
            $playlist = new Playlist();
            $playlist->nama = $spotifyPlaylist['name']; // Playlist name
            $playlist->release_date = $spotifyPlaylist['description']; // Release date
        
            // Check if an image URL exists
            if (isset($spotifyPlaylist['images'][0]['url'])) {
                $imageUrl = $spotifyPlaylist['images'][0]['url'];
        
                // Download the image and store it in the public storage
                $imageContents = file_get_contents($imageUrl); // Get image content
        
                // Generate a unique name for the image
                $imageName = uniqid() . '.jpg'; // You can also use other extensions based on the image type
        
                // Store the image in storage
                \Storage::put('public/playlist_images/' . $imageName, $imageContents);
        
                // Save the path to the database
                $playlist->image_path = 'public/playlist_images/' . $imageName;
            }
        
            // Save the playlist to the database
            $playlist->save();
        }
    }
}
