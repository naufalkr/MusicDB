@extends('layout.base')

@section('title', 'Show Details')

@section('content')

<div class="card p-3">
    <!-- Display Show Details -->
    <div class="mb-4">
        <h2>{{ $show->nama }}</h2>
        <p><strong>Release date:</strong> {{ $show->release_date }}</p>
    </div>

    <!-- Display List of Episodes -->
    <h3>Episodes in {{ $show->nama }}</h3>

    @if($episodes->isEmpty())
        <p>No episodes available for this show.</p>
    @else
        <table id="episodeTable" class="table table-borderless mt-2">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Show</th>
                    <th>Year</th>                    
                    <th>Publisher</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                @foreach($episodes as $index => $episode)
                <tr class="episode-row" data-id="{{ $episode->id }}">
                    <td>{{ $index + 1 }}</td>
                    <td class="episode-title">
                        <img src="{{ $episode->podcast->image_url }}" alt="{{ $episode->podcast->nama }}" class="img-thumbnail" style="width: 50px; height: auto;">
                        <a href="{{ route('crud-episode.show', $episode->id) }}">
                            {{ Str::limit($episode->title, 20, '...') }}
                        </a>
                        <!-- Play icon that appears on hover -->
                        <span class="play-icon" style="display: none;">
                            <i class="fas fa-play-circle"></i>
                        </span>
                    </td>
                    <td>{{ $episode->podcast->nama }}</td>
                    <td>{{ $episode->year }}</td>
                    <td>{{ $episode->release_date }}</td>                    
                    <td>
                        @php
                            $minutes = floor($episode->duration / 60);
                            $seconds = $episode->duration % 60;
                        @endphp
                        {{ $minutes }}:{{ str_pad($seconds, 2, '0', STR_PAD_LEFT) }}
                    </td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('crud-show.tampil') }}" class="btn btn-success">Back to Show List</a>
</div>

@endsection

@push('styles')
<style>
    .table-borderless th,
    .table-borderless td {
        border: none;
    }

    .episode-row:hover .play-icon {
        display: inline-block;
        position: absolute;
        left: 20px;
        color: green;
        font-size: 20px;
    }

    .play-icon {
        display: none;
    }

    .episode-row:hover {
        background-color: #f0f0f0;
        cursor: pointer;
    }

    .episode-title {
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
