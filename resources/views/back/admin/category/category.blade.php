@extends('back.layouts.main')

@push('scripts')
    <script>
        $(function() {
            $('#datatable').DataTable({
                processing: true,
                serverSide: false,
                ajax: '{{ route('get_category') }}',
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'name', name: 'name' },
                    { data: 'icon', name: 'icon' },
                    { data: 'image', name: 'nik' },
                    { data: 'aksi', name: 'aksi' },
                ]
            });
        });

        $('#datatable').on('click', '.update', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '{{ route("get_category_id", ["id" => ":id"]) }}'.replace(':id', id),
                type: 'GET',
                success: function(data) {
                    $('#form-update').attr('action', '{{ route("update_category", ["id" => ":id"]) }}'.replace(':id', id));
                    if ($('input[name="_method"]').length === 0) {
                        $('#form-update').append('<input type="hidden" name="_method" value="PUT">');
                    }
                    $('#name').val(data.name);
                    $('#icon').val(data.icon);
                    $('#submit-button').text('Update');
                },
                error: function(error) {
                    console.error(error);
                    Swal.fire(
                        'Error!',
                        'Terjadi kesalahan saat mengambil data kategori.',
                        'error'
                    );
                }
            });
        });

        $('#image').on('change', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('#reset-button').on('click', function() {
            $('#form-update').attr('action', '{{ route("create_category") }}');
            $('#form-update').find('input[name="_method"]').remove();
            $('#name').val('');
            $('#icon').val('');
            $('#image').val('');
            $('#image-preview').attr('src', '').hide();
            $('#submit-button').text('Tambah');
        });

        $('#form-update').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            var action = $(this).attr('action');
            var method = $(this).find('input[name="_method"]').val() || 'POST';

            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: action,
                type: method === 'PUT' ? 'POST' : method,
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-HTTP-Method-Override': method
                },
                success: function(response) {
                    Swal.fire(
                        'Sukses!',
                        response.message,
                        'success'
                    );
                    $('#datatable').DataTable().ajax.reload();
                    $('#reset-button').click();
                },
                error: function(error) {
                    console.error(error);
                    Swal.fire(
                        'Error!',
                        'Terjadi kesalahan saat menyimpan data kategori.',
                        'error'
                    );
                }
            });
        });

        $('#datatable').on('click', '.delete', function() {
            var id = $(this).data('id');
            console.log($(this).data('id'));
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("delete_category", ["id" => ":id"]) }}'.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                Swal.fire(
                                    'Dihapus!',
                                    response.message,
                                    'success'
                                );
                                $('#datatable').DataTable().ajax.reload();
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(error) {
                            console.error(error);
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat menghapus kategori.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endpush

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <div class="card-title">
            <h5>Tambah Kategori</h5>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" id="form-update" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="name">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('email') }}" required>
                @error('name')
                    <span class="invalid-feedback">{{ $error }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="icon">Ikon</label>
                <textarea name="icon" id="icon" class="form-control @error('name') is-invalid @enderror" rows="3">{{ old('icon') }}</textarea>
                @error('icon')
                    <span class="invalid-feedback">{{ $error }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="image">Gambar</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" value="{{ old('email') }}" accept="image/*">
                @error('image')
                    <span class="invalid-feedback">{{ $error }}</span>
                @enderror
                <img id="image-preview" class="img-fluid mt-2" style="display: none;" />
            </div>
            <button type="submit" id="submit-button" class="btn btn-primary">Tambah</button>
            <button type="reset" id="reset-button" class="btn btn-danger">Reset</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Data Kategori</h5>
    </div>
    <div class="card-datatable">
        <table class="table datatable table-responsive" id="datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Ikon</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection