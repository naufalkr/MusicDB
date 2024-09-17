@extends('layout.base')

@section('title', 'Album Details')

@section('content')

<div class="card p-3">
    <!-- Display Album Details -->
    <div class="mb-4">
        <h2>{{ $album->nama }}</h2>
        <p><strong>Release date:</strong> {{ $album->release_date }}</p>
    </div>

    <!-- Display List of Songs -->
    <h3>Songs by {{ $album->nama }}</h3>

    @if($songs->isEmpty())
        <p>No songs available for this album.</p>
    @else
        <table id="songTable" class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Album</th>
                    <th>Year</th>
                    <th>Duration</th>
                    <th>Genre</th>
                </tr>
            </thead>
            <tbody>
                @foreach($songs as $index => $song)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $song->title }}</td>
                    <td>{{ $song->albm->nama }}</td>
                    <td>{{ $song->year }}</td>
                    <td>
                        @php
                            $minutes = floor($song->duration / 60);
                            $seconds = $song->duration % 60;
                        @endphp
                        {{ $minutes }}:{{ str_pad($seconds, 2, '0', STR_PAD_LEFT) }}
                    </td>
                    <td>
                        @foreach ($song->genres as $genre)
                            <span class="badge badge-primary">{{ $genre->nama }}</span>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('crud-album.tampil') }}" class="btn btn-success">Back to Album List</a>
</div>

@endsection
