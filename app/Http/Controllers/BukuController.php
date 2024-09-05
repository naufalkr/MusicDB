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
        // $data['buku'] = Buku::SearchWithRelations($request, $relation, ['nama'])->paginator($request);

        // EAGER LOADING
        $data['buku'] = Buku::with($relation)
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
        $buku = Buku::create($validatedData);
        $buku->genres()->attach($request->input('genre'));

        return redirect()->route('crud-buku.index')->with('success', 'Buku "' . $buku->title . '" sukses ditambahkan.');
    }

    public function show(Buku $buku)
    {
        $data['buku'] = $buku;
        return view('pertemuan2.buku.show', compact('data'));
    }

    public function edit(Buku $buku) 
    {
        $data['buku'] = $buku;
        $data['buku-genre'] = $buku->genres->pluck('id')->toArray();
        $data['genre'] = Genre::all();
        return view('pertemuan2.buku.edit', compact('data'));
    }

    public function update(UpdateBukuRequest $request, Buku $buku)
    {
        $validatedData = $request->validated();
        unset($validatedData['genre']);
        $buku->update($validatedData);
        $buku->genres()->sync($request->input('genre'));
        return redirect()->route('crud-buku.index', $buku->id)->with('success', 'buku "'.$buku->title.'" sukses diubah');
    }

    public function destroy(Buku $buku)
    {
        $buku->genres()->detach();
        $buku->delete();
        return redirect()->route('crud-buku.index')->with('success', 'Buku "' . $buku->title . '" sukses dihapus".');
    }
}
