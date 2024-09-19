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
<table id="recordLabelTable" class="table mt-2">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Country</th>
            @role('admin')            
            <th>Action</th>
            @endrole
        </tr>
    </thead>
    <tbody>
        @foreach($recordlabel as $no => $data_recordlabel)
        <tr class="recordlabel-row">
            <td>{{ ($recordlabel->currentPage() - 1) * $recordlabel->perPage() + $no + 1 }}</td>
            <td class="recordlabel-name">
                <a href="{{ route('crud-recordlabel.show', $data_recordlabel->id) }}">{{ $data_recordlabel->nama }}</a>
                <!-- Ikon play yang akan muncul saat hover -->
                <span class="play-icon" style="display: none;">
                    <i class="fas fa-play-circle"></i>
                </span>
            </td>
            <td>{{ $data_recordlabel->country }}</td>
            <td>
                <div class="d-flex justify-content-end mt-2">
                @role('admin')
                
                <a href="{{ route('crud-recordlabel.edit', $data_recordlabel->id) }}" class="btn btn-primary btn-sm mr-2">Edit</a>
                <form action="{{ route('crud-recordlabel.delete', $data_recordlabel->id) }}" method="post" style="display:inline-block;">
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
        .recordlabel-row:hover .play-icon {
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
        .recordlabel-row:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }

        /* Mengatur posisi play-icon dan name */
        .recordlabel-name {
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
