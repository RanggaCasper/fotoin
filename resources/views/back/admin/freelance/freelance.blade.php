@extends('back.layouts.main')

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get_freelance') }}",
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'username', name: 'username' },
                    { data: 'fullname', name: 'fullname' },
                    { data: 'nik', name: 'nik' },
                    { data: 'alamat', name: 'alamat' },
                    { data: 'kode_pos', name: 'kode_pos' },
                    { data: 'provinsi', name: 'provinsi' },
                    { data: 'kota', name: 'kota' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
            });

            // Handle click on Edit button
            $('#datatable').on('click', '.edit', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '/admin/freelance/edit/' + id,
                    type: 'GET',
                    success: function(data) {
                        $('#editModal').modal('show');
                        $('#editForm').attr('action', '/admin/freelance/update/' + id);
                        $('#nik').val(data.nik);
                        $('#about').val(data.about);
                        $('#alamat').val(data.alamat);
                        $('#kode_pos').val(data.kode_pos);
                        $('#provinsi').val(data.provinsi);
                        $('#kota').val(data.kota);
                        $('#kecamatan').val(data.kecamatan);
                        $('#desa').val(data.desa);
                        $('#no_rekening').val(data.no_rekening);
                        $('#jenis_rekening').val(data.jenis_rekening);
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan, silahkan coba lagi.'
                        });
                    }
                });
            });

            // Handle form submission for update
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

            // Handle click on Delete button
            $('#datatable').on('click', '.delete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin ingin menghapus freelance ini?',
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
                            url: '/admin/freelance/delete/' + id,
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
            <h5>Kelola Freelance</h5>
        </div>
        <div class="card-datatable">
            <table class="table datatable table-responsive" id="datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>NIK</th>
                        <th>Alamat</th>
                        <th>Kode Pos</th>
                        <th>Provinsi</th>
                        <th>Kota</th>
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
                        <h5 class="modal-title" id="editModalLabel">Edit Freelance</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="nik">Nomor KTP (NIK)</label>
                            <input type="text" class="form-control" id="nik" name="nik" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="about">Tentang Saya</label>
                            <textarea class="form-control" id="about" name="about" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="alamat">Alamat Lengkap</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="kode_pos">Kode Pos</label>
                            <input type="text" class="form-control" id="kode_pos" name="kode_pos" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="provinsi">Provinsi</label>
                            <input type="text" class="form-control" id="provinsi" name="provinsi" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="kota">Kota</label>
                            <input type="text" class="form-control" id="kota" name="kota" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="kecamatan">Kecamatan</label>
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="desa">Desa</label>
                            <input type="text" class="form-control" id="desa" name="desa" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="no_rekening">Nomor Rekening</label>
                            <input type="text" class="form-control" id="no_rekening" name="no_rekening" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="jenis_rekening">Jenis Rekening</label>
                            <select class="form-control" id="jenis_rekening" name="jenis_rekening" required>
                                <option value="BRI">BRI</option>
                                <option value="BCA">BCA</option>
                                <option value="BPD BALI">BPD BALI</option>
                                <option value="BNI">BNI</option>
                                <option value="Mandiri">Mandiri</option>
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
