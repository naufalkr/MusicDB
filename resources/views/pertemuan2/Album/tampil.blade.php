@extends('layout.base')

@section('title', 'List of Artists')

@section('content')

<!-- Form untuk Search -->
<div class="d-flex justify-content-between align-items-center">
    <form action="{{ route('crud-singer.tampil') }}" method="GET" class="d-flex">
        <input type="text" class="form-control" placeholder="Search" name="search" value="{{ request('search') }}">
        <button class="btn btn-primary ml-2" type="submit">Search</button>
    </form>
    
    <!-- Pagination di atas tabel -->
    <div class="d-flex justify-content-end mt-2">
        {{ $singer->appends(request()->query())->links() }}
        <a href="{{ route('crud-singer.tambah') }}" class="btn btn-success">
    Add Artist
    </a>
    </div>    
</div>


<!-- Tabel Singer -->
<table id="songTable" class="table table-bordered mt-2">
    <thead class="table">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Bio</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($singer as $no => $data_singer)
        <tr>
            <td>{{ ($singer->currentPage() - 1) * $singer->perPage() + $no + 1 }}</td>
            <td>{{ $data_singer->nama }}</td>
            <td>{{ $data_singer->bio }}</td>
            <td>
                <div class="d-flex justify-content-end mt-2">
                
                <a href="{{ route('crud-singer.edit', $data_singer->id) }}" class="btn btn-primary btn-sm mr-2">Edit</a>
                <form action="{{ route('crud-singer.delete', $data_singer->id) }}" method="post" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
                </div>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>


@endsection
