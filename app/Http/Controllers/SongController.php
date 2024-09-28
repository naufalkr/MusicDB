<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewSongRequest;
use App\Http\Requests\UpdateSongRequest;
use App\Models\Song;
use App\Models\Genre;
use App\Models\Album;
use App\Models\Recordlabel;
use App\Models\Singer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Services\SpotifyService;

class SongController extends Controller
{
    protected $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }
    public function index(Request $request)
    {
        $relation = 'genres'; 

        // LAZY LOADING
        // $data['song'] = Song::SearchWithRelations($request, $relation, ['nama'])->paginator($request);

        // EAGER LOADING
        $data['song'] = Song::with($relation)
        ->searchWithRelations($request, $relation, ['nama'])->paginator($request);

        return view('pertemuan2.song.index', compact('data'));
    }

    public function create()
    {
        $data['genre'] = Genre::all();
        return view('pertemuan2.song.create',compact('data'));
    }
    

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string',
    //         'artist_id' => 'required|exists:singer,id',
    //         'year' => 'nullable|integer',
    //         'duration' => 'nullable|integer',
    //         // 'music_company' => 'required|string',
    //         'rl_id' => 'required|exists:recordlabel,id',
    //         'description' => 'nullable|string',
    //         'genre' => 'required|array', // Ensure genre is an array
    //         'genre.*' => 'exists:genre,id' // Ensure each genre ID exists in the genres table
    //     ]);
    
    //     $song = Song::create([
    //         'title' => $request->input('title'),
    //         'artist_id' => $request->input('artist_id'),         
    //         'year' => $request->input('year'),
    //         'duration' => $request->input('duration'),
    //         // 'music_company' => $request->input('music_company'),            
    //         'rl_id' => $request->input('rl_id'),    
    //         'description' => $request->input('description'),
    //     ]);
    
    //     // Attach genres to the song
    //     $song->genres()->attach($request->input('genre'));
    
    //     return redirect()->route('crud-song.index')->with('success', 'Song added successfully.');
    // }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'spotify_track_id' => 'required|string',
        ]);
    
        // Fetch track data from Spotify
        $spotifyTrack = $this->spotifyService->getTrackById($request->spotify_track_id);
    
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
                // 'id' => $spotify_artist_id, // Set the ID
                'bio' => $spotifyArtist['genres'] ? implode(', ', $spotifyArtist['genres']) : 'No genre info'
            ]
        );
    
        // Check if the record label already exists by name
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
    
        // Attach genres to the song if necessary
        // $song->genres()->attach($request->input('genre'));
    
        return redirect()->route('crud-song.index')->with('success', 'Song added successfully.');
    }
    
    public function show(Song $song)
    {
        $data['song'] = $song;
        return view('pertemuan2.song.show', compact('data'));
    }
    public function edit(Song $song) 
    {
        $data['song'] = $song;
        $data['song-genre'] = $song->genres->pluck('id')->toArray();
        $data['genre'] = Genre::all();
        return view('pertemuan2.song.edit', compact('data'));
    }
    
    public function update(UpdateSongRequest $request, Song $song)
    {
        $validatedData = $request->validated();
        unset($validatedData['genre']);
        $song->update($validatedData);
        $song->genres()->sync($request->input('genre'));
        return redirect()->route('crud-song.index', $song->id)->with('success', 'song "'.$song->title.'" sukses diubah');
    }

    public function destroy(Song $song)
    {
        $song->genres()->detach();
        $song->delete();
        return redirect()->route('crud-song.index')->with('success', 'Song "' . $song->title . '" sukses dihapus".');
    }
}
