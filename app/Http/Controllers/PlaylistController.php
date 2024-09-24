<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\Song;
use App\Services\SpotifyService;

class PlaylistController extends Controller
{
        // public function tampil()
    // {
    //     $playlist = Playlist::get();
    //     return view('pertemuan2.Playlist.tampil', compact('playlist'));
    // }

    protected $spotify;

    public function __construct(SpotifyService $spotify)
    {
        $this->spotify = $spotify;
    }
    
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

    public function show($id)
    {
        $playlist = Playlist::with('songs')->findOrFail($id);
        $songs = Song::all(); // Ambil semua lagu untuk ditambahkan ke playlist
        return view('pertemuan2.Playlist.show', compact('playlist', 'songs'));
    }

    public function removeSong($playlistId, $songId)
    {
        $playlist = Playlist::findOrFail($playlistId);
        $playlist->songs()->detach($songId);

        return redirect()->route('crud-playlist.show', $playlistId)
                        ->with('success', 'Song removed from playlist successfully.');
    }

    
    

    // public function addSong(Request $request, $id)
    // {
    //     $playlist = Playlist::findOrFail($id);
    //     $songId = $request->input('song_id');

    //     // Cek apakah lagu sudah ada di playlist
    //     if (!$playlist->songs->contains($songId)) {
    //         $playlist->songs()->attach($songId);
    //     }

    //     return redirect()->route('pertemuan2.Playlist.show', $id)->with('success', 'Song added to playlist successfully.');
    // }
    public function addSong(Request $request, $playlistId)
    {
        $playlist = Playlist::findOrFail($playlistId);
        $playlist->songs()->attach($request->song_id);
        return redirect()->route('crud-playlist.show', $playlistId)->with('success', 'Song added to playlist!');
    }



    public function tambah()
    {
        // $data['playlist'] = $playlist;
        return view('pertemuan2.Playlist.tambah');
    }

    
    public function tambahadmin()
    {
        // $data['playlist'] = $playlist;
        return view('pertemuan2.Playlist.tambahadmin');
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

    public function submitadmin(Request $request)
    {
        // Validasi input Spotify Playlist ID
        $request->validate([
            'spotify_playlist_id' => 'required|string',
        ]);

        // Ambil data playlist dari Spotify API berdasarkan ID
        $spotifyPlaylist = $this->spotify->getPlaylistById($request->spotify_playlist_id);

        // Simpan data playlist ke dalam database
        $playlist = new Playlist();
        $playlist->nama = $spotifyPlaylist['name']; // Nama playlist
        $playlist->release_date = $spotifyPlaylist['description']; // Tanggal rilis
        // $playlist->image_url = $spotifyPlaylist['images'][0]['url'] ?? null; // URL gambar playlist
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
