@extends('layout.base')

@section('title', 'Add Album')

@section('content')

<form action="{{ route('crud-album.submit') }}" method = "post">
    @csrf
    <div class="form-group">
        <label for="nama">Name</label>
        <input type="text" class="form-control @error('album') is-invalid @enderror" id="nama"
            name="nama" required>
            @error('album')
        <strong>{{ $message }}</strong>
        </span>
        @enderror
        <label for="release_date">Release date</label>
        <input type="text" class="form-control @error('album') is-invalid @enderror" id="release_date"
            name="release_date" required>
            @error('album')
        <strong>{{ $message }}</strong>
        </span>
        @enderror
        <button id="submitBtn" type="submit" class="btn btn-primary">Add Album</button>
    </div>
</form>

@endsection
