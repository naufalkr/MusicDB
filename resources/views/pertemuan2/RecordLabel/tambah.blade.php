@extends('layout.base')

@section('title', 'Add Recordlabel')

@section('content')

<form action="{{ route('crud-recordlabel.submit') }}" method = "post">
    @csrf
    <div class="form-group">
        <label for="nama">Name</label>
        <input type="text" class="form-control @error('recordlabel') is-invalid @enderror" id="nama"
            name="nama" required>
            @error('recordlabel')
        <strong>{{ $message }}</strong>
        </span>
        @enderror
        <label for="country">Country</label>
        <input type="text" class="form-control @error('recordlabel') is-invalid @enderror" id="country"
            name="country" required>
            @error('recordlabel')
        <strong>{{ $message }}</strong>
        </span>
        @enderror
        <button id="submitBtn" type="submit" class="btn btn-primary">Add Recordlabel</button>
    </div>
</form>

@endsection
