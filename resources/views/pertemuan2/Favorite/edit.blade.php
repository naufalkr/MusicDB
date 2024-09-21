@extends('layout.base')

@section('title', 'Edit Favorite')

@section('content')

    <form class="form-group" action="{{ route('crud-favorite.update', $favorite->id) }}" method="post">
        @csrf
        <label for="nama">Name</label>
        <input type="text" class="form-control @error('favorite') is-invalid @enderror" id="nama"
            name="nama" value="{{ $favorite->nama }}" required>
        @error('favorite')
            <strong>{{ $message }}</strong>
        @enderror

        <label for="release_date">Description</label>
        <input type="text" class="form-control @error('favorite') is-invalid @enderror" id="release_date"
            name="release_date" value="{{ $favorite->release_date }}" required>
        @error('favorite')
            <strong>{{ $message }}</strong>
        @enderror

        <button id="submitBtn" type="submit" class="btn btn-primary">Edit Favorite</button>
    </form>

@endsection
