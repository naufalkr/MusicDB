@extends('layout.base')

@section('title', 'Edit Genre')

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="updateForm" action="{{ route('crud-genre.update', $data['genre']->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Menandakan bahwa ini adalah request untuk update -->

                <div class="form-group">
                    <label for="title">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                        name="nama" value="{{ old('nama', $data['genre']->nama) }}" required>
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </form>
            <button id="submitBtn" type="submit" class="btn btn-primary">Update Genre</button>
            <a href="{{ route('crud-genre.index') }}" class="btn btn-warning">Kembali ke Daftar Genre</a>
            <a href="{{ route('crud-genre.show', $data['genre']->id) }}" class="btn btn-warning">
                Kembali ke Detail Genre</a>
            <form class="border-0" action="{{ route('crud-genre.destroy', $data['genre']->id) }}" method="POST"
                style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Hapus
                    Genre</button>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.getElementById('submitBtn').addEventListener('click', function() {
            document.getElementById('updateForm').submit();
        });
    </script>
@endpush
