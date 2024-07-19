@extends('front.layouts.panel')

@push('scripts')
<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#datatable')) {
            $('#datatable').DataTable().destroy();
        }
        $('#datatable').DataTable({
            processing: true,
            serverSide: false,
            ajax: '{{ route('get-calendar') }}',
            columns: [
                { data: 'no', name: 'no' },
                { data: 'title', name: 'title' },
                { data: 'start', name: 'start' },
                { data: 'end', name: 'end' },
                { data: 'aksi', name: 'aksi' },
            ]
        });

        $('#datatable').on('click', '.update', function() {
            var id = $(this).data('id');
            console.log(id);
            $.ajax({
                url: '{{ route("get-calendar-id", ["id" => ":id"]) }}'.replace(':id', id),
                type: 'GET',
                success: function(data) {
                    $('#form-update').attr('action', '{{ route("freelance-update-calendar", ["id" => ":id"]) }}'.replace(':id', id));
                    $('#form-update').append('<input type="hidden" name="_method" value="PUT">');
                    $('#title').val(data.title);
                    $('#start').val(data.start);
                    $('#end').val(data.end);
                    $('#submit-button').text('Update');
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        $('#reset-button').on('click', function() {
            $('#form-update').attr('action', '{{ route("freelance-create-calendar") }}');
            $('#form-update').find('input[name="_method"]').remove();
            $('#title').val('');
            $('#start').val('');
            $('#end').val('');
            $('#submit-button').text('Tambah');
        });

        
        $('#datatable').on('click', '.delete', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan bisa mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("freelance-delete-calendar", ["id" => ":id"]) }}'.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            location.reload();
                        },
                        error: function(error) {
                            location.reload();
                        }
                    });
                }
            })
        });
    });
</script>
@endpush

@section('content')
<div class="dashboard-header">
    <div class="main-title">
        <h3>Manajemen Kalender</h3>
    </div>
    <div class="head-info">
        <a href="{{ route('view_calendar', ['user' => auth()->user()->username]) }}" class="btn btn-primary">Lihat Kalender</a>
    </div>
</div>

<form class="form" method="POST" action="{{ route('freelance-create-calendar') }}" id="form-update">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label">Judul</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="start" class="form-label">Mulai Tanggal</label>
        <input type="datetime-local" name="start" id="start" class="form-control @error('start') is-invalid @enderror" value="{{ old('start') }}">
        @error('start')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="end" class="form-label">Akhir Tanggal</label>
        <input type="datetime-local" name="end" id="end" class="form-control @error('end') is-invalid @enderror" value="{{ old('end') }}">
        @error('end')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary" id="submit-button">Tambah</button>
        <button type="reset" class="btn btn-danger" id="reset-button">Reset</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped datatable" id="datatable">
        <thead class="thead-light">
            <tr>
                <th>NO</th>
                <th>Title</th>
                <th>Mulai Tanggal</th>
                <th>Akhir Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection