@extends('layout.base')

@section('title', 'List of Record Labels')

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
            <form action="{{ route('crud-recordlabel.tampil') }}" method="GET" class="mr-md-2 mr-0 mb-2 mb-md-0 flex-grow-1">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" id="search"
                        placeholder="Search by name, country, etc."
                        value="{{ request()->get('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
            
            <div class="d-flex">
                {{ $recordlabel->appends(['search' => request()->get('search')])->links() }}
                <div class="ml-2">
                    @role('admin')
                    <a href="{{ route('crud-recordlabel.tambah') }}" class="text-white">
                        <button class="btn btn-success">
                            Add Record Label
                        </button>
                    </a>
                    @endrole
                </div>
            </div>
        </div>
        <div class="overflow-auto">
            <table id="recordlabelTable" class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <!-- <th>Country</th> -->
                        @role('admin')
                        <th>Action</th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recordlabel as $key => $data_recordlabel)
                        <tr class="recordlabel-row" data-id="{{ $data_recordlabel->id }}">
                            <td>{{ ($recordlabel->currentPage() - 1) * $recordlabel->perPage() + $key + 1 }}</td>
                            <td class="recordlabel-name">
                                <a href="{{ route('crud-recordlabel.show', $data_recordlabel->id) }}">{{ $data_recordlabel->nama }}</a>
                                <!-- Ikon play yang akan muncul saat hover -->
                                <span class="play-icon" style="display: none;">
                                    <i class="fas fa-play-circle"></i>
                                </span>
                            </td>
                            <!-- <td>{{ Str::limit($data_recordlabel->country, 30, '...') }}</td> -->
                            @role('admin')
                            <td class="d-flex">
                                <a href="{{ route('crud-recordlabel.edit', $data_recordlabel->id) }}"
                                class="btn btn-primary btn-sm mr-2">Edit</a>
                                <form action="{{ route('crud-recordlabel.delete', $data_recordlabel->id) }}" method="post" style="display:inline-block;">
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
            $('#recordlabelTable').DataTable({
                responsive: true,
                paging: false,
                searching: false,
                ordering: true,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
            });
        });
    </script>
@endpush
