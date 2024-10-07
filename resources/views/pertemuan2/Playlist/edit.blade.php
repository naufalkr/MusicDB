@extends('layout.base')

@section('title', 'Edit Playlist')

@section('content')

    <form class="form-group" action="{{ route('crud-playlist.update', $playlist->id) }}" method="post" enctype="multipart/form-data">
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

        <label for="image">Playlist Image</label>
        @if ($playlist->image_path)
            <div>
                <img src="{{ Storage::url($playlist->image_path) }}" alt="Playlist Image" style="max-width: 200px;">
            </div>
        @endif
        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
        @error('image')
            <strong>{{ $message }}</strong>
        @enderror

        <button id="submitBtn" type="submit" class="btn btn-primary">Edit Playlist</button>
    </form>

@endsection
