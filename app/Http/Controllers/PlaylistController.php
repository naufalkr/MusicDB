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


    // public function submit(Request $request)
    // {
    //     // $data['playlist'] = $playlist;
    //     $playlist = new Playlist();

    //     $playlist->nama = $request->nama;
    //     $playlist->release_date = $request->release_date;
    //     $playlist->save();

    //     return redirect()->route('crud-playlist.tampil');
    // }

    public function submit(Request $request)
    {
        // Validate the form input, including the image field
        $request->validate([
            'nama' => 'required|string|max:255',
            'release_date' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure image is valid
        ]);
        
        // Create a new Playlist
        $playlist = new Playlist();
        $playlist->nama = $request->nama;
        $playlist->release_date = $request->release_date;

        // If an image is uploaded, store it in storage and save the file path
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/playlist_images'); // Save image to storage
            $playlist->image_path = $imagePath; // Save the image path to the database
        }

        // Save the playlist
        $playlist->save();

        return redirect()->route('crud-playlist.tampil')->with('success', 'Playlist added successfully!');
    }
  
    public function submitadmin(Request $request)
    {
        // Validate the Spotify Playlist ID
        $request->validate([
            'spotify_playlist_id' => 'required|string',
        ]);
    
        // Get the playlist data from the Spotify API based on the ID
        $spotifyPlaylist = $this->spotify->getPlaylistById($request->spotify_playlist_id);
    
        // Create a new Playlist instance
        $playlist = new Playlist();
        $playlist->nama = $spotifyPlaylist['name']; // Playlist name
        $playlist->release_date = $spotifyPlaylist['description']; // Release date
    
        // Check if an image URL exists
        if (isset($spotifyPlaylist['images'][0]['url'])) {
            $imageUrl = $spotifyPlaylist['images'][0]['url'];
    
            // Download the image and store it in the public storage
            $imageContents = file_get_contents($imageUrl); // Get image content
    
            // Generate a unique name for the image
            $imageName = uniqid() . '.jpg'; // You can also use other extensions based on the image type
    
            // Store the image in storage
            \Storage::put('public/playlist_images/' . $imageName, $imageContents);
    
            // Save the path to the database
            $playlist->image_path = 'public/playlist_images/' . $imageName;
        }
    
        // Save the playlist to the database
        $playlist->save();

        return redirect()->route('crud-playlist.tampil')->with('success', 'Playlist added successfully!');
    }

    public function edit($id)
    {
        // $data['playlist'] = $playlist;
        $playlist = Playlist::find($id);
        return view('pertemuan2.Playlist.edit', compact('playlist'));

    }

    // public function update(Request $request, $id)
    // {
    //     // $data['playlist'] = $playlist;
    //     $playlist = Playlist::find($id);

    //     $playlist->nama = $request->nama;
    //     $playlist->release_date = $request->release_date;
    //     $playlist->update();

    //     return redirect()->route('crud-playlist.tampil');
    // }
    
    public function update(Request $request, $id)
{
    // Validate the input fields, including the image
    $request->validate([
        'nama' => 'required|string|max:255',
        'release_date' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure image is valid
    ]);

    // Find the playlist by its ID
    $playlist = Playlist::findOrFail($id);

    // Update playlist fields
    $playlist->nama = $request->nama;
    $playlist->release_date = $request->release_date;

    // Check if a new image is uploaded
    if ($request->hasFile('image')) {
        // If the playlist already has an image, delete the old one
        if ($playlist->image_path) {
            \Storage::delete($playlist->image_path);
        }

        // Store the new image
        $imagePath = $request->file('image')->store('public/playlist_images');
        $playlist->image_path = $imagePath; // Save the new image path to the database
    }

    // Save the updated playlist
    $playlist->save();

    return redirect()->route('crud-playlist.tampil')->with('success', 'Playlist updated successfully!');
}


    public function delete($id)
    {
        // $data['playlist'] = $playlist;
        $playlist = Playlist::find($id);

        $playlist->delete();

        return redirect()->route('crud-playlist.tampil');
    }

}
