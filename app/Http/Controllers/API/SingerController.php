<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SingerResource;
use App\Models\Singer;
use App\Services\SpotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SingerController extends Controller
{
    protected $spotify;

    public function __construct(SpotifyService $spotify)
    {
        $this->spotify = $spotify;
    }

    /**
     * Display a listing of the singers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $singers = Singer::latest()->get();
        return response()->json([
            'data' => SingerResource::collection($singers),
            'message' => 'Fetch all singers',
            'success' => true
        ]);
    }

    /**
     * Store a newly created singer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the input Spotify Artist ID
        $validator = Validator::make($request->all(), [
            'spotify_artist_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        // Fetch singer data from Spotify API by ID
        $spotifyArtist = $this->spotify->getArtistById($request->spotify_artist_id);

        // Save the singer data to the database
        $singer = Singer::create([
            'nama' => $spotifyArtist['name'],
            'bio' => $spotifyArtist['genres'] ? implode(', ', $spotifyArtist['genres']) : 'No genre info',
        ]);

        return response()->json([
            'data' => new SingerResource($singer),
            'message' => 'Singer created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified singer.
     *
     * @param  \App\Models\Singer  $singer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Singer $singer)
    {
        return response()->json([
            'data' => new SingerResource($singer),
            'message' => 'Singer data found',
            'success' => true
        ]);
    }

    /**
     * Update the specified singer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Singer  $singer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Singer $singer)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'bio' => 'nullable|string', // Optional bio
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        // Update the singer record with the validated data
        $singer->update([
            'nama' => $request->get('nama'),
            'bio' => $request->get('bio'),
        ]);

        // Return success response with the updated singer
        return response()->json([
            'data' => new SingerResource($singer),
            'message' => 'Singer updated successfully',
            'success' => true
        ]);
    }


    // public function update(Request $request, Singer $singer)
    // {
    //     // Validate the input Spotify Artist ID
    //     $validator = Validator::make($request->all(), [
    //         'spotify_artist_id' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'data' => [],
    //             'message' => $validator->errors(),
    //             'success' => false
    //         ]);
    //     }

    //     // Fetch singer data from Spotify API by ID
    //     $spotifyArtist = $this->spotify->getArtistById($request->spotify_artist_id);

    //     // Update the singer in the database
    //     $singer->update([
    //         'nama' => $spotifyArtist['name'],
    //         'bio' => $spotifyArtist['genres'] ? implode(', ', $spotifyArtist['genres']) : 'No genre info',
    //     ]);

    //     return response()->json([
    //         'data' => new SingerResource($singer),
    //         'message' => 'Singer updated successfully.',
    //         'success' => true
    //     ]);
    // }

    /**
     * Remove the specified singer from storage.
     *
     * @param  \App\Models\Singer  $singer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Singer $singer)
    {
        $singer->delete();

        return response()->json([
            'data' => [],
            'message' => 'Singer deleted successfully.',
            'success' => true
        ]);
    }
}
