@extends('layout.base')

@section('title', 'Edit Track')

@push('styles')
    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="updateForm" action="{{ route('crud-song.update', $data['song']->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ old('title', $data['song']->title) }}" required>
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="artist">Artist</label>
                            <input type="text" class="form-control @error('artist') is-invalid @enderror" id="artist"
                                name="artist" value="{{ old('artist', $data['song']->artist->nama) }}" required>
                            @error('artist')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="album">Album</label>
                            <input type="text" class="form-control @error('album') is-invalid @enderror"
                                id="album" name="album" value="{{ old('album', $data['song']->albm->nama) }}" required>
                            @error('album')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="year">Year</label>
                            <input type="number" class="form-control @error('year') is-invalid @enderror"
                                id="year" name="year"
                                value="{{ old('year', $data['song']->year) }}">
                            @error('year')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="duration">Duration</label>
                            <input type="number" class="form-control @error('duration') is-invalid @enderror"
                                id="duration" name="duration"
                                value="{{ old('duration', $data['song']->duration) }}">
                            @error('duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="recordlabel">Record Label</label>
                    <input type="text" class="form-control @error('recordlabel') is-invalid @enderror" id="recordlabel"
                        name="recordlabel" value="{{ old('recordlabel', $data['song']->rl->nama) }}" required>
                    @error('recordlabel')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <textarea class="form-control @error('category') is-invalid @enderror" id="category" name="category" rows="4">{{ old('category', $data['song']->category) }}</textarea>
                    @error('category')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $data['song']->description) }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </form>
            <button id="submitBtn" type="submit" class="btn btn-primary">Update Track</button>
            <a href="{{ route('crud-song.index') }}" class="btn btn-warning">Kembali ke Daftar Track</a>
            <a href="{{ route('crud-song.show', $data['song']->id) }}" class="btn btn-warning">
                Kembali ke Detail Track</a>
            <form class="border-0" action="{{ route('crud-song.destroy', $data['song']->id) }}" method="POST"
                style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Hapus
                Track</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('submitBtn').addEventListener('click', function() {
            document.getElementById('updateForm').submit();
        });
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih",
                allowClear: true
            });
        });
    </script>
@endpush
