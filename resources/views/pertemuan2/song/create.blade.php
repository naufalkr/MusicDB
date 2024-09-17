@extends('layout.base')
@push('styles')
    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="/css/jquery-ui.min.css"> <!-- Add jQuery UI CSS for autocomplete -->
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
                            <input type="text" class="form-control @error('artist') is-invalid @enderror" id="artist_name"
                                name="artist_name" value="{{ old('artist_name') }}" required>
                            <input type="hidden" id="artist_id" name="artist_id" value="{{ old('artist_id') }}" required>
                            @error('artist_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- <div class="form-group">
                            <label for="album">Album</label>
                            <input type="text" class="form-control @error('album') is-invalid @enderror"
                                id="album" name="album" value="{{ old('album') }}" required>
                            @error('album')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> -->
                        <div class="form-group">
                            <label for="albm">albm</label>
                            <input type="text" class="form-control @error('albm') is-invalid @enderror" id="albm_name"
                                name="albm_name" value="{{ old('albm_name') }}" required>
                            <input type="hidden" id="albm_id" name="albm_id" value="{{ old('albm_id') }}" required>
                            @error('albm_name')
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
                        <!-- <div class="form-group">
                            <label for="recordlabel">Record Label</label>
                            <input type="text" class="form-control @error('recordlabel') is-invalid @enderror" id="recordlabel"
                                name="recordlabel" value="{{ old('recordlabel') }}" required>
                            @error('recordlabel')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> -->
                        <div class="form-group">
                            <label for="rl">Record Label</label>
                            <input type="text" class="form-control @error('rl') is-invalid @enderror" id="rl_name"
                                name="rl_name" value="{{ old('rl_name') }}" required>
                            <input type="hidden" id="rl_id" name="rl_id" value="{{ old('rl_id') }}" required>
                            @error('rl_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="genre">Genre</label><br>
                                <select class="selectpicker w-100" id="genre" name="genre[]" class="form-control @error('genre') is-invalid @enderror" multiple>
                                    @foreach ($data['genre'] as $k)
                                        <option value="{{ $k->id }}" {{ in_array($k->id, old('genre', [])) ? 'selected' : '' }}>
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
                <a href="{{ route('crud-song.index') }}" class="btn btn-warning">Back</a>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/js/jquery-ui.min.js"></script> <!-- Add jQuery UI JS for autocomplete -->
    <script src="/js/bootstrap-select.min.js"></script>
    <script>
            $(document).ready(function() {
                $('#artist_name').autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('autocomplete.artists') }}",
                            dataType: "json",
                            data: {
                                term: request.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2,
                    select: function(event, ui) {
                        $('#artist_name').val(ui.item.label); // Show the artist name in the input
                        $('#artist_id').val(ui.item.value); // Store the artist ID in the hidden field
                        return false;
                    }
                });
                $('#albm_name').autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('autocomplete.albm') }}",
                            dataType: "json",
                            data: {
                                term: request.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2,
                    select: function(event, ui) {
                        $('#albm_name').val(ui.item.label); // Show the albm name in the input
                        $('#albm_id').val(ui.item.value); // Store the albm ID in the hidden field
                        return false;
                    }
                });
                $('#rl_name').autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('autocomplete.rl') }}",
                            dataType: "json",
                            data: {
                                term: request.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2,
                    select: function(event, ui) {
                        $('#rl_name').val(ui.item.label); // Show the rl name in the input
                        $('#rl_id').val(ui.item.value); // Store the rl ID in the hidden field
                        return false;
                    }
                });
            });

    </script>
@endpush
