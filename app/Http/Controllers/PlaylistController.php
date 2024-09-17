<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;

class PlaylistController extends Controller
{
        // public function tampil()
    // {
    //     $playlist = Playlist::get();
    //     return view('pertemuan2.Playlist.tampil', compact('playlist'));
    // }

    public function tampil(Request $request)
    {
        $search = $request->input('search'); // Menerima input search dari request
    
        // Jika ada pencarian, filter data berdasarkan nama atau release_date
        $playlist = Playlist::when($search, function ($query, $search) {
            return $query->where('nama', 'LIKE', "%{$search}%")
                         ->orWhere('release_date', 'LIKE', "%{$search}%");
        })
        ->paginate(10); // Pagination dengan 10 data per halaman
    
        return view('pertemuan2.Playlist.tampil', compact('playlist', 'search'));
    }
    


    public function tambah()
    {
        // $data['playlist'] = $playlist;
        return view('pertemuan2.Playlist.tambah');
    }

    public function submit(Request $request)
    {
        // $data['playlist'] = $playlist;
        $playlist = new Playlist();

        $playlist->nama = $request->nama;
        $playlist->release_date = $request->release_date;
        $playlist->save();

        return redirect()->route('crud-playlist.tampil');
    }

    public function edit($id)
    {
        // $data['playlist'] = $playlist;
        $playlist = Playlist::find($id);
        return view('pertemuan2.Playlist.edit', compact('playlist'));

    }

    public function update(Request $request, $id)
    {
        // $data['playlist'] = $playlist;
        $playlist = Playlist::find($id);

        $playlist->nama = $request->nama;
        $playlist->release_date = $request->release_date;
        $playlist->update();

        return redirect()->route('crud-playlist.tampil');
    }
    
    public function delete($id)
    {
        // $data['playlist'] = $playlist;
        $playlist = Playlist::find($id);

        $playlist->delete();

        return redirect()->route('crud-playlist.tampil');
    }

}
