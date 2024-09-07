@extends('layout.base')

@section('title', 'Add Artist')

@section('content')

<form action="{{ route('crud-singer.submit') }}" method = "post">
    @csrf
    <div class="form-group">
        <label for="nama">Name</label>
        <input type="text" class="form-control @error('artist') is-invalid @enderror" id="nama"
            name="nama" required>
            @error('artist')
        <strong>{{ $message }}</strong>
        </span>
        @enderror
        <label for="bio">Bio</label>
        <input type="text" class="form-control @error('artist') is-invalid @enderror" id="bio"
            name="bio" required>
            @error('artist')
        <strong>{{ $message }}</strong>
        </span>
        @enderror
        <button id="submitBtn" type="submit" class="btn btn-primary">Tambah Singer</button>
    </div>
</form>

@endsection
