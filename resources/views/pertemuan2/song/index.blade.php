@extends('layout.base')

@section('title', 'List of Tracks')

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
            <form action="{{ route('crud-song.index') }}" method="GET" class="mr-md-2 mr-0 mb-2 mb-md-0 flex-grow-1">
                <div class="input-group ">
                    <input type="text" name="search" class="form-control" id="search"
                        placeholder="id, title, artist, album, music_company, genre, description etc."
                        value="{{ request()->get('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
            
            <div class="d-flex">
                {{ $data['song']->appends(['search' => request()->get('search'), 'limit' => request()->get('limit')])->links() }}
                <div class="ml-2">
                    <a href="{{ route('crud-song.create') }}" class="text-white">
                    @role('admin')
                    <button class="btn btn-success">
                        Add Track
                    </button>
                    @endrole
                </a>
            </div>
        </div>
    </div>
        <div class="overflow-auto">
            <table id="songTable" class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Artist</th>
                        <th>Album</th>
                        <th>Year</th>
                        <th>Duration</th>
                        <th>Record Label</th>
                        <th>Genre</th>
                        <th>Description</th>
                        @role('admin')                        
                        <th>Action</th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data['song'] as $key => $b)
                        <tr class="song-row" data-id="{{ $b->id }}">
                            <td>
                                 {{ ($data['song']->currentPage() - 1) * $data['song']->perPage() + $key + 1 }}
                            </td>
                            <td class="song-title">
                                <img src="{{ $b->albm->image_url }}" alt="Random Image" style="border: none;" class="img-thumbnail">
                                <a href="{{ route('crud-song.show', $b->id) }}">
                                    {{ Str::limit($b->title, 20, '...') }}
                                </a>
                                <!-- Ikon play yang akan muncul saat hover -->
                                <span class="play-icon" style="display: none;">
                                    <i class="fas fa-play-circle"></i>
                                </span>
                            </td>
                            <!-- <td>{{ $b->artist->nama }}</td>  -->
                            <td><a href="{{ route('crud-singer.show', $b->artist->id) }}" class="artist-link">{{ $b->artist->nama }}</a></td>                                                         
                            <td><a href="{{ route('crud-album.show', $b->albm->id) }}" class="album-link">{{ $b->albm->nama }}</a></td>
                          
                            <td>{{ $b->year }}</td>
                            <td>
                                @php
                                    $minutes = floor($b->duration / 60);
                                    $seconds = $b->duration % 60;
                                @endphp
                                {{ $minutes }}:{{ str_pad($seconds, 2, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>{{ $b->rl->nama }}</td>
                            <td>
                                @foreach ($b->genres as $genre)
                                    <span class="badge badge-primary">{{ $genre->nama }}</span>
                                @endforeach
                            </td>
                            <td>{{ Str::limit($b->description, 30, '...') }}</td>
                            @role('admin')
                            <td class="d-flex">
                                <a href="{{ route('crud-song.edit', $b->id) }}"
                                class="btn btn-primary btn-sm mr-2">Edit</a>
                                <form class="border-0" action="{{ route('crud-song.destroy', $b->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                        @endrole
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No records found</td>
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
        .song-row:hover .play-icon {
            display: inline-block;
            position: absolute;
            left: 20px;
            color: green;
            font-size: 20px;
        }

        a:hover {
            text-decoration: underline;
            color:#28a745
        }

        /* Posisi awal play icon tersembunyi */
        .play-icon {
            display: none;
        }

        /* Warna saat hover baris */
        .song-row:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }

        /* Mengatur posisi play-icon dan title */
        .song-title {
            position: relative;
        }

        /* Mengatur ukuran gambar */
        .img-thumbnail {
            width: 1.2cm;
            height: 1.2cm;
        }

        .artist-link, .album-link {
            text-decoration: none; /* Hilangkan underline default */
            color: black; /* Tetapkan warna default */
        }

        .artist-link:hover, .album-link:hover {
            text-decoration: underline; /* Tambahkan underline saat hover */
            color: #28a745; /* Tetapkan warna saat hover */
        }

    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#songTable').DataTable({
                responsive: true,
                paging: false,
                searching: false,
                ordering: true,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
            });
        });
    </script>
@endpush
