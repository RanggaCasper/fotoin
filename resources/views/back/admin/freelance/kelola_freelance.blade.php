@extends('back.layouts.main')

@push('scripts')
    <script>
        $(function() {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('get-kelola-freelance') }}',
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'username', name: 'username' },
                    { data: 'fullname', name: 'fullname' },
                    { data: 'nik', name: 'nik' },
                    { data: 'aksi', name: 'aksi' },
                ]
            });
        });
        
        $('#datatable').on('click', '.update', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '{{ route("get-admin-id", ["id" => ":id"]) }}'.replace(':id', id),
                type: 'GET',
                success: function(data) {
                    $('#form-update').attr('action', '{{ route("update-admin", ["id" => ":id"]) }}'.replace(':id', id));
                    $('#username_update').val(data.username);
                    $('#fullname_update').val(data.fullname);
                    $('#email_update').val(data.email);
                    $('#no_telp_update').val(data.no_telp);
                },
                error: function(error) {
                    
                }
            });
        });
        
        function hapus(id) {
            Swal.fire({
                title: "Apakah kamu yakin?",
                text: "Kamu tidak akan bisa mengembalikan data yang terhapus!",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Hapus",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("delete-admin", ["id" => ":id"]) }}'.replace(':id', id),
                        type: 'DELETE',
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            }).then((result) => {
                                $('#datatable').DataTable().ajax.reload(null, false);
                            });
                        },
                        error: function(xhr, status, error) {
                            var pesan_error = xhr.responseJSON.message;
                            Swal.fire('Error!', pesan_error, 'error');
                        }
                    });
                }
            });
        }
    </script>
@endpush

@section('content')
    <div class="card">
      <div class="card-header">
          <h5>Data Freelance</h5>
      </div>
      <div class="card-datatable">
          <table class="table datatable table-responsive" id="datatable">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Username</th>
                      <th>Nama Lengkap</th>
                      <th>NIK</th>
                      <th>Aksi</th>
                  </tr>
              </thead>
          </table>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="update-modal" data-bs-backdrop="static" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
          <form class="modal-content" id="form-update" method="POST">
            <div class="modal-header">
              <h5 class="modal-title" id="backDropModalTitle">Edit Admin</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="username_update">Username</label>
                    <input type="text" name="username_update" value="{{ old('username_update') }}" class="form-control @error('username_update') is-invalid @enderror" id="username_update">
                    @error('username_update')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="fullname_update">Nama Lengkap</label>
                    <input type="text" name="fullname_update" value="{{ old('fullname_update') }}" class="form-control @error('fullname_update') is-invalid @enderror" id="fullname_update">
                    @error('fullname_update')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email_update">Email</label>
                    <input type="text" name="email_update" value="{{ old('email_update') }}" class="form-control @error('email_update') is-invalid @enderror" id="email_update">
                    @error('email_update')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="no_telp_update">Nomer Handphone</label>
                    <input type="number" name="no_telp_update" value="{{ old('no_telp_update') }}" class="form-control @error('no_telp_update') is-invalid @enderror" id="no_telp_update">
                    @error('no_telp_update')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_update">Password</label>
                    <input type="password" name="password_update" class="form-control @error('password_update') is-invalid @enderror" id="password_update">
                    @error('password_update')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">
                Close
              </button>
              <button type="submit" class="btn btn-primary waves-effect waves-light">Edit</button>
            </div>
          </form>
        </div>
      </div>
    <!-- End Modal -->
@endsection