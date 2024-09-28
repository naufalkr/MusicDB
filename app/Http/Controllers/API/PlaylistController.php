<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlaylistResource;
use App\Models\Playlist;
use App\Services\SpotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlaylistController extends Controller
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
        $playlists = Playlist::latest()->get();
        return response()->json([
            'data' => PlaylistResource::collection($playlists),
            'message' => 'Fetch all playlists',
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
        // Validasi input ID Playlist Spotify
        $validator = Validator::make($request->all(), [
            'spotify_playlist_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        // Ambil data playlist dari Spotify API berdasarkan ID
        $spotifyPlaylist = $this->spotify->getPlaylistById($request->spotify_playlist_id);

        // Simpan data playlist ke dalam database
        $playlist = Playlist::create([
            'nama' => $spotifyPlaylist['name'],
            'release_date' => $spotifyPlaylist['description'],  // Assuming this is the correct mapping
        ]);

        return response()->json([
            'data' => new PlaylistResource($playlist),
            'message' => 'Playlist created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Playlist $playlist)
    {
        return response()->json([
            'data' => new PlaylistResource($playlist),
            'message' => 'Data playlist found',
            'success' => true
        ]);
    }


    /**
     * Update the specified playlist in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Playlist $playlist)
    {
        // Validasi input dari request
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255', // Nama harus ada dan berupa string
            'description' => 'required|string|max:255', // Release date harus dalam format tanggal
        ]);

        // Jika validasi gagal, kembalikan pesan error
        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        // Update data playlist berdasarkan input yang sudah tervalidasi
        $playlist->update([
            'nama' => $request->get('nama'),
            'release_date' => $request->get('description'),
        ]);

        // Kembalikan respons sukses beserta data playlist yang sudah diupdate
        return response()->json([
            'data' => new PlaylistResource($playlist),
            'message' => 'Playlist updated successfully',
            'success' => true
        ]);
    }



    // public function update(Request $request, Playlist $playlist)
    // {
    //     // Validasi input ID Playlist Spotify
    //     $validator = Validator::make($request->all(), [
    //         'spotify_playlist_id' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'data' => [],
    //             'message' => $validator->errors(),
    //             'success' => false
    //         ]);
    //     }

    //     // Ambil data playlist dari Spotify API berdasarkan ID
    //     $spotifyPlaylist = $this->spotify->getPlaylistById($request->spotify_playlist_id);

    //     // Update data playlist di dalam database
    //     $playlist->update([
    //         'nama' => $spotifyPlaylist['name'],
    //         'release_date' => $spotifyPlaylist['description'],  // Assuming this is the correct mapping
    //     ]);

    //     return response()->json([
    //         'data' => new PlaylistResource($playlist),
    //         'message' => 'Playlist updated successfully',
    //         'success' => true
    //     ]);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Playlist $playlist)
    {
        $playlist->delete();

        return response()->json([
            'data' => [],
            'message' => 'Playlist deleted successfully',
            'success' => true
        ]);
    }
}
