<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Song;
use App\Models\Album;
use App\Models\Singer;
use App\Models\Recordlabel;

class SongsTableSeeder extends Seeder
{
    protected $spotifyService; // Asumsikan Anda memiliki SpotifyService

    public function __construct()
    {
        $this->spotifyService = app('App\Services\SpotifyService'); // Atur sesuai dengan service Spotify Anda
    }

    public function run()
    {
        // Daftar Spotify Track ID yang ingin Anda tambahkan
        $spotifyTrackIds = [
            '4q8ce3VGQzroZzwrRhRwKf',
            '4Xv41B0BJRcMBJYpavNDfD',
            '7z7kvUQGwlC6iOl7vMuAr9', // Tambahkan ID lainnya sesuai kebutuhan
        ];

        foreach ($spotifyTrackIds as $trackId) {
            // Fetch track data from Spotify
            $spotifyTrack = $this->spotifyService->getTrackById($trackId);
        
            // Extract necessary IDs
            $spotify_album_id = $spotifyTrack['album']['id'];
            $spotify_artist_id = $spotifyTrack['artists'][0]['id'];
            $spotify_recordlabel_id = $spotifyTrack['album']['id']; // Adjust if needed

            $spotifyAlbum = $this->spotifyService->getAlbumById($spotify_album_id);
            $spotifyArtist = $this->spotifyService->getArtistById($spotify_artist_id);
            $spotifyRecordlabel = $this->spotifyService->getRecordlabelById($spotify_recordlabel_id);
        
            $album = Album::firstOrCreate(
                ['nama' => $spotifyAlbum['name']], 
                [
                    'release_date' => $spotifyAlbum['release_date'],
                    'image_url' => $spotifyAlbum['images'][0]['url'] ?? null
                ]
            );
        
            // Check if the artist already exists by name
            $artist = Singer::firstOrCreate(
                ['nama' => $spotifyArtist['name']], // Check by artist name
                [
                    'bio' => $spotifyArtist['genres'] ? implode(', ', $spotifyArtist['genres']) : 'No genre info'
                ]
            );
        
            // Check if the record label already exists by name
            $recordlabel = Recordlabel::firstOrCreate(
                ['nama' => $spotifyRecordlabel['label']], // Check by record label name
                [
                    'country' => $spotifyRecordlabel['total_tracks'] ?? null, // Adjust as needed
                ]
            );
        
            // Create the song
            Song::create([
                'title' => $spotifyTrack['name'],
                'artist_id' => $artist->id,
                'albm_id' => $album->id,
                'year' => $spotifyTrack['album']['release_date'] ? date('Y', strtotime($spotifyTrack['album']['release_date'])) : null,
                'duration' => (int) ($spotifyTrack['duration_ms'] / 1000),
                'rl_id' => $recordlabel->id,
                'category' => $spotifyArtist['genres'] ? implode(', ', $spotifyArtist['genres']) : 'No genre info',
                'description' => $spotifyTrack['popularity'] ?? null,
            ]);
        }
    }
}
