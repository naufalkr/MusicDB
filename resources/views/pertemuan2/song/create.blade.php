@extends('layout.base')
@push('styles')
    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
@endpush
@section('title', 'Add Track')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('crud-song.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <textarea class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                        value="{{ old('title') }}" required></textarea>
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
                                name="artist" value="{{ old('artist') }}" required>
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
                                id="album" name="album" value="{{ old('album') }}" required>
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
                                id="year" name="year" value="{{ old('year') }}">
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
                                id="duration" name="duration" value="{{ old('duration') }}">
                            @error('duration')
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
                            <label for="music_company">Record Label</label>
                            <input type="text" class="form-control @error('music_company') is-invalid @enderror" id="music_company"
                                name="music_company" value="{{ old('music_company') }}" required>
                            @error('music_company')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="genre">Genre</label><br>
                            <select class="selectpicker w-100" id="genre" name="genre[]"
                                class="form-control @error('genre') is-invalid @enderror" multiple>
                                @foreach ($data['genre'] as $k)
                                    <option value="{{ $k->id }}"
                                        {{ in_array($k->id, old('genre', [])) ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('genre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Add Song</button>
                <a href="{{ route('crud-song.index') }}" class="btn btn-warning">Kembali</a><a href="#"></a>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="/js/bootstrap-select.min.js"></script>
@endpush
