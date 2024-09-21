@extends('layout.base')

@section('title', 'Edit Playlist')

@section('content')

    <form class="form-group" action="{{ route('crud-playlist.update', $playlist->id) }}" method="post">
        @csrf
        <label for="nama">Name</label>
        <input type="text" class="form-control @error('playlist') is-invalid @enderror" id="nama"
            name="nama" value="{{ $playlist->nama }}" required>
        @error('playlist')
            <strong>{{ $message }}</strong>
        @enderror

        <label for="release_date">Description</label>
        <input type="text" class="form-control @error('playlist') is-invalid @enderror" id="release_date"
            name="release_date" value="{{ $playlist->release_date }}" required>
        @error('playlist')
            <strong>{{ $message }}</strong>
        @enderror

        <button id="submitBtn" type="submit" class="btn btn-primary">Edit Playlist</button>
    </form>

@endsection
