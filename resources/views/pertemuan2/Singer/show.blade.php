@extends('layout.base')

@section('title', 'Singer Details')

@section('content')

<div class="card p-3">
    <!-- Display Singer Details -->
    <div class="mb-4">
        <h2>{{ $singer->nama }}</h2>
        <p><strong>Bio:</strong> {{ $singer->bio }}</p>
    </div>

    <!-- Display List of Songs -->
    <h3>Songs by {{ $singer->nama }}</h3>

    @if($songs->isEmpty())
        <p>No songs available for this artist.</p>
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
                    <td>{{ $song->album }}</td>
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

    <a href="{{ route('crud-singer.tampil') }}" class="btn btn-success">Back to Artist List</a>
</div>

@endsection
