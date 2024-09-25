<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Show;
use App\Services\SpotifyService;

class ShowController extends Controller
{
    protected $spotify;

    public function __construct(SpotifyService $spotify)
    {
        $this->spotify = $spotify;
    }
        // public function tampil()
    // {
    //     $show = Show::get();
    //     return view('pertemuan2.Show.tampil', compact('show'));
    // }

    public function tampil(Request $request)
    {
        $search = $request->input('search'); // Menerima input search dari request
    
        // Jika ada pencarian, filter data berdasarkan nama atau release_date
        $show = Show::when($search, function ($query, $search) {
            return $query->where('nama', 'LIKE', "%{$search}%")
                         ->orWhere('release_date', 'LIKE', "%{$search}%");
        })
        ->paginate(10); // Pagination dengan 10 data per halaman
    
        return view('pertemuan2.Show.tampil', compact('show', 'search'));
    }

    public function show($id)
    {
        // Find the show by ID
        $show = Show::findOrFail($id);
    
        // Get the episodes associated with the show
        // Ensure you have the correct relationship name
        $episodes = $show->episodes;
    
        // Return the view with the show and their episodes
        return view('pertemuan2.Show.show', compact('show', 'episodes'));
    }

    public function autocomplete(Request $request)
    {
        $term = $request->get('term');
    
        $podcasts = Show::where('nama', 'LIKE', '%' . $term . '%')
            ->get(['id', 'nama'])
            ->map(function($podcast) {
                return [
                    'value' => $podcast->id,
                    'label' => $podcast->nama
                ];
            });
    
        return response()->json($podcasts);
    }
    

    


    public function tambah()
    {
        return view('pertemuan2.Show.tambah');
    }

    public function submit(Request $request)
    {
        // Validasi input Spotify Show ID
        $request->validate([
            'spotify_show_id' => 'required|string',
        ]);

        // Ambil data show dari Spotify API berdasarkan ID
        $spotifyShow = $this->spotify->getShowById($request->spotify_show_id);

        // Simpan data show ke dalam database
        $show = new Show();
        $show->nama = $spotifyShow['name']; // Nama show
        $show->release_date = $spotifyShow['publisher']; // Tanggal rilis
        $show->image_url = $spotifyShow['images'][0]['url'] ?? null; // URL gambar show
        $show->save();

        return redirect()->route('crud-show.tampil');
    }
    
    public function edit($id)
    {
        // $data['show'] = $show;
        $show = Show::find($id);
        return view('pertemuan2.Show.edit', compact('show'));

    }

    public function update(Request $request, $id)
    {
        // $data['show'] = $show;
        $show = Show::find($id);

        $show->nama = $request->nama;
        $show->release_date = $request->release_date;
        $show->update();

        return redirect()->route('crud-show.tampil');
    }
    
    public function delete($id)
    {
        // $data['show'] = $show;
        $show = Show::find($id);

        $show->delete();

        return redirect()->route('crud-show.tampil');
    }

}
