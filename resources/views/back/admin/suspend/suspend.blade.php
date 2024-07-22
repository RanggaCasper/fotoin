@extends('back.layouts.main')

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get_suspend') }}",
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'username', name: 'username' },
                    { data: 'email', name: 'email' },
                    { data: 'note', name: 'note' },
                    { data: 'admin', name: 'admin' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
                ],
                drawCallback: function() {
                    $('[data-bs-toggle="tooltip"]').tooltip();

                    $('.unblock').on('click', function() {
                        var userId = $(this).data('id');
                        console.log(userId);

                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Anda tidak akan dapat mengembalikan ini!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, unblock!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "{{ route('unblock_user') }}",
                                    method: 'DELETE',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        user_id: userId,
                                    },
                                    success: function(response) {
                                        if (response.status) {
                                            Swal.fire(
                                                'Unblocked!',
                                                response.message,
                                                'success'
                                            );
                                            table.ajax.reload();
                                        } else {
                                            Swal.fire(
                                                'Error!',
                                                response.message,
                                                'error'
                                            );
                                        }
                                    },
                                    error: function(xhr) {
                                        Swal.fire(
                                            'Error!',
                                            'Terjadi kesalahan saat memproses permintaan unblock.',
                                            'error'
                                        );
                                    }
                                });
                            }
                        });
                    });
                }
            });
        });
    </script>
@endpush

@section('content')
    <div class="card">
      <div class="card-header">
          <h5>Data Pengguna yang Ditangguhkan</h5>
      </div>
      <div class="card-datatable">
          <table class="table datatable table-responsive" id="datatable">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Username</th>
                      <th>Email</th>
                      <th>Alasan Penangguhan</th>
                      <th>Ditangguhkan Oleh Admin</th>
                      <th>Aksi</th>
                  </tr>
              </thead>
          </table>
      </div>
    </div>
@endsection