<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Song;

class FavoriteController extends Controller
{
        // public function tampil()
    // {
    //     $favorite = Favorite::get();
    //     return view('pertemuan2.Favorite.tampil', compact('favorite'));
    // }

    public function tampil(Request $request)
    {
        $search = $request->input('search'); // Menerima input search dari request
    
        // Jika ada pencarian, filter data berdasarkan nama atau release_date
        $favorite = Favorite::when($search, function ($query, $search) {
            return $query->where('nama', 'LIKE', "%{$search}%")
                         ->orWhere('release_date', 'LIKE', "%{$search}%");
        })
        ->paginate(10); // Pagination dengan 10 data per halaman
    
        return view('pertemuan2.Favorite.tampil', compact('favorite', 'search'));
    }

    public function show($id)
    {
        $favorite = Favorite::with('songs')->findOrFail($id);
        $songs = Song::all(); // Ambil semua lagu untuk ditambahkan ke favorite
        return view('pertemuan2.Favorite.show', compact('favorite', 'songs'));
    }

    public function removeSong($favoriteId, $songId)
    {
        $favorite = Favorite::findOrFail($favoriteId);
        $favorite->songs()->detach($songId);

        return redirect()->route('crud-favorite.show', $favoriteId)
                        ->with('success', 'Song removed from favorite successfully.');
    }

    
    

    // public function addSong(Request $request, $id)
    // {
    //     $favorite = Favorite::findOrFail($id);
    //     $songId = $request->input('song_id');

    //     // Cek apakah lagu sudah ada di favorite
    //     if (!$favorite->songs->contains($songId)) {
    //         $favorite->songs()->attach($songId);
    //     }

    //     return redirect()->route('pertemuan2.Favorite.show', $id)->with('success', 'Song added to favorite successfully.');
    // }
    public function addSong(Request $request, $favoriteId)
    {
        $favorite = Favorite::findOrFail($favoriteId);
        $favorite->songs()->attach($request->song_id);
        return redirect()->route('crud-favorite.show', $favoriteId)->with('success', 'Song added to favorite!');
    }



    public function tambah()
    {
        // $data['favorite'] = $favorite;
        return view('pertemuan2.Favorite.tambah');
    }

    public function submit(Request $request)
    {
        // $data['favorite'] = $favorite;
        $favorite = new Favorite();

        $favorite->nama = $request->nama;
        $favorite->release_date = $request->release_date;
        $favorite->save();

        return redirect()->route('crud-favorite.tampil');
    }

    public function edit($id)
    {
        // $data['favorite'] = $favorite;
        $favorite = Favorite::find($id);
        return view('pertemuan2.Favorite.edit', compact('favorite'));

    }

    public function update(Request $request, $id)
    {
        // $data['favorite'] = $favorite;
        $favorite = Favorite::find($id);

        $favorite->nama = $request->nama;
        $favorite->release_date = $request->release_date;
        $favorite->update();

        return redirect()->route('crud-favorite.tampil');
    }
    
    public function delete($id)
    {
        // $data['favorite'] = $favorite;
        $favorite = Favorite::find($id);

        $favorite->delete();

        return redirect()->route('crud-favorite.tampil');
    }

}
