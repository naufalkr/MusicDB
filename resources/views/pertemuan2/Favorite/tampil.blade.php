@extends('layout.base')

@section('title', 'List of Favorites')

@section('content')

<!-- Form untuk Search -->
<div class="d-flex justify-content-between align-items-center">
    <form action="{{ route('crud-favorite.tampil') }}" method="GET" class="d-flex">
        <input type="text" class="form-control" placeholder="Search" name="search" value="{{ request('search') }}">
        <button class="btn btn-primary ml-2" type="submit">Search</button>
    </form>
    
    <!-- Pagination di atas tabel -->
    <div class="d-flex justify-content-end mt-2">
        {{ $favorite->appends(request()->query())->links() }}
        <a href="{{ route('crud-favorite.tambah') }}" class="btn btn-success">
    Add Favorite
    </a>
    </div>    
</div>


<!-- Tabel Favorite -->
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
        @foreach($favorite as $no => $data_favorite)
        <tr>
            <td>{{ ($favorite->currentPage() - 1) * $favorite->perPage() + $no + 1 }}</td>
            <td>
                <a href="{{ route('crud-favorite.show', $data_favorite->id) }}">{{ $data_favorite->nama }}</a>
            </td>
            <td>{{ $data_favorite->release_date }}</td>
            <td>
                <div class="d-flex justify-content-end mt-2">
                
                <a href="{{ route('crud-favorite.edit', $data_favorite->id) }}" class="btn btn-primary btn-sm mr-2">Edit</a>
                <form action="{{ route('crud-favorite.delete', $data_favorite->id) }}" method="post" style="display:inline-block;">
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
