@extends('layout.base')

@section('title', 'Edit Recordlabel')

@section('content')

    <form class="form-group" action="{{ route('crud-recordlabel.update', $recordlabel->id) }}" method="post">
        @csrf
        <label for="nama">Name</label>
        <input type="text" class="form-control @error('recordlabel') is-invalid @enderror" id="nama"
            name="nama" value="{{ $recordlabel->nama }}" required>
        @error('recordlabel')
            <strong>{{ $message }}</strong>
        @enderror

        <label for="country">Country</label>
        <input type="text" class="form-control @error('recordlabel') is-invalid @enderror" id="country"
            name="country" value="{{ $recordlabel->country }}" required>
        @error('recordlabel')
            <strong>{{ $message }}</strong>
        @enderror

        <button id="submitBtn" type="submit" class="btn btn-primary">Edit Recordlabel</button>
    </form>

@endsection
