<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewSongRequest;
use App\Http\Requests\UpdateSongRequest;
use App\Models\Song;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SongController extends Controller
{
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
    

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'artist_id' => 'required|exists:singer,id',
            // 'album' => 'required|string',
            'albm_id' => 'required|exists:album,id',
            'year' => 'nullable|integer',
            'duration' => 'nullable|integer',
            // 'music_company' => 'required|string',
            'rl_id' => 'required|exists:recordlabel,id',
            'description' => 'nullable|string',
            'genre' => 'required|array', // Ensure genre is an array
            'genre.*' => 'exists:genre,id' // Ensure each genre ID exists in the genres table
        ]);
    
        $song = Song::create([
            'title' => $request->input('title'),
            'artist_id' => $request->input('artist_id'),
            // 'album' => $request->input('album'),
            'albm_id' => $request->input('albm_id'),            
            'year' => $request->input('year'),
            'duration' => $request->input('duration'),
            // 'music_company' => $request->input('music_company'),            
            'rl_id' => $request->input('rl_id'),    
            'description' => $request->input('description'),
        ]);
    
        // Attach genres to the song
        $song->genres()->attach($request->input('genre'));
    
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
