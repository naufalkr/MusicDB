@extends('layout.base')

@section('title', 'Edit Episode')

@push('styles')
    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="updateForm" action="{{ route('crud-episode.update', $data['episode']->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Menandakan bahwa ini adalah request untuk update -->

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ old('title', $data['episode']->title) }}" required>
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
                                name="artist" value="{{ old('artist', $data['episode']->artist->nama) }}" required>
                            @error('artist')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="show">Show</label>
                            <input type="text" class="form-control @error('show') is-invalid @enderror"
                                id="show" name="show" value="{{ old('show', $data['episode']->podcast->nama) }}"
                                required>
                            @error('show')
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
                                value="{{ old('year', $data['episode']->year) }}">
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
                                value="{{ old('duration', $data['episode']->duration) }}">
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
                            <label for="recordlabel">Record Label</label>
                            <input type="text" class="form-control @error('recordlabel') is-invalid @enderror" id="recordlabel"
                                name="recordlabel" value="{{ old('recordlabel', $data['episode']->rl->nama) }}" required>
                            @error('recordlabel')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="genre">Genre</label>
                            <select class="selectpicker w-100 @error('genre') is-invalid @enderror" id="genre"
                                name="genre[]" multiple>
                                @foreach ($data['genre'] as $k)
                                    <option value="{{ $k->id }}"
                                        {{ in_array($k->id, old('genre', $data['episode-genre'])) ? 'selected' : '' }}>
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

                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="genre">Genre</label>
                            <input type="text" class="form-control @error('genre') is-invalid @enderror"
                                id="genre" name="genre" value="{{ old('genre', $data['episode']->genre) }}">
                            @error('genre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $data['episode']->description) }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


            </form>
            <button id="submitBtn" type="submit" class="btn btn-primary">Update Episode</button>
            <a href="{{ route('crud-episode.index') }}" class="btn btn-warning">Kembali ke Daftar Episode</a>
            <a href="{{ route('crud-episode.show', $data['episode']->id) }}" class="btn btn-warning">
                Kembali ke Detail Episode</a>
            <form class="border-0" action="{{ route('crud-episode.destroy', $data['episode']->id) }}" method="POST"
                style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Hapus
                Episode</button>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="/js/bootstrap-select.min.js"></script>
@endpush
@push('scripts')
    <script>
        document.getElementById('submitBtn').addEventListener('click', function() {
            document.getElementById('updateForm').submit();
        });
    </script>
@endpush
