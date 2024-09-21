@extends('layout.base')

@section('title', 'Edit Album')

@section('content')

    <form class="form-group" action="{{ route('crud-album.update', $album->id) }}" method="post">
        @csrf
        <label for="nama">Name</label>
        <input type="text" class="form-control @error('album') is-invalid @enderror" id="nama"
            name="nama" value="{{ $album->nama }}" required>
        @error('album')
            <strong>{{ $message }}</strong>
        @enderror

        <label for="release_date">Release date</label>
        <input type="text" class="form-control @error('album') is-invalid @enderror" id="release_date"
            name="release_date" value="{{ $album->release_date }}" required>
        @error('album')
            <strong>{{ $message }}</strong>
        @enderror

        <button id="submitBtn" type="submit" class="btn btn-primary">Edit Album</button>
    </form>

@endsection
