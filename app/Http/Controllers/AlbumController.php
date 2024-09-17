<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;

class AlbumController extends Controller
{
        // public function tampil()
    // {
    //     $album = Album::get();
    //     return view('pertemuan2.Album.tampil', compact('album'));
    // }

    public function tampil(Request $request)
    {
        $search = $request->input('search'); // Menerima input search dari request
    
        // Jika ada pencarian, filter data berdasarkan nama atau release_date
        $album = Album::when($search, function ($query, $search) {
            return $query->where('nama', 'LIKE', "%{$search}%")
                         ->orWhere('release_date', 'LIKE', "%{$search}%");
        })
        ->paginate(10); // Pagination dengan 10 data per halaman
    
        return view('pertemuan2.Album.tampil', compact('album', 'search'));
    }

    public function show($id)
    {
        // Find the album by ID
        $album = Album::findOrFail($id);
    
        // Get the songs associated with the album
        // Ensure you have the correct relationship name
        $songs = $album->songs;
    
        // Return the view with the album and their songs
        return view('pertemuan2.Album.show', compact('album', 'songs'));
    }

    public function autocomplete(Request $request)
    {
        $term = $request->get('term');
    
        $albms = Album::where('nama', 'LIKE', '%' . $term . '%')
            ->get(['id', 'nama'])
            ->map(function($albm) {
                return [
                    'value' => $albm->id,
                    'label' => $albm->nama
                ];
            });
    
        return response()->json($albms);
    }
    

    


    public function tambah()
    {
        // $data['album'] = $album;
        return view('pertemuan2.Album.tambah');
    }

    public function submit(Request $request)
    {
        // $data['album'] = $album;
        $album = new Album();

        $album->nama = $request->nama;
        $album->release_date = $request->release_date;
        $album->save();

        return redirect()->route('crud-album.tampil');
    }

    public function edit($id)
    {
        // $data['album'] = $album;
        $album = Album::find($id);
        return view('pertemuan2.Album.edit', compact('album'));

    }

    public function update(Request $request, $id)
    {
        // $data['album'] = $album;
        $album = Album::find($id);

        $album->nama = $request->nama;
        $album->release_date = $request->release_date;
        $album->update();

        return redirect()->route('crud-album.tampil');
    }
    
    public function delete($id)
    {
        // $data['album'] = $album;
        $album = Album::find($id);

        $album->delete();

        return redirect()->route('crud-album.tampil');
    }

}
