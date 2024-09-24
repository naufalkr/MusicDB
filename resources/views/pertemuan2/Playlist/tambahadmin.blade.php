@extends('layout.base')

@section('title', 'Add Playlist')

@section('content')
<div class="container">
    <h1>Tambah Playlist</h1>
    
    <form action="{{ route('crud-playlist.submitadmin') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="spotify_playlist_id">Spotify Playlist ID</label>
            <input type="text" name="spotify_playlist_id" class="form-control" placeholder="Masukkan Spotify Playlist ID">
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection