<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShowResource;
use App\Models\Show;
use App\Services\SpotifyService; // Pastikan ini diimpor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShowController extends Controller
{
    protected $spotify;

    public function __construct(SpotifyService $spotify)
    {
        $this->spotify = $spotify;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $shows = Show::latest()->get();
        return response()->json([
            'data' => ShowResource::collection($shows),
            'message' => 'Fetch all shows',
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
        // Validasi input ID Show Spotify
        $validator = Validator::make($request->all(), [
            'spotify_show_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        // Ambil data show dari Spotify API berdasarkan ID
        $spotifyShow = $this->spotify->getShowById($request->spotify_show_id);

        // Simpan data show ke dalam database
        $show = Show::create([
            'nama' => $spotifyShow['name'],
            'release_date' => $spotifyShow['publisher'],
            'image_url' => $spotifyShow['images'][0]['url'] ?? null,
        ]);

        return response()->json([
            'data' => new ShowResource($show),
            'message' => 'Show created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Show  $show
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Show $show)
    {
        return response()->json([
            'data' => new ShowResource($show),
            'message' => 'Data show found',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Show $show
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Show $show)
    {
        // Validasi input ID Show Spotify
        $validator = Validator::make($request->all(), [
            'spotify_show_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        // Ambil data show dari Spotify API berdasarkan ID
        $spotifyShow = $this->spotify->getShowById($request->spotify_show_id);

        // Update data show di dalam database
        $show->update([
            'nama' => $spotifyShow['name'],
            'release_date' => $spotifyShow['publisher'],
            'image_url' => $spotifyShow['images'][0]['url'] ?? null,
        ]);

        return response()->json([
            'data' => new ShowResource($show),
            'message' => 'Show updated successfully',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Show  $show
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Show $show)
    {
        $show->delete();

        return response()->json([
            'data' => [],
            'message' => 'Show deleted successfully',
            'success' => true
        ]);
    }
}
