@extends('front.layouts.panel')

@push('scripts')
<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#datatable')) {
            $('#datatable').DataTable().destroy();
        }
        
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: false,
            responsive: true,
            ajax: '{{ route("get_transaction_freelance") }}',
            columns: [
                { data: 'no', name: 'no'},
                { data: 'invoice', name: 'invoice'},
                { data: 'customer', name: 'customer'},
                { data: 'catalog_name', name: 'catalog_name'},
                { data: 'package_name', name: 'package_name'},
                { data: 'package_price', name: 'package_price'},
                { data: 'status', name: 'status'},
                { data: 'approved', name: 'approved'},
                { data: 'created_at', name: 'created_at'},
                { data: 'aksi', name: 'aksi'},
            ],
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
            },
        });

        $('#filterInvoice').on('keyup change', function() {
            table.column(1).search(this.value).draw();
        });

        $('#filterCustomer').on('keyup change', function() {
            table.column(2).search(this.value).draw();
        });

        $('#filterKatalog').on('keyup change', function() {
            table.column(3).search(this.value).draw();
        });

        $('#filterPaket').on('keyup change', function() {
            table.column(4).search(this.value).draw();
        });

        $('#filterHarga').on('keyup change', function() {
            table.column(5).search(this.value).draw();
        });

        $('#filterStatus').on('change', function() {
            table.column(6).search(this.value).draw();
        });

        $('#filterPersetujuan').on('keyup change', function() {
            table.column(7).search(this.value).draw();
        });

        $('#datatable').on('click', '.check', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '{{ route("approved_transaction_freelance") }}',
                type: 'POST',
                data: {
                    transaction_id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        table.ajax.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(error) {
                    toastr.error('Error occurred while approving the transaction.');
                }
            });
        });
    });

</script>
@endpush

@section('content')
<div class="dashboard-header">
    <div class="main-title">
        <h3>Manajemen Transaksi</h3>
    </div>
    <div class="head-info">
        <a href="{{ route('view_calendar', ['user' => auth()->user()->username]) }}" class="btn btn-primary">Lihat Kalender</a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <div class="card-title">
            <h4>Fillter</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="filterInvoice">Invoice</label>
                <input class="form-control" id="filterInvoice" type="text" placeholder="Search Invoice">
            </div>
            <div class="col-md-3 mb-3">
                <label for="filterCustomer">Customer</label>
                <input class="form-control" id="filterCustomer" type="text" placeholder="Search Customer">
            </div>
            <div class="col-md-3 mb-3">
                <label for="filterKatalog">Katalog</label>
                <input class="form-control" id="filterKatalog" type="text" placeholder="Search Katalog">
            </div>
            <div class="col-md-3 mb-3">
                <label for="filterPaket">Paket</label>
                <input class="form-control" id="filterPaket" type="text" placeholder="Search Paket">
            </div>
            <div class="col-md-3 mb-3">
                <label for="filterHarga">Harga</label>
                <input class="form-control" id="filterHarga" type="text" placeholder="Search Harga">
            </div>
            <div class="col-md-3 mb-3">
                <label for="filterStatus">Status</label>
                <select class="form-control" id="filterStatus">
                    <option value="">All</option>
                    <option value="PENDING">PENDING</option>
                    <option value="COMPLETED">COMPLETED</option>
                    <option value="CANCLED">CANCLED</option>
                    <option value="PROCESSING">PROCESSING</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="filterPersetujuan">Persetujuan</label>
                <select class="form-control" id="filterPersetujuan">
                    <option value="">All</option>
                    <option value="WAITING">WAITING</option>
                    <option value="APPROVED">APPROVED</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped datatable" id="datatable">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Katalog</th>
                <th>Paket</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Persetujuan</th>
                <th>Tanggal Transaksi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection