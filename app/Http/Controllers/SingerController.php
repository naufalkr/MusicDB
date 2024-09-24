<?php

namespace App\Http\Controllers;

// use App\Http\Requests\SingerRequest;
use App\Models\Singer;
use Illuminate\Http\Request;
use App\Services\SpotifyService;


class SingerController extends Controller
{
    protected $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    // public function tampil()
    // {
    //     $singer = Singer::get();
    //     return view('pertemuan2.Singer.tampil', compact('singer'));
    // }

    public function tampil(Request $request)
    {
        $search = $request->input('search'); // Menerima input search dari request
    
        // Jika ada pencarian, filter data berdasarkan nama atau bio
        $singer = Singer::when($search, function ($query, $search) {
            return $query->where('nama', 'LIKE', "%{$search}%")
                         ->orWhere('bio', 'LIKE', "%{$search}%");
        })
        ->paginate(10); // Pagination dengan 10 data per halaman
    
        return view('pertemuan2.Singer.tampil', compact('singer', 'search'));
    }

    public function show($id)
    {
        // Find the singer by ID
        $singer = Singer::findOrFail($id);
    
        // Get the songs associated with the singer
        // Ensure you have the correct relationship name
        $songs = $singer->songs;
    
        // Return the view with the singer and their songs
        return view('pertemuan2.Singer.show', compact('singer', 'songs'));
    }
    
    public function autocomplete(Request $request)
    {
        $term = $request->get('term');
    
        $artists = Singer::where('nama', 'LIKE', '%' . $term . '%')
            ->get(['id', 'nama'])
            ->map(function($artist) {
                return [
                    'value' => $artist->id,
                    'label' => $artist->nama
                ];
            });
    
        return response()->json($artists);
    }
    
    public function search(Request $request)
    {
        $searchTerm = $request->input('q');
        $artists = Artist::where('name', 'like', "%$searchTerm%")->get();

        return response()->json($artists);
    }

    


    public function tambah()
    {
        // Menampilkan form tambah singer dengan input Spotify ID
        return view('pertemuan2.Singer.tambah');
    }

    public function submit(Request $request)
    {
        $spotifyId = $request->spotify_artist_id;

        // Ambil data singer dari Spotify
        $spotifyArtist = $this->spotifyService->getArtistById($spotifyId);

        // Buat instance singer baru
        $singer = new Singer();
        $singer->nama = $spotifyArtist['name'];
        $singer->bio = $spotifyArtist['genres'] ? implode(', ', $spotifyArtist['genres']) : 'No genre info'; // Mengambil genre sebagai bio
        $singer->save();

        return redirect()->route('crud-singer.tampil')->with('success', 'Singer berhasil ditambahkan!');
    }


    public function edit($id)
    {
        // $data['singer'] = $singer;
        $singer = Singer::find($id);
        return view('pertemuan2.Singer.edit', compact('singer'));

    }

    public function update(Request $request, $id)
    {
        // $data['singer'] = $singer;
        $singer = Singer::find($id);

        $singer->nama = $request->nama;
        $singer->bio = $request->bio;
        $singer->update();

        return redirect()->route('crud-singer.tampil');
    }
    
    public function delete($id)
    {
        // $data['singer'] = $singer;
        $singer = Singer::find($id);

        $singer->delete();

        return redirect()->route('crud-singer.tampil');
    }

}