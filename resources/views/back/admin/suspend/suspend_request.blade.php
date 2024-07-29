@extends('back.layouts.main')

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get_suspend_request') }}",
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'reporter', name: 'reporter' },
                    { data: 'reported', name: 'reported' },
                    { data: 'proff', name: 'proff' },
                    { data: 'note', name: 'note' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
                ],
                drawCallback: function() {
                    $('[data-bs-toggle="tooltip"]').tooltip();

                    $('.btn-detail').on('click', function() {
                        var requestId = $(this).data('id');
                    });

                    $('.accept').on('click', function() {
                        var id = $(this).data('id');

                        Swal.fire({
                            title: 'Blokir Pengguna',
                            input: 'textarea',
                            inputLabel: 'Alasan',
                            inputPlaceholder: 'Masukkan alasan blokir pengguna di sini...',
                            inputAttributes: {
                                'aria-label': 'Masukkan alasan blokir pengguna di sini'
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Blokir',
                            cancelButtonText: 'Batal',
                            showLoaderOnConfirm: true,
                            preConfirm: (note) => {
                                return $.ajax({
                                    url: "{{ route('block_user') }}",
                                    method: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        id: id,
                                        note: note,
                                        status: 'ACCEPTED',
                                    },
                                    success: function(response) {
                                        if (response.status) {
                                            Swal.fire(
                                                'Diblokir!',
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
                                            'Terjadi kesalahan saat memproses permintaan blokir.',
                                            'error'
                                        );
                                    }
                                });
                            },
                            allowOutsideClick: () => !Swal.isLoading()
                        });
                    });

                    $('.reject').on('click', function() {
                        var id = $(this).data('id');

                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Anda tidak akan dapat mengembalikan ini!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, tolak!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "{{ route('block_user') }}",
                                    method: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        id: id,
                                        status: 'REJECTED',
                                    },
                                    success: function(response) {
                                        if (response.status) {
                                            Swal.fire(
                                                'Ditolak!',
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
                                            'Terjadi kesalahan saat memproses permintaan.',
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
          <h5>Data Pengguna yang dilaporkan</h5>
      </div>
      <div class="card-datatable">
          <table class="table datatable table-responsive" id="datatable">
              <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Pelapor</th>
                    <th>Nama Terlapor</th>
                    <th>Bukti</th>
                    <th>Alasan Dilaporkan</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                  </tr>
              </thead>
          </table>
      </div>
    </div>
@endsection