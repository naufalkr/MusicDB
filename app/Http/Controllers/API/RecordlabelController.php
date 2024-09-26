<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecordlabelResource;
use App\Models\Recordlabel;
use App\Services\SpotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecordlabelController extends Controller
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
        $recordlabels = Recordlabel::latest()->get();
        return response()->json([
            'data' => RecordlabelResource::collection($recordlabels),
            'message' => 'Fetch all record labels',
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
        // Validasi input Spotify Recordlabel ID
        $validator = Validator::make($request->all(), [
            'spotify_recordlabel_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        // Ambil data recordlabel dari Spotify API berdasarkan ID
        $spotifyRecordlabel = $this->spotify->getRecordlabelById($request->spotify_recordlabel_id);

        // Simpan data recordlabel ke dalam database
        $recordlabel = Recordlabel::create([
            'nama' => $spotifyRecordlabel['label'], // Nama recordlabel
            'country' => $spotifyRecordlabel['artists'][0]['name'], // Country
            // 'image_url' => $spotifyRecordlabel['images'][0]['url'] ?? null, // URL gambar recordlabel
        ]);

        return response()->json([
            'data' => new RecordlabelResource($recordlabel),
            'message' => 'Record label created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recordlabel  $recordlabel
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Recordlabel $recordlabel)
    {
        return response()->json([
            'data' => new RecordlabelResource($recordlabel),
            'message' => 'Record label found',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recordlabel  $recordlabel
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Recordlabel $recordlabel)
    {
        // Validasi input Spotify Recordlabel ID
        $validator = Validator::make($request->all(), [
            'spotify_recordlabel_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        // Ambil data recordlabel dari Spotify API berdasarkan ID
        $spotifyRecordlabel = $this->spotify->getRecordlabelById($request->spotify_recordlabel_id);

        // Update data recordlabel di dalam database
        $recordlabel->update([
            'nama' => $spotifyRecordlabel['label'], // Nama recordlabel
            'country' => $spotifyRecordlabel['artists'][0]['name'], // Country
            // 'image_url' => $spotifyRecordlabel['images'][0]['url'] ?? null, // URL gambar recordlabel
        ]);

        return response()->json([
            'data' => new RecordlabelResource($recordlabel),
            'message' => 'Record label updated successfully',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recordlabel  $recordlabel
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Recordlabel $recordlabel)
    {
        $recordlabel->delete();

        return response()->json([
            'data' => [],
            'message' => 'Record label deleted successfully',
            'success' => true
        ]);
    }
}
