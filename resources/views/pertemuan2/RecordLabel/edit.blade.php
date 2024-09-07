@extends('layout.base')

@section('title', 'Edit Artist')

@section('content')

    <form class="form-group" action="{{ route('crud-singer.update', $singer->id) }}" method="post">
        @csrf
        <label for="nama">Name</label>
        <input type="text" class="form-control @error('artist') is-invalid @enderror" id="nama"
            name="nama" value="{{ $singer->nama }}" required>
        @error('artist')
            <strong>{{ $message }}</strong>
        @enderror

        <label for="bio">Bio</label>
        <input type="text" class="form-control @error('artist') is-invalid @enderror" id="bio"
            name="bio" value="{{ $singer->bio }}" required>
        @error('artist')
            <strong>{{ $message }}</strong>
        @enderror

        <button id="submitBtn" type="submit" class="btn btn-primary">Edit Singer</button>
    </form>

@endsection
