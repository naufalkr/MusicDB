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
                        <button class="btn btn-success">
                            Add Track
                        </button>
                    </a>
                </div>
            </div>

        </div>
        <div class="overflow-auto">`
            <table id="songTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Title</th>
                        <th>Artist</th>
                        <th>Album</th>
                        <th>Year</th>
                        <th>Duration</th>
                        <th>Record Label</th>
                        <th>Genre</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data['song'] as $b)
                        <tr>
                            <td>
                                {{ $b->id }}
                            </td>
                            <td>
                                <a href="{{ route('crud-song.show', $b->id) }}">
                                    {{ Str::limit($b->title, 20, '...') }}
                                </a>
                            </td>
                            <td>{{ $b->artist }}</td>
                            <td>{{ $b->album }}</td>
                            <td>{{ $b->year }}</td>
                            <td>
                                @php
                                    $minutes = floor($b->duration / 60);
                                    $seconds = $b->duration % 60;
                                @endphp
                                {{ $minutes }}:{{ str_pad($seconds, 2, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>{{ $b->music_company }}</td>
                            <td>
                                @foreach ($b->genres as $genre)
                                    <span class="badge badge-primary">{{ $genre->nama }}</span>
                                    <!-- Adjust field name as needed -->
                                @endforeach
                            </td>
                            <td>{{ Str::limit($b->description, 30, '...') }}</td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/adminlte/plugins/jszip/jszip.min.js"></script>
    <script src="/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#songTable').DataTable({
                responsive: true
                paging: false,
                searching: false,
                ordering: true,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
            });
        });
    </script>
@endpush
