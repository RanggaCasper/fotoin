@extends('back.layouts.main')

@push('scripts')
    <script>
        $(document).ready(function() {
            
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('get_admin') }}',
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'username', name: 'username' },
                    { data: 'fullname', name: 'fullname' },
                    { data: 'email', name: 'email' },
                    { data: 'no_telp', name: 'no_telp' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });

            $('#form-update').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var action = $(this).attr('action');
                var method = $(this).find('input[name="_method"]').val() || 'POST';

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
                        Swal.fire('Sukses!', response.message, 'success');
                        table.ajax.reload();
                        $('#reset-button').click();
                        $('#update-modal').modal('hide');
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = 'Terjadi kesalahan saat menyimpan data.';

                        if (errors) {
                            var errorText = '';
                            $.each(errors, function(key, value) {
                                errorText += value[0] + '\n';
                            });
                            errorMessage = 'Error:\n' + errorText;
                        }

                        Swal.fire('Error!', errorMessage, 'error');
                    }
                });
            });


            $('#datatable').on('click', '.update', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ route("get_admin_id", ["id" => ":id"]) }}'.replace(':id', id),
                    type: 'GET',
                    success: function(data) {
                        
                        $('#form-update').attr('action', '{{ route("update_admin", ["id" => ":id"]) }}'.replace(':id', id));

                        
                        if ($('input[name="_method"]').length === 0) {
                            $('#form-update').append('<input type="hidden" name="_method" value="PUT">');
                        }

                        
                        $('#username').val(data.username);
                        $('#fullname').val(data.fullname);
                        $('#no_telp').val(data.no_telp);
                        $('#email').val(data.email);

                        $('#submit-button').text('Update');
                    },
                    error: function(xhr) {
                        
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = 'Terjadi kesalahan saat menyimpan data.';

                        if (errors) {
                            var errorText = '';
                            $.each(errors, function(key, value) {
                                errorText += value[0] + '\n';
                            });
                            errorMessage = 'Error:\n' + errorText;
                        }

                        Swal.fire('Error!', errorMessage, 'error');
                    }
                });
            });


            $('#datatable').on('click', '.delete', function() {
                var id = $(this).data('id');
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
                            url: '{{ route("delete_admin", ["id" => ":id"]) }}'.replace(':id', id),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire('Dihapus!', response.message, 'success');
                                table.ajax.reload();
                            },
                            error: function(error) {
                                Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data.', 'error');
                            }
                        });
                    }
                });
            });

            $('#reset-button').on('click', function() {
                $('#form-update').attr('action', '{{ route("create_admin") }}');
                $('#form-update').find('input[name="_method"]').remove();
                $('#username').val('');
                $('#fullname').val('');
                $('#email').val('');
                $('#no_telp').val('');
                $('#password').val('');
                $('#submit-button').text('Tambah');
            });
        });
    </script>
@endpush

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <h5>Tambah Admin</h5>
    </div>
    <div class="card-body">
        <form method="POST" id="form-update">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="username">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{ old('username') }}" required>
                @error('username')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="fullname">Nama Lengkap</label>
                <input type="text" class="form-control @error('fullname') is-invalid @enderror" name="fullname" id="fullname" value="{{ old('fullname') }}" required>
                @error('fullname')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="no_telp">No. Telepon</label>
                <input type="number" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" id="no_telp" value="{{ old('no_telp') }}" required>
                @error('no_telp')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary" id="submit-button">Tambah</button>
            <button type="reset" class="btn btn-secondary" id="reset-button">Reset</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Daftar Admin</h5>
    </div>
    <div class="card-body">
        <table id="datatable" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
