<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EpisodeResource;
use App\Models\Episode;
use App\Models\Show;
use App\Services\SpotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EpisodeController extends Controller
{
    protected $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    /**
     * Display a listing of the episodes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $episodes = Episode::latest()->get();
        return response()->json([
            'data' => EpisodeResource::collection($episodes),
            'message' => 'Fetch all episodes',
            'success' => true
        ]);
    }

    /**
     * Store a newly created episode from Spotify in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the Spotify episode ID input
        $validator = Validator::make($request->all(), [
            'spotify_episode_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        // Fetch the episode data from Spotify
        $spotifyEpisode = $this->spotifyService->getEpisodeById($request->spotify_episode_id);
        $spotifyShowId = $spotifyEpisode['show']['id'];
        $spotifyShow = $this->spotifyService->getShowById($spotifyShowId);

        // Check if the show exists in the database or create a new one
        $show = Show::firstOrCreate(
            ['nama' => $spotifyShow['name']],
            [
                'release_date' => $spotifyShow['publisher'],
                'image_url' => $spotifyShow['images'][0]['url'] ?? null
            ]
        );

        // Create the episode in the database
        $episode = Episode::create([
            'title' => $spotifyEpisode['name'],
            'podcast_id' => $show->id,
            // 'year' => (int) $spotifyEpisode['languages'][0],  // Adjusted if applicable
            // 'release_date' => $spotifyEpisode['release_date'],
            'year' => (int) ($spotifyEpisode['release_date']),                        
            'release_date' => ($spotifyShow['publisher']),
            'duration' => (int) ($spotifyEpisode['duration_ms'] / 1000),
            'description' => $spotifyEpisode['description'] ?? null,
                           
        ]);

        return response()->json([
            'data' => new EpisodeResource($episode),
            'message' => 'Episode created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified episode.
     *
     * @param  \App\Models\Episode  $episode
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Episode $episode)
    {
        return response()->json([
            'data' => new EpisodeResource($episode),
            'message' => 'Episode found',
            'success' => true
        ]);
    }


    /**
     * Update the specified episode in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Episode  $episode
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Episode $episode)
    {
        // Validasi input dari request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255', // Title harus ada dan berupa string
            'podcast_id' => 'required|exists:show,id', // Pastikan podcast_id ada di tabel show
            'year' => 'nullable|digits:4', // Validasi tahun sebagai angka 4 digit
            'publisher' => 'required|string|max:255', // Validasi format release_date
            'duration' => 'nullable|integer', // Durasi harus berupa integer
            'description' => 'nullable|string', // Deskripsi optional
        ]);

        // Jika validasi gagal, kembalikan pesan error
        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        // Update data episode berdasarkan input yang sudah tervalidasi
        $episode->update([
            'title' => $request->get('title'),
            'podcast_id' => $request->get('podcast_id'),
            'year' => $request->get('year'),
            'release_date' => $request->get('publisher'),
            'duration' => $request->get('duration'),
            'description' => $request->get('description'),
        ]);

        // Kembalikan respons sukses beserta data episode yang sudah diupdate
        return response()->json([
            'data' => new EpisodeResource($episode),
            'message' => 'Episode updated successfully',
            'success' => true
        ]);
    }

    // public function update(Request $request, Episode $episode)
    // {
    //     // Validate the request
    //     $validator = Validator::make($request->all(), [
    //         'spotify_episode_id' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'data' => [],
    //             'message' => $validator->errors(),
    //             'success' => false
    //         ]);
    //     }

    //     // Fetch updated episode data from Spotify
    //     $spotifyEpisode = $this->spotifyService->getEpisodeById($request->spotify_episode_id);

    //     // Update the episode data in the database
    //     $episode->update([
    //         'title' => $spotifyEpisode['name'],
    //         // 'year' => (int) $spotifyEpisode['languages'][0],
    //         // 'release_date' => $spotifyEpisode['release_date'],
    //         // 'year' => $spotifyEpisode['show']['release_date'] ? date('Y', strtotime($spotifyEpisode['show']['release_date'])) : null,
    //         'year' => (int) ($spotifyShow['release_date']),                        
    //         'release_date' => (int) ($spotifyEpisode['publisher']),   
    //         'duration' => (int) ($spotifyEpisode['duration_ms'] / 1000),
    //         'description' => $spotifyEpisode['description'] ?? null,
    //     ]);

    //     return response()->json([
    //         'data' => new EpisodeResource($episode),
    //         'message' => 'Episode updated successfully',
    //         'success' => true
    //     ]);
    // }

    /**
     * Remove the specified episode from storage.
     *
     * @param  \App\Models\Episode  $episode
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Episode $episode)
    {
        $episode->delete();

        return response()->json([
            'data' => [],
            'message' => 'Episode deleted successfully',
            'success' => true
        ]);
    }
}
