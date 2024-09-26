<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SongResource;
use App\Models\Song;
use App\Models\Album;
use App\Models\Recordlabel;
use App\Models\Singer;
use App\Services\SpotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SongController extends Controller
{
    protected $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $songs = Song::latest()->get();
        return response()->json([
            'data' => SongResource::collection($songs),
            'message' => 'Fetch all songs',
            'success' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'spotify_track_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        // Fetch track data from Spotify
        $spotifyTrack = $this->spotifyService->getTrackById($request->spotify_track_id);

        $spotify_album_id = $spotifyTrack['album']['id'];
        $spotify_artist_id = $spotifyTrack['artists'][0]['id'];
        $spotify_recordlabel_id = $spotifyTrack['album']['id']; // Adjust if needed

        // Fetch additional data for the album, artist, and record label
        $spotifyAlbum = $this->spotifyService->getAlbumById($spotify_album_id);
        $spotifyArtist = $this->spotifyService->getArtistById($spotify_artist_id);
        $spotifyRecordlabel = $this->spotifyService->getRecordlabelById($spotify_recordlabel_id);

        // Check if the album, artist, and record label already exist, or create them
        $album = Album::firstOrCreate(
            ['nama' => $spotifyAlbum['name']],
            ['release_date' => $spotifyAlbum['release_date'], 'image_url' => $spotifyAlbum['images'][0]['url'] ?? null]
        );

        $artist = Singer::firstOrCreate(
            ['nama' => $spotifyArtist['name']],
            ['bio' => $spotifyArtist['genres'] ? implode(', ', $spotifyArtist['genres']) : 'No genre info']
        );

        $recordlabel = Recordlabel::firstOrCreate(
            ['nama' => $spotifyRecordlabel['label']],
            ['country' => $spotifyRecordlabel['total_tracks'] ?? null]
        );

        // Create the song
        $song = Song::create([
            'title' => $spotifyTrack['name'],
            'artist_id' => $artist->id,
            'albm_id' => $album->id,
            'year' => $spotifyTrack['album']['release_date'] ? date('Y', strtotime($spotifyTrack['album']['release_date'])) : null,
            'duration' => (int) ($spotifyTrack['duration_ms'] / 1000),
            'rl_id' => $recordlabel->id,
            'description' => $spotifyTrack['popularity'] ?? null,
        ]);

        return response()->json([
            'data' => new SongResource($song),
            'message' => 'Song added successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Song $song)
    {
        return response()->json([
            'data' => new SongResource($song),
            'message' => 'Song found',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Song $song)
    {
        $validator = Validator::make($request->all(), [
            'spotify_track_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        // Fetch track data from Spotify
        $spotifyTrack = $this->spotifyService->getTrackById($request->spotify_track_id);

        // Update the song's details
        $song->update([
            'title' => $spotifyTrack['name'],
            'year' => $spotifyTrack['album']['release_date'] ? date('Y', strtotime($spotifyTrack['album']['release_date'])) : null,
            'duration' => (int) ($spotifyTrack['duration_ms'] / 1000),
            'description' => $spotifyTrack['popularity'] ?? null,
        ]);

        return response()->json([
            'data' => new SongResource($song),
            'message' => 'Song updated successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Song $song)
    {
        $song->delete();

        return response()->json([
            'data' => [],
            'message' => 'Song deleted successfully.',
            'success' => true
        ]);
    }
}
