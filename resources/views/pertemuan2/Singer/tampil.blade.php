@extends('layout.base')

@section('title', 'List of Artists')

@section('content')

<!-- Form untuk Search -->
<div class="d-flex justify-content-between align-items-center">
    <form action="{{ route('crud-singer.tampil') }}" method="GET" class="d-flex">
        <input type="text" class="form-control" placeholder="Search" name="search" value="{{ request('search') }}">
        <button class="btn btn-success ml-2" type="submit">Search</button>
    </form>
    
    <!-- Pagination di atas tabel -->
    <div class="d-flex justify-content-end mt-2">
        {{ $singer->appends(request()->query())->links() }}
        @role('admin')        
        <a href="{{ route('crud-singer.tambah') }}" class="btn btn-success">
            Add Artist
        </a>
        @endrole
    </div>    
</div>

<!-- Tabel Singer -->
<table id="singerTable" class="table mt-2">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Bio</th>        
            @role('admin')            
            <th>Action</th>
            @endrole
        </tr>
    </thead>
    <tbody>
        @foreach($singer as $no => $data_singer)
        <tr class="singer-row">
            <td>{{ ($singer->currentPage() - 1) * $singer->perPage() + $no + 1 }}</td>
            <td class="singer-name">
                <a href="{{ route('crud-singer.show', $data_singer->id) }}">{{ $data_singer->nama }}</a>
                <!-- Ikon play yang akan muncul saat hover -->
                <span class="play-icon" style="display: none;">
                    <i class="fas fa-play-circle"></i>
                </span>
            </td>
            <td>{{ $data_singer->bio }}</td>
            <td>
                <div class="d-flex justify-content-end mt-2">
                @role('admin')
                
                <a href="{{ route('crud-singer.edit', $data_singer->id) }}" class="btn btn-success btn-sm mr-2">Edit</a>
                
                <form action="{{ route('crud-singer.delete', $data_singer->id) }}" method="post" style="display:inline-block;">
                    @csrf
                    <!-- @method('DELETE') -->
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
                @endrole
                </div>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@push('styles')
    <style>
        /* Hilangkan border tabel agar berurutan */
        .table {
            border-collapse: collapse;
        }
        .table td, .table th {
            border: none;
        }

        /* Hover effect: play icon */
        .singer-row:hover .play-icon {
            display: inline-block;
            position: absolute;
            left: 20px;
            color: green;
            font-size: 20px;
        }

        /* Posisi awal play icon tersembunyi */
        .play-icon {
            display: none;
        }

        /* Warna saat hover baris */
        .singer-row:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }

        /* Mengatur posisi play-icon dan name */
        .singer-name {
            position: relative;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Jika diperlukan, tambahkan kode JavaScript atau jQuery di sini
        });
    </script>
@endpush
