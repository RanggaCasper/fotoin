@extends('back.layouts.main')

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get_user') }}",
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'username', name: 'username' },
                    { data: 'fullname', name: 'fullname' },
                    { data: 'email', name: 'email' },
                    { data: 'no_telp', name: 'no_telp' },
                    { data: 'gender', name: 'gender' },
                    { data: 'last_seen', name: 'last_seen' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
            });

            $('#datatable').on('click', '.edit', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '/admin/user/edit/' + id,
                    type: 'GET',
                    success: function(data) {
                        $('#editModal').modal('show');
                        $('#editForm').attr('action', '/admin/user/update/' + id);
                        $('#username').val(data.username);
                        $('#fullname').val(data.fullname);
                        $('#email').val(data.email);
                        $('#no_telp').val(data.no_telp);
                        $('#gender').val(data.gender);
                    },
                    error: function(response) {
                        var errorMessage = response.responseJSON.message || response.responseText;
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errorMessage
                        });
                    }
                });
            });

            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: form.serialize(),
                    success: function(response) {
                        $('#editModal').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                    },
                    error: function(response) {
                        var errorMessage = response.responseJSON.message || response.responseText;
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errorMessage
                        });
                    }
                });
            });

            $('#datatable').on('click', '.delete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin ingin menghapus user ini?',
                    text: "Anda tidak dapat mengembalikan tindakan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/user/delete/' + id,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}',
                            },
                            success: function(response) {
                                table.ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                            },
                            error: function(response) {
                                var errorMessage = response.responseJSON.message || response.responseText;
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: errorMessage
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Kelola User</h5>
        </div>
        <div class="card-datatable">
            <table class="table datatable table-responsive" id="datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Ponsel</th>
                        <th>Kelamin</th>
                        <th>Terakhir Login</th>
                        <th>Bergabung Sejak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="fullname">Nama Lengkap</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="no_telp">Ponsel</label>
                            <input type="text" class="form-control" id="no_telp" name="no_telp" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="gender">Kelamin</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option disabled>-- Pilih Salah Satu --</option>
                                <option value="Laki - Laki">Laki - Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Edit Modal -->
@endsection
