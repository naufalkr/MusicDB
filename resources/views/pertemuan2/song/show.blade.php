@extends('layout.base')

@section('title', 'Detail Song')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <!-- <label for="id">ID</label>
                        <p id="id">{{ $data['song']->id }}</p> -->                        
                        <img src="{{ $data['song']->albm->image_url }}" alt="Random Image" style="border: none; width: 5cm;height: 5cm;" class="img-thumbnail">  
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <p id="title">{{ $data['song']->title }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="artist">Artist</label>
                        <p id="artist">{{ $data['song']->artist->nama }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="album">Album</label>
                        <p id="album">{{ $data['song']->albm->nama }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="year">Tahun Terbit</label>
                        <p id="year">{{ $data['song']->year }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <p id="duration">{{ $data['song']->duration }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="recordlabel">Record Label</label>
                        <p id="recordlabel">{{ $data['song']->rl->nama }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- <div class="form-group">
                        <label for="genre">Genre</label>
                        <br>
                        @foreach ($data['song']->genres as $k)
                            <span class="badge badge-primary">{{ $k->nama }}</span>
                            <!-- Adjust field name as needed -->
                        <!-- @endforeach -->
                    <!-- </div> --> 
                </div>
            </div>
            
            <div class="form-group">
                <label for="category">Category</label>
                <p id="category">{{ $data['song']->category }}</p>
            </div>

            <div class="form-group">
                <label for="description">Popularity</label>
                <p id="description">{{ $data['song']->description }}</p>
            </div>

            <a href="{{ route('crud-song.index') }}" class="btn btn-primary">Kembali ke Daftar Song</a>
            <a href="{{ route('crud-song.edit', $data['song']->id) }}" class="btn btn-warning">Edit Song</a>
            <form class="border-0" action="{{ route('crud-song.destroy', $data['song']->id) }}" method="POST"
                style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Hapus Song</button>
            </form>
        </div>
    </div>
@endsection
