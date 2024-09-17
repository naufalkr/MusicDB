@extends('layout.base')

@section('title', 'List of Albums')

@section('content')

<!-- Form untuk Search -->
<div class="d-flex justify-content-between align-items-center">
    <form action="{{ route('crud-album.tampil') }}" method="GET" class="d-flex">
        <input type="text" class="form-control" placeholder="Search" name="search" value="{{ request('search') }}">
        <button class="btn btn-primary ml-2" type="submit">Search</button>
    </form>
    
    <!-- Pagination di atas tabel -->
    <div class="d-flex justify-content-end mt-2">
        {{ $album->appends(request()->query())->links() }}
        <a href="{{ route('crud-album.tambah') }}" class="btn btn-success">
    Add Album
    </a>
    </div>    
</div>


<!-- Tabel Album -->
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
        @foreach($album as $no => $data_album)
        <tr>
            <td>{{ ($album->currentPage() - 1) * $album->perPage() + $no + 1 }}</td>
            <!-- <td>{{ $data_album->nama }}</td> -->
            <td><a href="{{ route('crud-album.show', $data_album->id) }}">{{ $data_album->nama }}</a></td>
            <td>{{ $data_album->release_date }}</td>
            <td>
                <div class="d-flex justify-content-end mt-2">
                
                <a href="{{ route('crud-album.edit', $data_album->id) }}" class="btn btn-primary btn-sm mr-2">Edit</a>
                <form action="{{ route('crud-album.delete', $data_album->id) }}" method="post" style="display:inline-block;">
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
