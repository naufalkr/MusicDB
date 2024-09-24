@extends('layout.base')

@section('title', 'Add Recordlabel')

@section('content')
<div class="container">
    <h1>Tambah Recordlabel</h1>
    
    <form action="{{ route('crud-recordlabel.submit') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="spotify_recordlabel_id">Spotify Recordlabel ID</label>
            <input type="text" name="spotify_recordlabel_id" class="form-control" placeholder="Masukkan Spotify Recordlabel ID">
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection