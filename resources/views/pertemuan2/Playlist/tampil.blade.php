@extends('layout.base')

@section('title', 'List of Playlists')

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
            <form action="{{ route('crud-playlist.tampil') }}" method="GET" class="mr-md-2 mr-0 mb-2 mb-md-0 flex-grow-1">
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
                {{ $playlist->appends(['search' => request()->get('search')])->links() }}
                <div class="ml-2">
                    @role('user')
                    <a href="{{ route('crud-playlist.tambah') }}" class="text-white">
                        <button class="btn btn-success">
                            Add Playlist
                        </button>
                    </a>
                    @endrole
                </div>
            </div>
        </div>
        <div class="overflow-auto">
            <table id="playlistTable" class="table">
                <thead>
                    <tr>
                        <th>#</th>  
                        <th>Name</th>
                        <th>Description</th>
                        @role('user')
                        <th>Action</th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @forelse ($playlist as $key => $data_playlist)
                        <tr class="playlist-row" data-id="{{ $data_playlist->id }}">
                            <td>{{ ($playlist->currentPage() - 1) * $playlist->perPage() + $key + 1 }}</td>
                            <td class="playlist-name">
                                <a href="{{ route('crud-playlist.show', $data_playlist->id) }}">{{ $data_playlist->nama }}</a>
                                <!-- Ikon play yang akan muncul saat hover -->
                                <span class="play-icon" style="display: none;">
                                    <i class="fas fa-play-circle"></i>
                                </span>
                            </td>
                            <td>{{ Str::limit($data_playlist->release_date, 30, '...') }}</td>
                            @role('user')
                            <td class="d-flex">
                                <a href="{{ route('crud-playlist.edit', $data_playlist->id) }}"
                                class="btn btn-primary btn-sm mr-2">Edit</a>
                                <form action="{{ route('crud-playlist.delete', $data_playlist->id) }}" method="post" style="display:inline-block;">
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
        .playlist-row:hover .play-icon {
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
        .playlist-row:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }

        /* Mengatur posisi play-icon dan name */
        .playlist-name {
            position: relative;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#playlistTable').DataTable({
                responsive: true,
                paging: false,
                searching: false,
                ordering: true,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
            });
        });
    </script>
@endpush
