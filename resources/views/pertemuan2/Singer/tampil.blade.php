@extends('layout.base')

@section('title', 'List of Artists')

@section('content')

    <div class="card p-3">
        <div class="">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        <div class="d-flex flex-column flex-md-row gap-2 mb-md-0 mb-2">
            <form action="{{ route('crud-singer.tampil') }}" method="GET" class="mr-md-2 mr-0 mb-2 mb-md-0 flex-grow-1">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" id="search"
                        placeholder="Search by name, bio, etc."
                        value="{{ request()->get('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
            
            <div class="d-flex">
                {{ $singer->appends(['search' => request()->get('search')])->links() }}
                <div class="ml-2">
                    @role('admin')
                    <a href="{{ route('crud-singer.tambah') }}" class="text-white">
                        <button class="btn btn-success">
                            Add Artist
                        </button>
                    </a>
                    @endrole
                </div>
            </div>
        </div>
        <div class="overflow-auto">
            <table id="singerTable" class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Bio</th>
                        @role('admin')
                        <th>Action</th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @forelse ($singer as $key => $data_singer)
                        <tr class="singer-row" data-id="{{ $data_singer->id }}">
                            <td>{{ ($singer->currentPage() - 1) * $singer->perPage() + $key + 1 }}</td>
                            <td class="singer-name">
                                <a href="{{ route('crud-singer.show', $data_singer->id) }}">{{ $data_singer->nama }}</a>
                                <!-- Ikon play yang akan muncul saat hover -->
                                <span class="play-icon" style="display: none;">
                                    <i class="fas fa-play-circle"></i>
                                </span>
                            </td>
                            <td>{{ Str::limit($data_singer->bio, 30, '...') }}</td>
                            @role('admin')
                            <td class="d-flex">
                                <a href="{{ route('crud-singer.edit', $data_singer->id) }}"
                                class="btn btn-primary btn-sm mr-2">Edit</a>
                                <form action="{{ route('crud-singer.delete', $data_singer->id) }}" method="post" style="display:inline-block;">
                                    @csrf
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                            @endrole
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

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
            $('#singerTable').DataTable({
                responsive: true,
                paging: false,
                searching: false,
                ordering: true,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
            });
        });
    </script>
@endpush
