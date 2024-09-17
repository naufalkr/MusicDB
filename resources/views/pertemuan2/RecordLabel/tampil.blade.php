@extends('layout.base')

@section('title', 'List of Recordlabels')

@section('content')

<!-- Form untuk Search -->
<div class="d-flex justify-content-between align-items-center">
    <form action="{{ route('crud-recordlabel.tampil') }}" method="GET" class="d-flex">
        <input type="text" class="form-control" placeholder="Search" name="search" value="{{ request('search') }}">
        <button class="btn btn-primary ml-2" type="submit">Search</button>
    </form>
    
    <!-- Pagination di atas tabel -->
    <div class="d-flex justify-content-end mt-2">
        {{ $recordlabel->appends(request()->query())->links() }}
        <a href="{{ route('crud-recordlabel.tambah') }}" class="btn btn-success">
    Add Recordlabel
    </a>
    </div>    
</div>


<!-- Tabel Recordlabel -->
<table id="songTable" class="table table-bordered mt-2">
    <thead class="table">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Country</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($recordlabel as $no => $data_recordlabel)
        <tr>
            <td>{{ ($recordlabel->currentPage() - 1) * $recordlabel->perPage() + $no + 1 }}</td>
            <td>{{ $data_recordlabel->nama }}</td>
            <td>{{ $data_recordlabel->country }}</td>
            <td>
                <div class="d-flex justify-content-end mt-2">
                
                <a href="{{ route('crud-recordlabel.edit', $data_recordlabel->id) }}" class="btn btn-primary btn-sm mr-2">Edit</a>
                <form action="{{ route('crud-recordlabel.delete', $data_recordlabel->id) }}" method="post" style="display:inline-block;">
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
