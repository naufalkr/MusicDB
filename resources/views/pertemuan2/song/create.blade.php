@extends('layout.base')

@section('title', 'Add Track')

@section('content')
<div class="container">
    <h1>Tambah Track</h1>
    
    <form action="{{ route('crud-song.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="spotify_track_id">Spotify Track ID</label>
        <input type="text" name="spotify_track_id" id="spotify_track_id" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Song</button>
    </form>

</div>
@endsection