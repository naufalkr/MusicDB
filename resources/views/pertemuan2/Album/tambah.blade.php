@extends('layout.base')

@section('title', 'Add Album')

@section('content')
<div class="container">
    <h1>Tambah Album</h1>
    
    <form action="{{ route('crud-album.submit') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="spotify_album_id">Spotify Album ID</label>
            <input type="text" name="spotify_album_id" class="form-control" placeholder="Masukkan Spotify Album ID">
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection