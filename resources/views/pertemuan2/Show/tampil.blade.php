@extends('layout.base')

@section('title', 'List of Shows')

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
            <form action="{{ route('crud-show.tampil') }}" method="GET" class="mr-md-2 mr-0 mb-2 mb-md-0 flex-grow-1">
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
                {{ $show->appends(['search' => request()->get('search')])->links() }}
                <div class="ml-2">
                    @role('admin')
                    <a href="{{ route('crud-show.tambah') }}" class="text-white">
                        <button class="btn btn-success">
                            Add Show
                        </button>
                    </a>
                    @endrole
                </div>
            </div>
        </div>
        <div class="overflow-auto">
            <table id="showTable" class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Publisher</th>
                        @role('admin')
                        <th>Action</th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @forelse ($show as $key => $data_show)
                        <tr class="show-row" data-id="{{ $data_show->id }}">
                            <td>{{ ($show->currentPage() - 1) * $show->perPage() + $key + 1 }}</td>
                            <td class="show-name">
                                <img src="{{ $data_show->image_url }}" alt="{{ $data_show->image_url }}" class="img-thumbnail" style=" height: auto;">
                                
                                <a href="{{ route('crud-show.show', $data_show->id) }}">{{ $data_show->nama }}</a>
                                <!-- Ikon play yang akan muncul saat hover -->
                                <span class="play-icon" style="display: none;">
                                    <i class="fas fa-play-circle"></i>
                                </span>
                            </td>
                            <td>{{ Str::limit($data_show->release_date, 30, '...') }}</td>
                            @role('admin')
                            <td class="d-flex">
                                <a href="{{ route('crud-show.edit', $data_show->id) }}"
                                class="btn btn-primary btn-sm mr-2">Edit</a>
                                <form action="{{ route('crud-show.delete', $data_show->id) }}" method="post" style="display:inline-block;">
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
        .show-row:hover .play-icon {
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
        .show-row:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }

        /* Mengatur posisi play-icon dan name */
        .show-name {
            position: relative;
        }

        .img-thumbnail {
        width: 1.4cm;
        height: 1.4cm;
    }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#showTable').DataTable({
                responsive: true,
                paging: false,
                searching: false,
                ordering: true,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
            });
        });
    </script>
@endpush
