@extends('layout.base')

@section('title', 'Detail Genre')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="id">ID</label>
                        <p id="id">{{ $data['genre']->id }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <p id="title">{{ $data['genre']->nama }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="count">Number of Tracks</label>
                        <p id="title">{{ count($data['genre']->songs) }}</p>
                    </div>
                </div>
            </div>

            <a href="{{ route('crud-genre.index') }}" class="btn btn-primary">Return to Genre List</a>
            <a href="{{ route('crud-genre.edit', $data['genre']->id) }}" class="btn btn-warning">Edit Genre</a>
            <form class="border-0" action="{{ route('crud-genre.destroy', $data['genre']->id) }}" method="POST"
                style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete
                    Genre</button>
            </form>
        </div>
    </div>
@endsection
