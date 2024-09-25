@extends('layout.base')

@section('title', 'Add Episode')

@section('content')
<div class="container">
    <h1>Tambah Episode</h1>
    
    <form action="{{ route('crud-episode.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="spotify_episode_id">Spotify Episode ID</label>
        <input type="text" name="spotify_episode_id" id="spotify_episode_id" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Episode</button>
    </form>

</div>
@endsection