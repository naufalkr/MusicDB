<?php

namespace App\Services;

use GuzzleHttp\Client;

class SpotifyService
{
    protected $client;
    protected $token;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://api.spotify.com/v1/']);

        // Ambil access token dari Spotify API
        $this->token = $this->getAccessToken();
    }

    // Method untuk mendapatkan Access Token dari Spotify API
    protected function getAccessToken()
    {
        $client = new Client();
        $response = $client->post('https://accounts.spotify.com/api/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => env('SPOTIFY_CLIENT_ID'),
                'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
            ],
        ]);

        $body = json_decode($response->getBody(), true);
        return $body['access_token'];
    }

    // Method untuk mengambil data album dari Spotify berdasarkan ID
    public function getAlbumById($albumId)
    {
        $response = $this->client->get("albums/{$albumId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getArtistById($artistId)
    {
        $response = $this->client->get("artists/{$artistId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getRecordlabelById($RecordlabelId)
    {
        $response = $this->client->get("albums/{$RecordlabelId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getPlaylistById($PlaylistId)
    {
        $response = $this->client->get("playlists/{$PlaylistId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getTrackById($trackId)
    {
        $response = $this->client->get("tracks/{$trackId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getShowById($showId)
    {
        $response = $this->client->get("shows/{$showId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getEpisodeById($episodeId)
    {
        $response = $this->client->get("episodes/{$episodeId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }


    
}
