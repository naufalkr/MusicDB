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
            // '4q8ce3VGQzroZzwrRhRwKf',
            // '4Xv41B0BJRcMBJYpavNDfD',
            // '7z7kvUQGwlC6iOl7vMuAr9',
            // '4tKGFmENO69tZR9ahgZu48',
            // '6ECp64rv50XVz93WvxXMGF',
            // '6gGSSrKMiV2yec1DrqGhhy',       
            // '1SKPmfSYaPsETbRHaiA18G',
            // '4IlqQhaxrGPxmg35YcXXuS',
            // '41BxLqai6W39BVVAtzKSM1',                   
            // '2V4bv1fNWfTcyRJKmej6Sj',
            // '2THkQauDWMvJgXFGPY4iKB',
            // '7kzKAuUzOITUauHAhoMoxA',       
            // '6g7xA2g7QIMwp4CKXnGVUa',
            // '1PpfeNl5uYRBhfFcig2Uz6',
            // '3lyLqIn8mybyEFTs8JJaLf',                   
            // '5xEM5hIgJ1jjgcEBfpkt2F',
            // '3PNOYDruQplC92lNc7mE9W',
            // '4HlFJV71xXKIGcU3kRyttv',       
            // '57Xjny5yNzAcsxnusKmAfA',
            // '5xKovpSlp7iKLMQTwGhOaD',
            // '0sA3OZTBMIEQgMj1OGXd5x',                   
            // '02XnQdf7sipaKBBHixz3Zp',
            // '7oQs0qakNPmmRNvXcr9QBT',
            // '4h5m56ExHLPUC9NGz7U1Qa',       
            // '6kopmMZiyLmw7h66uXcXR7',
            // '1mea3bSkSGXuIRvnydlB5b',
            // '45hOioMDJktr86iKDHC8gr',       
            // '1wiwNChjumfgxJ7MFX1rOC',
            // '5i04Jy87RLxoZszJqY3QAN',
            // '3E7dfMvvCLUddWissuqMwr',       
            // '4kLLWz7srcuLKA7Et40PQR',
            // '6vhYDNMZgffPwcdXdvMqCS',
            // '6naxalmIoLFWR0siv8dnQQ',       
            // '5qII2n90lVdPDcgXEEVHNy',
            // '0HPD5WQqrq7wPWR7P7Dw1i',
            // '2vwlzO0Qp8kfEtzTsCXfyE',       
            // '456WNXWhDwYOSf5SpTuqxd',
            // '3Fzlg5r1IjhLk2qRw667od',
            // '1Cwsd5xI8CajJz795oy4XF',       
            // '5VGlqQANWDKJFl0MBG3sg2',
            // '4c6vZqYHFur11FbWATIJ9P',
            // '003vvx7Niy0yvhvHt4a68B',       
            // '4q8ce3VGQzroZzwrRhRwKf',
            // '4tKGFmENO69tZR9ahgZu48',
            // '1lbXEepatjRVjoG8pZMtdp',       
            // '13b3kZAjZGltp76ed4u1m3',
            // '5rgy6ghBq1eRApCkeUdJXf',
            // '754kgU5rWscRTfvlsuEwFp',       
            // '2hKdd3qO7cWr2Jo0Bcs0MA',
            // '5qqabIl2vWzo9ApSC317sa',
            // '1KZyVnyptQcPzkx7ELCnZC',       
            // '6UelLqGlWMcVH1E5c4H7lY',
            // '3U5JVgI2x4rDyHGObzJfNf',
            // '0VjIjW4GlUZAMYd2vXMi3b',       
            // '0azC730Exh71aQlOt9Zj3y',
            // '7HW5WIw7ZgZORCzUxv5gW5',
            // '3DWOTqMQGp5q75fnVsWwaN',   
            // '38zsOOcu31XbbYj9BIPUF1',
            // '5zA8vzDGqPl2AzZkEYQGKh',
            // '6sy3LkhNFjJWlaeSMNwQ62',       
            // '25FTMokYEbEWHEdss5JLZS',
            // '5WDLRQ3VCdVrKw0njWe5E5',
            // '1CQ2cMfrmFM1YdfmjENKVE', 
            '0TDLuuLlV54CkRRUOahJb4',
            '70eDxAyAraNTiD6lx2ZEnH',
            '5CLGzJsGqhCEECcpnFQA8x',       
            '3SdTKo2uVsxFblQjpScoHy',
            '4V9BTST4BSkvOL4xIQNHuS',
            '4QNpBfC0zvjKqPJcyqBy9W',   
            '4lYKuF88iTBrppJoq03ujE',
            '1gv4xPanImH17bKZ9rOveR',
            '3CeCwYWvdfXbZLXFhBrbnf',       
            '0GONea6G2XdnHWjNZd6zt3',
            '6W7ztLBiRzBN46ZaPAcQ0F',
            '6qspW4YKycviDFjHBOaqUY',         
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
