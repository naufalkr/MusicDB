@extends('layout.base')

@section('title', 'List of Favorites')

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
            <form action="{{ route('crud-favorite.tampil') }}" method="GET" class="mr-md-2 mr-0 mb-2 mb-md-0 flex-grow-1">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" id="search"
                        placeholder="Search by name, release_date, etc."
                        value="{{ request()->get('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
            
            <div class="d-flex">
                {{ $favorite->appends(['search' => request()->get('search')])->links() }}
                <div class="ml-2">
                    @role('user')
                    <a href="{{ route('crud-favorite.tambah') }}" class="text-white">
                    @role('admin')

                    
                    <button class="btn btn-success">
                        Add Favorite
                    </button>
                    @endrole
                    </a>
                    @endrole
                </div>
            </div>
        </div>
        <div class="overflow-auto">
            <table id="favoriteTable" class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        @role('admin')
                        <th>Action</th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @forelse ($favorite as $key => $data_favorite)
                        <tr class="favorite-row" data-id="{{ $data_favorite->id }}">
                            <td>{{ ($favorite->currentPage() - 1) * $favorite->perPage() + $key + 1 }}</td>
                            <td class="favorite-name">
                                <a href="{{ route('crud-favorite.show', $data_favorite->id) }}">{{ $data_favorite->nama }}</a>
                                <!-- Ikon play yang akan muncul saat hover -->
                                <span class="play-icon" style="display: none;">
                                    <i class="fas fa-play-circle"></i>
                                </span>
                            </td>
                            <td>{{ Str::limit($data_favorite->release_date, 30, '...') }}</td>
                            @role('admin')
                            <td class="d-flex">
                                <a href="{{ route('crud-favorite.edit', $data_favorite->id) }}"
                                class="btn btn-primary btn-sm mr-2">Edit</a>
                                <form action="{{ route('crud-favorite.delete', $data_favorite->id) }}" method="post" style="display:inline-block;">
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
        .favorite-row:hover .play-icon {
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
        .favorite-row:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }

        /* Mengatur posisi play-icon dan name */
        .favorite-name {
            position: relative;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#favoriteTable').DataTable({
                responsive: true,
                paging: false,
                searching: false,
                ordering: true,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
            });
        });
    </script>
@endpush
