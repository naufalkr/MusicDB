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

        $spotifyAlbum = $this->spotifyService->getAlbumById($spotify_album_id);
        $spotifyArtist = $this->spotifyService->getArtistById($spotify_artist_id);
        $spotifyRecordlabel = $this->spotifyService->getRecordlabelById($spotify_recordlabel_id);

        // $album = Album::firstOrCreate(
        //     ['nama' => $spotifyAlbum['name']],
        //     ['release_date' => $spotifyAlbum['release_date']], 
        //     ['image_url' => $spotifyAlbum['images'][0]['url'] ?? null] 
        // );
        $album = Album::firstOrCreate(
            ['nama' => $spotifyAlbum['name']], 
            [
                'release_date' => $spotifyAlbum['release_date'],
                'image_url' => $spotifyAlbum['images'][0]['url'] ?? null
            ]
        );

        // $artist = Singer::firstOrCreate(
        //     ['nama' => $spotifyArtist['name']],
        //     ['bio' => $spotifyArtist['genres'] ? implode(', ', $spotifyArtist['genres']) : 'No genre info']
        // );

               
        $artist = Singer::firstOrCreate(
            ['nama' => $spotifyArtist['name']], // Check by artist name
            [
                // 'id' => $spotify_artist_id, // Set the ID
                'bio' => $spotifyArtist['genres'] ? implode(', ', $spotifyArtist['genres']) : 'No genre info'
            ]
        );

        // $recordlabel = Recordlabel::firstOrCreate(
        //     ['nama' => $spotifyRecordlabel['label']],
        //     ['country' => $spotifyRecordlabel['total_tracks'] ?? null]
        // );

        $recordlabel = Recordlabel::firstOrCreate(
            ['nama' => $spotifyRecordlabel['label']], // Check by record label name
            [
                // 'id' => $spotify_recordlabel_id, // Set the ID
                'country' => $spotifyRecordlabel['total_tracks'] ?? null, // Adjust as needed
            ]
        );
    

        // Create the song
        $song = Song::create([
            'title' => $spotifyTrack['name'],
            'artist_id' => $artist->id,
            'albm_id' => $album->id,
            'year' => $spotifyTrack['album']['release_date'] ? date('Y', strtotime($spotifyTrack['album']['release_date'])) : null,
            'duration' => (int) ($spotifyTrack['duration_ms'] / 1000),
            'rl_id' => $recordlabel->id,
            'category' => $spotifyArtist['genres'] ? implode(', ', $spotifyArtist['genres']) : 'No genre info',
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
/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \App\Models\Song  song$
 * @return \Illuminate\Http\JsonResponse
 */
public function update(Request $request, Song $song)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:155',
        'artist_id' => 'required|exists:singer,id', // Ensure foreign key exists
        'albm_id' => 'required|exists:album,id', // Ensure foreign key exists
        'year' => 'nullable|digits:4', // Validate as a 4-digit year
        'duration' => 'nullable|integer', // Ensure duration is an integer
        'rl_id' => 'required|exists:recordlabel,id', // Ensure foreign key exists
        'genre' => 'nullable|string', // Optional category
        'description' => 'nullable|string' // Optional description
    ]);

    // If validation fails, return error response
    if ($validator->fails()) {
        return response()->json([
            'data' => [],
            'message' => $validator->errors(),
            'success' => false
        ]);
    }

    // Update the song record with the validated data
    $song->update([
        'title' => $request->get('title'),
        'artist_id' => $request->get('artist_id'),
        'albm_id' => $request->get('albm_id'),
        'rl_id' => $request->get('rl_id'),
        'year' => $request->get('year'),
        'duration' => $request->get('duration'),
        'category' => $request->get('category'),
        'description' => $request->get('description'),
        // 'slug' => Str::slug($request->get('title'))
    ]);

    // Return success response with the updated song
    return response()->json([
        'data' => new SongResource($song),
        'message' => 'Song updated successfully',
        'success' => true
    ]);
}

    // $table->string('title');
    // $table->foreignId('artist_id')->constrained('singer')->onDelete('cascade'); // Foreign key to singer
    // $table->foreignId('albm_id')->constrained('album')->onDelete('cascade'); // Foreign key to singer
    // $table->foreignId('rl_id')->constrained('recordlabel')->onDelete('cascade'); // Foreign key to singer
    // // $table->string('album');
    // $table->year('year')->nullable();
    // $table->integer('duration')->nullable();
    // // $table->string('music_company')->unique();
    // $table->text('category')->nullable();
    // $table->text('description')->nullable();            
    // $table->timestamps();

//     public function update(Request $request, Song $song)
// {
//     // Log data to see if spotify_track_id is received correctly
//     // dd($request->all()); // Uncomment this for debugging

//     // Validate input
//     $validator = Validator::make($request->all(), [
//         'spotify_track_id' => 'required|string',
//     ]);

//     if ($validator->fails()) {
//         return response()->json([
//             'data' => [],
//             'message' => $validator->errors(),
//             'success' => false
//         ]);
//     }

//     // Fetch track data from Spotify using the provided spotify_track_id
//     $spotifyTrack = $this->spotifyService->getTrackById($request->spotify_track_id);

//     if (!$spotifyTrack) {
//         return response()->json([
//             'data' => [],
//             'message' => 'Spotify track not found',
//             'success' => false
//         ]);
//     }

//     $spotify_album_id = $spotifyTrack['album']['id'];
//     $spotify_artist_id = $spotifyTrack['artists'][0]['id'];
//     $spotify_recordlabel_id = $spotifyTrack['album']['id']; // Adjust if needed

//     // Fetch album, artist, and record label info from Spotify
//     $spotifyAlbum = $this->spotifyService->getAlbumById($spotify_album_id);
//     $spotifyArtist = $this->spotifyService->getArtistById($spotify_artist_id);
//     $spotifyRecordlabel = $this->spotifyService->getRecordlabelById($spotify_recordlabel_id);

//     // Update or create album, artist, and record label in your database
//     $album = Album::firstOrCreate(
//         ['nama' => $spotifyAlbum['name']], 
//         [
//             'release_date' => $spotifyAlbum['release_date'],
//             'image_url' => $spotifyAlbum['images'][0]['url'] ?? null
//         ]
//     );

//     $artist = Singer::firstOrCreate(
//         ['nama' => $spotifyArtist['name']],
//         [
//             'bio' => $spotifyArtist['genres'] ? implode(', ', $spotifyArtist['genres']) : 'No genre info'
//         ]
//     );

//     $recordlabel = Recordlabel::firstOrCreate(
//         ['nama' => $spotifyRecordlabel['label']], 
//         [
//             'country' => $spotifyRecordlabel['total_tracks'] ?? null,
//         ]
//     );

//     // Update the song with new data
//     $song->update([
//         'title' => $spotifyTrack['name'],
//         'artist_id' => $artist->id,
//         'albm_id' => $album->id,
//         'year' => $spotifyTrack['album']['release_date'] ? date('Y', strtotime($spotifyTrack['album']['release_date'])) : null,
//         'duration' => (int) ($spotifyTrack['duration_ms'] / 1000),
//         'rl_id' => $recordlabel->id,
//         'category' => $spotifyArtist['genres'] ? implode(', ', $spotifyArtist['genres']) : 'No genre info',
//         'description' => $spotifyTrack['popularity'] ?? null,
//     ]);        

//     return response()->json([
//         'data' => new SongResource($song),
//         'message' => 'Song updated successfully.',
//         'success' => true
//     ]);
// }

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
