@extends('layout.base')

@section('title', 'Add Artist')

@section('content')
<div class="container">
    <h1>Tambah Artist</h1>
    
    <form action="{{ route('crud-singer.submit') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="spotify_artist_id">Spotify Artist ID</label>
            <input type="text" name="spotify_artist_id" class="form-control" placeholder="Masukkan Spotify Artist ID">
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection

