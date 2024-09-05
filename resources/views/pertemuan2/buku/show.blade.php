@extends('layout.base')

@section('title', 'Detail Buku')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id">ID</label>
                        <p id="id">{{ $data['buku']->id }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <p id="title">{{ $data['buku']->title }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="artist">Artist</label>
                        <p id="artist">{{ $data['buku']->artist }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="album">Album</label>
                        <p id="album">{{ $data['buku']->album }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="year">Tahun Terbit</label>
                        <p id="year">{{ $data['buku']->year }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="duration">Jumlah Halaman</label>
                        <p id="duration">{{ $data['buku']->duration }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="music_company">MUSIC_COMPANY</label>
                        <p id="music_company">{{ $data['buku']->music_company }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="genre">Genre</label>
                        <br>
                        @foreach ($data['buku']->genres as $k)
                            <span class="badge badge-primary">{{ $k->nama }}</span>
                            <!-- Adjust field name as needed -->
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <p id="description">{{ $data['buku']->description }}</p>
            </div>

            <a href="{{ route('crud-buku.index') }}" class="btn btn-primary">Kembali ke Daftar Buku</a>
            <a href="{{ route('crud-buku.edit', $data['buku']->id) }}" class="btn btn-warning">Edit Buku</a>
            <form class="border-0" action="{{ route('crud-buku.destroy', $data['buku']->id) }}" method="POST"
                style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Hapus Buku</button>
            </form>
        </div>
    </div>
@endsection
