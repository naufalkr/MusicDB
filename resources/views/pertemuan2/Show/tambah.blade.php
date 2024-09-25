@extends('layout.base')

@section('title', 'Add Show')

@section('content')
<div class="container">
    <h1>Tambah Show</h1>
    
    <form action="{{ route('crud-show.submit') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="spotify_show_id">Spotify Show ID</label>
            <input type="text" name="spotify_show_id" class="form-control" placeholder="Masukkan Spotify Show ID">
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection