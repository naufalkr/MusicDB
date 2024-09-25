@extends('layout.base')

@section('title', 'Edit Show')

@section('content')

    <form class="form-group" action="{{ route('crud-show.update', $show->id) }}" method="post">
        @csrf
        <label for="nama">Name</label>
        <input type="text" class="form-control @error('show') is-invalid @enderror" id="nama"
            name="nama" value="{{ $show->nama }}" required>
        @error('show')
            <strong>{{ $message }}</strong>
        @enderror

        <label for="release_date">Release date</label>
        <input type="text" class="form-control @error('show') is-invalid @enderror" id="release_date"
            name="release_date" value="{{ $show->release_date }}" required>
        @error('show')
            <strong>{{ $message }}</strong>
        @enderror

        <button id="submitBtn" type="submit" class="btn btn-primary">Edit Show</button>
    </form>

@endsection
