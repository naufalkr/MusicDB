@extends('layout.base')

@section('title', 'List of Playlists')

@section('content')

<!-- Form untuk Search -->
<div class="d-flex justify-content-between align-items-center">
    <form action="{{ route('crud-playlist.tampil') }}" method="GET" class="d-flex">
        <input type="text" class="form-control" placeholder="Search" name="search" value="{{ request('search') }}">
        <button class="btn btn-primary ml-2" type="submit">Search</button>
    </form>
    
    <!-- Pagination di atas tabel -->
    <div class="d-flex justify-content-end mt-2">
        {{ $playlist->appends(request()->query())->links() }}
        <a href="{{ route('crud-playlist.tambah') }}" class="btn btn-success">
    Add Playlist
    </a>
    </div>    
</div>


<!-- Tabel Playlist -->
<table id="songTable" class="table table-bordered mt-2">
    <thead class="table">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Release_date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($playlist as $no => $data_playlist)
        <tr>
            <td>{{ ($playlist->currentPage() - 1) * $playlist->perPage() + $no + 1 }}</td>
            <td>{{ $data_playlist->nama }}</td>
            <td>{{ $data_playlist->release_date }}</td>
            <td>
                <div class="d-flex justify-content-end mt-2">
                
                <a href="{{ route('crud-playlist.edit', $data_playlist->id) }}" class="btn btn-primary btn-sm mr-2">Edit</a>
                <form action="{{ route('crud-playlist.delete', $data_playlist->id) }}" method="post" style="display:inline-block;">
                    @csrf
                    <!-- @method('DELETE') -->
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
                </div>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>


@endsection
