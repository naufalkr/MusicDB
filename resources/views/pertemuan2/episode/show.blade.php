@extends('layout.base')

@section('title', 'Detail Episode')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <!-- <label for="id">ID</label>
                        <p id="id">{{ $data['episode']->id }}</p> -->                        
                        <img src="{{ $data['episode']->podcast->image_url }}" alt="Random Image" style="border: none; width: 5cm;height: 5cm;" class="img-thumbnail">  
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <p id="title">{{ $data['episode']->title }}</p>
                    </div>
                </div>
            </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="show">Show</label>
                        <p id="show">{{ $data['episode']->podcast->nama }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="year">Tahun Terbit</label>
                        <p id="year">{{ $data['episode']->year }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <p id="duration">{{ $data['episode']->duration }}</p>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label for="description">Description</label>
                <p id="description">{{ $data['episode']->description }}</p>
            </div>

            <a href="{{ route('crud-episode.index') }}" class="btn btn-primary">Kembali ke Daftar Episode</a>
            <a href="{{ route('crud-episode.edit', $data['episode']->id) }}" class="btn btn-warning">Edit Episode</a>
            <form class="border-0" action="{{ route('crud-episode.destroy', $data['episode']->id) }}" method="POST"
                style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Hapus Episode</button>
            </form>
        </div>
    </div>
@endsection
