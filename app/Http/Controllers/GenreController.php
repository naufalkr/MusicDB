<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController
{
    public function index(Request $request)
    {
        $data['genre'] = $query = Genre::with('songs')->search($request)->paginator($request);
        return view('pertemuan2.genre.index', compact('data'));
    }

    public function create()
    {
        return view('pertemuan2.genre.create');
    }

    public function store(GenreRequest $request)
    {
        $validatedData = $request->validated();
        $genre = Genre::create($validatedData);
        return redirect()->route('crud-genre.index', $genre->id)->with('success', 'genre "'.$genre->nama.'" sukses ditambahkan');
    }

    public function show(Genre $genre)
    {
        $data['genre'] = $genre;
        return view('pertemuan2.genre.show', compact('data'));
    }

    public function edit(Genre $genre)
    {
        $data['genre'] = $genre;
        return view('pertemuan2.genre.edit', compact('data'));
    }

    public function update(GenreRequest $request, Genre $genre)
    {
        $validatedData = $request->validated();
        $genre->update($validatedData);
        return redirect()->route('crud-genre.index', $genre->id)->with('success', 'genre "'.$genre->nama.'" sukses diubah');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return redirect()->route('crud-genre.index')->with('success', 'Genre "' . $genre->nama . '" sukses dihapus".');
    }
}
