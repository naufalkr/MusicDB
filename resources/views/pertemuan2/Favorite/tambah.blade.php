@extends('layout.base')

@section('title', 'Add Favorite')

@section('content')

<form action="{{ route('crud-favorite.submit') }}" method = "post">
    @csrf
    <div class="form-group">
        <label for="nama">Name</label>
        <input type="text" class="form-control @error('favorite') is-invalid @enderror" id="nama"
            name="nama" required>
            @error('favorite')
        <strong>{{ $message }}</strong>
        </span>
        @enderror
        <label for="release_date">Description</label>
        <input type="text" class="form-control @error('favorite') is-invalid @enderror" id="release_date"
            name="release_date" required>
            @error('favorite')
        <strong>{{ $message }}</strong>
        </span>
        @enderror
        <button id="submitBtn" type="submit" class="btn btn-primary">Add Favorite</button>
    </div>
</form>

@endsection
