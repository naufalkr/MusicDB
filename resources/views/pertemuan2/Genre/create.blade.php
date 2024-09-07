@extends('layout.base')

@section('title', 'Add Genre')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('crud-genre.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Genre Name</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                        value="{{ old('nama') }}" required>
                    @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Add Genre</button>
                <a href="{{ route('crud-genre.index') }}" class="btn btn-warning">Return</a><a href="#"></a>
            </form>
        </div>
    </div>
@endsection
