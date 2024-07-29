@extends('back.layouts.main')

@push('scripts')
<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#datatable')) {
            $('#datatable').DataTable().destroy();
        }

        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("get_withdraw_admin") }}',
                data: function (d) {
                    d.status = $('#filterStatus').val();
                    d.user = $('#filterUser').val();
                    d.rekening = $('#filterRekening').val();
                }
            },
            columns: [
                { data: 'no', name: 'no' },
                { data: 'username', name: 'username' },
                { data: 'rekening', name: 'rekening' },
                { data: 'no_rekening', name: 'no_rekening' },
                { data: 'transfer', name: 'transfer' },
                { data: 'fee', name: 'fee' },
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
            },
        });

        $('#filterStatus, #filterUser, #filterRekening').on('keyup change', function() {
            table.draw();
        });

        $('#datatable').on('click', '.approve', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '{{ route("withdraw_approve", '') }}/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                        table.ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error occurred while processing your request.',
                    });
                }
            });
        });

        $('#datatable').on('click', '.reject', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '{{ route("withdraw_reject", '') }}/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                        table.ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error occurred while processing your request.',
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
        <h5>Kelola Penarikan</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="filterStatus">Status</label>
                <select id="filterStatus" class="form-control">
                    <option value="">All</option>
                    <option value="PENDING">PENDING</option>
                    <option value="COMPLETED">COMPLETED</option>
                    <option value="CANCELLED">CANCELLED</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="filterUser">User</label>
                <input type="text" id="filterUser" class="form-control" placeholder="Cari User">
            </div>
            <div class="col-md-4">
                <label for="filterRekening">Rekening</label>
                <input type="text" id="filterRekening" class="form-control" placeholder="Cari Rekening">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table datatable" id="datatable">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Rekening</th>
                        <th>No Rekening</th>
                        <th>Transfer</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th>Tanggal Transaksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
