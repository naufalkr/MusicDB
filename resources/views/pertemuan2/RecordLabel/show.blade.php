@extends('layout.base')

@section('title', 'Recordlabel Details')

@section('content')

<div class="card p-3">
    <!-- Display Recordlabel Details -->
    <div class="mb-4">
        <h2>{{ $recordlabel->nama }}</h2>
        <p><strong>Country:</strong> {{ $recordlabel->country }}</p>
    </div>

    <!-- Display List of Songs -->
    <h3>Songs by {{ $recordlabel->nama }}</h3>

    @if($songs->isEmpty())
        <p>No songs available for this recordlabel.</p>
    @else
        <table id="songTable" class="table table-borderless mt-2">
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
                <tr class="song-row" data-id="{{ $song->id }}">
                    <td>{{ $index + 1 }}</td>
                    <td class="song-title">
                        <img src="{{ $song->albm->image_url }}" alt="{{ $song->albm->nama }}" class="img-thumbnail" style="width: 50px; height: auto;">
                        <a href="{{ route('crud-song.show', $song->id) }}">
                            {{ Str::limit($song->title, 20, '...') }}
                        </a>
                        <!-- Play icon that appears on hover -->
                        <span class="play-icon" style="display: none;">
                            <i class="fas fa-play-circle"></i>
                        </span>
                    </td>
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

    <a href="{{ route('crud-recordlabel.tampil') }}" class="btn btn-success">Back to Recordlabel List</a>
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
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize any scripts if necessary
    });
</script>
@endpush
