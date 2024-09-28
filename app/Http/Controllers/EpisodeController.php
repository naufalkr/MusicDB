<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewEpisodeRequest;
use App\Http\Requests\UpdateEpisodeRequest;
use App\Models\Episode;
use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Services\SpotifyService;

class EpisodeController extends Controller
{
    protected $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    public function index(Request $request)
    {
        // Searching episodes based on the 'nama' field only
        $query = Episode::query();

        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->input('nama') . '%');
        }

        $data['episode'] = $query->paginate(10); // Assuming pagination with 10 items per page

        return view('pertemuan2.episode.index', compact('data'));
    }

    public function create()
    {
        // Fetch necessary data for episode creation
        $data['show'] = Show::all(); // If you need to display available shows
        return view('pertemuan2.episode.create', compact('data'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'spotify_episode_id' => 'required|string',
        ]);

        // Fetch episode data from Spotify
        $spotifyEpisode = $this->spotifyService->getEpisodeById($request->spotify_episode_id);

        // Extract necessary IDs
        $spotify_show_id = $spotifyEpisode['show']['id'];

        // Fetch additional data for the show
        $spotifyShow = $this->spotifyService->getShowById($spotify_show_id);

        // Check if the show already exists by name
        $show = Show::firstOrCreate(
            ['nama' => $spotifyShow['name']], // Check by show name
            [
                // 'id' => $spotify_show_id, // Set the ID
                'release_date' => $spotifyShow['publisher'],
                'image_url' => $spotifyShow['images'][0]['url'] ?? null
                
            ]
        );

        // Create the episode
        $episode = Episode::create([
            'title' => $spotifyEpisode['name'],
            'podcast_id' => $show->id,
            // 'year' => $spotifyEpisode['show']['release_date'] ? date('Y', strtotime($spotifyEpisode['show']['release_date'])) : null,
            'year' => (int) ($spotifyEpisode['release_date']),                        
            'release_date' => ($spotifyShow['publisher']),            
            'duration' => (int) ($spotifyEpisode['duration_ms'] / 1000),
            'description' => $spotifyEpisode['description'] ?? null,
        ]);

        return redirect()->route('crud-episode.index')->with('success', 'Episode added successfully.');
    }

    public function show(Episode $episode)
    {
        $data['episode'] = $episode;
        return view('pertemuan2.episode.show', compact('data'));
    }

    public function edit(Episode $episode)
    {
        $data['episode'] = $episode;
        $data['show'] = Show::all(); // Fetch shows for selection during edit
        return view('pertemuan2.episode.edit', compact('data'));
    }

    public function update(UpdateEpisodeRequest $request, Episode $episode)
    {
        // Update episode details
        $episode->update($request->validated());

        return redirect()->route('crud-episode.index', $episode->id)
            ->with('success', 'Episode "' . $episode->title . '" successfully updated.');
    }

    public function destroy(Episode $episode)
    {
        // Delete the episode
        $episode->delete();
        return redirect()->route('crud-episode.index')
            ->with('success', 'Episode "' . $episode->title . '" successfully deleted.');
    }
}
