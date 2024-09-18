@extends('layout.base')

@section('title', 'Detail Playlist')

@section('content')

<h1>{{ $playlist->nama }}</h1>
<p>Description: {{ $playlist->release_date }}</p>

<h3>Add Songs to Playlist</h3>
<form action="{{ route('crud-playlist.addSong', $playlist->id) }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="song">Select Song:</label>
        <select name="song_id" id="song" class="form-control">
            @foreach($songs as $song)
                <option value="{{ $song->id }}">{{ $song->title }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Add Song</button>
</form>

<!-- Daftar Lagu dalam Playlist -->
<h3>Songs in this Playlist:</h3>
<table class="table table-bordered mt-2">
    <thead class="table">
        <tr>
            <!-- <th>ID</th> -->
            <th>Title</th>
            <th>Artist</th>
            <th>Album</th>
            <th>Year</th>
            <th>Duration</th>
            <th>Record Label</th>
            <th>Genres</th>
            <!-- <th>Description</th> -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($playlist->songs as $song)
            <tr>
                <!-- <td>{{ $song->id }}</td> -->
                <td>
                    <a href="{{ route('crud-song.show', $song->id) }}">
                        {{ Str::limit($song->title, 20, '...') }}
                    </a>
                </td>
                <td>{{ $song->artist->nama }}</td>
                <td>{{ $song->albm->nama }}</td>
                <td>{{ $song->year }}</td>
                <td>
                    @php
                        $minutes = floor($song->duration / 60);
                        $seconds = $song->duration % 60;
                    @endphp
                    {{ $minutes }}:{{ str_pad($seconds, 2, '0', STR_PAD_LEFT) }}
                </td>
                <td>{{ $song->rl->nama }}</td>
                <td>
                    @foreach ($song->genres as $genre)
                        <span class="badge badge-primary">{{ $genre->nama }}</span>
                    @endforeach
                </td>
                <!-- <td>{{ Str::limit($song->description, 30, '...') }}</td> -->
                <td class="d-flex">
                    <form class="border-0" action="{{ route('crud-playlist.removeSong', [$playlist->id, $song->id]) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this song from the playlist?')">Remove from Playlist</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10" class="text-center">No songs found in this playlist.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
