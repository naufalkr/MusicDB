@extends('layout.base')

@section('title', 'Add Playlist')

@section('content')

<form action="{{ route('crud-playlist.submit') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="nama">Name</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" required>
        @error('nama')
        <strong>{{ $message }}</strong>
        @enderror

        <label for="release_date">Description</label>
        <input type="text" class="form-control @error('release_date') is-invalid @enderror" id="release_date" name="release_date" required>
        @error('release_date')
        <strong>{{ $message }}</strong>
        @enderror

        <!-- Image Upload Field -->
        <label for="image">Playlist Image</label>
        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
        @error('image')
        <strong>{{ $message }}</strong>
        @enderror

        <button id="submitBtn" type="submit" class="btn btn-primary mt-3">Add Playlist</button>
    </div>
</form>

@endsection
