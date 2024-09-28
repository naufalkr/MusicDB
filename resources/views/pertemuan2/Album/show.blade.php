@extends('layout.base')

@section('title', 'Album Details')

@section('content')

<div class="card p-3">
    <!-- Display Album Details -->
    <div class="mb-4">
        <img src="{{ $album->image_url }}" alt="{{ $album->image_url }}" class="img-thumbnail" style=" height: auto;">
        <h2>{{ $album->nama }}</h2>
        <p><strong>Release date:</strong> {{ $album->release_date }}</p>
    </div>

    <!-- Display List of Songs -->
    <h3>Songs in {{ $album->nama }}</h3>

    @if($songs->isEmpty())
        <p>No songs available for this album.</p>
    @else
        <table id="songTable" class="table table-borderless mt-2">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Artist</th>
                    <th>Record Label</th>
                    <th>Year</th>
                    <th>Duration</th>
                    <th>Genre</th>
                </tr>
            </thead>
            <tbody>
                @foreach($songs as $index => $song)
                <tr class="song-row" data-id="{{ $song->id }}">
                    <td>{{ $index + 1 }}</td>
                    <td class="song-title">
                        <a href="{{ route('crud-song.show', $song->id) }}">
                            {{ Str::limit($song->title, 20, '...') }}
                        </a>
                        <!-- Play icon that appears on hover -->
                        <span class="play-icon" style="display: none;">
                            <i class="fas fa-play-circle"></i>
                        </span>
                    </td>
                    <td>{{ $song->artist->nama }}</td>
                    <td>{{ $song->rl->nama }}</td>
                    <td>{{ $song->year }}</td>
                    <td>
                        @php
                            $minutes = floor($song->duration / 60);
                            $seconds = $song->duration % 60;
                        @endphp
                        {{ $minutes }}:{{ str_pad($seconds, 2, '0', STR_PAD_LEFT) }}
                    </td>
                    <td>
                        <span class="badge badge-primary">{{ $song->category }}</span>                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('crud-album.tampil') }}" class="btn btn-success">Back to Album List</a>
</div>

@endsection

@push('styles')
<style>
    .table-borderless th,
    .table-borderless td {
        border: none;
    }

    .song-row:hover .play-icon {
        display: inline-block;
        position: absolute;
        left: 20px;
        color: green;
        font-size: 20px;
    }

    .play-icon {
        display: none;
    }

    .song-row:hover {
        background-color: #f0f0f0;
        cursor: pointer;
    }

    .song-title {
        position: relative;
    }
    .img-thumbnail {
        width: 4cm;
        height: 4cm;
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
