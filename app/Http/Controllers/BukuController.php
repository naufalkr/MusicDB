<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $relation = 'genres'; 

        // LAZY LOADING
        // $data['song'] = Buku::SearchWithRelations($request, $relation, ['nama'])->paginator($request);

        // EAGER LOADING
        $data['song'] = Buku::with($relation)
        ->searchWithRelations($request, $relation, ['nama'])->paginator($request);

        return view('pertemuan2.buku.index', compact('data'));
    }

    public function create()
    {
        $data['genre'] = Genre::all();
        return view('pertemuan2.buku.create',compact('data'));
    }

    public function store(NewBukuRequest $request)
    {
        $validatedData = $request->validated();
        unset($validatedData['genre']);
        $song = Buku::create($validatedData);
        $song->genres()->attach($request->input('genre'));

        return redirect()->route('crud-song.index')->with('success', 'Buku "' . $song->title . '" sukses ditambahkan.');
    }

    public function show(Buku $song)
    {
        $data['song'] = $song;
        return view('pertemuan2.buku.show', compact('data'));
    }

    public function edit(Buku $song) 
    {
        $data['song'] = $song;
        $data['buku-genre'] = $song->genres->pluck('id')->toArray();
        $data['genre'] = Genre::all();
        return view('pertemuan2.buku.edit', compact('data'));
    }

    public function update(UpdateBukuRequest $request, Buku $song)
    {
        $validatedData = $request->validated();
        unset($validatedData['genre']);
        $song->update($validatedData);
        $song->genres()->sync($request->input('genre'));
        return redirect()->route('crud-song.index', $song->id)->with('success', 'buku "'.$song->title.'" sukses diubah');
    }

    public function destroy(Buku $song)
    {
        $song->genres()->detach();
        $song->delete();
        return redirect()->route('crud-song.index')->with('success', 'Buku "' . $song->title . '" sukses dihapus".');
    }
}
