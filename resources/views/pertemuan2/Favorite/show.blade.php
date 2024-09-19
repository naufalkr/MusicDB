@extends('layout.base')

@section('title', 'Favorite Detail')

@section('content')

<div class="card p-3">
    <h1>{{ $favorite->nama }}</h1>
    <p>Description: {{ $favorite->release_date }}</p>

    <form action="{{ route('crud-favorite.addSong', $favorite->id) }}" method="POST">
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

    <!-- Daftar Lagu dalam Favorite -->
    <h3 class="mt-4">Songs in this Favorite:</h3>
    <table class="table table-borderless mt-2">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Artist</th>
                <th>Album</th>
                <th>Year</th>
                <th>Duration</th>
                <th>Record Label</th>
                <th>Genres</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($favorite->songs as $index => $song)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="song-title">
                        <img src="{{ $song->albm->image_url }}" alt="{{ $song->albm->nama }}" class="img-thumbnail" style="width: 1.2cm; height: 1.2cm;">
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
                    <td class="d-flex">
                        <form class="border-0" action="{{ route('crud-favorite.removeSong', [$favorite->id, $song->id]) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this song from the favorite?')">Remove from Favorite</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No songs found in this favorite.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

@push('styles')
<style>
    .table-borderless th,
    .table-borderless td {
        border: none;
    }

    .song-title {
        display: flex;
        align-items: center;
    }

    .song-title img {
        margin-right: 10px; /* Spacing between image and title */
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize any scripts if necessary
    });
</script>
@endpush
