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
            ajax: '{{ route("get_withdraw_freelance") }}',
            columns: [
                { data: 'no', name: 'no'},
                { data: 'rekening', name: 'rekening'},
                { data: 'no_rekening', name: 'no_rekening'},
                { data: 'transfer', name: 'transfer'},
                { data: 'fee', name: 'fee'},
                { data: 'status', name: 'status'},
                { data: 'created_at', name: 'created_at'}
            ],
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
            },
        });

        $('#filterStatus').on('change', function() {
            table.column(5).search(this.value).draw();
        });

        $('#tarikSaldoBtn').on('click', function() {
            $('#tarikSaldoModal').modal('show');
        });

        $('#tarikSaldoForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('withdraw_balance_freelance') }}', // Pastikan URL ini benar
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message,'Success!');
                        $('#tarikSaldoModal').modal('hide');
                        table.ajax.reload();
                    } else {
                        toastr.error(response.message, 'Oops!');
                    }
                },
                error: function() {
                    toastr.error('Error occurred while processing your request.', 'Oops!');
                }
            });
        });
    });
</script>
@endpush

@section('content')
<div class="dashboard-header">
    <div class="main-title">
        <h3>Penarikan</h3>
    </div>
    <div class="head-info">
        <button id="tarikSaldoBtn" class="btn btn-primary">Tarik Saldo</button>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <div class="card-title">
            <h4>Filter</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="filterStatus">Status</label>
                <select class="form-control" id="filterStatus">
                    <option value="">All</option>
                    <option value="PENDING">PENDING</option>
                    <option value="COMPLETED">COMPLETED</option>
                    <option value="CANCELLED">CANCELLED</option>
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
                <th>Rekening</th>
                <th>No Rekening</th>
                <th>Transfer</th>
                <th>Fee</th>
                <th>Status</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="tarikSaldoModal" tabindex="-1" role="dialog" aria-labelledby="tarikSaldoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tarikSaldoModalLabel">Tarik Saldo</h5>
            </div>
            <form id="tarikSaldoForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rekening">Saldo</label>
                        <input type="text" class="form-control" id="rekening" name="rekening" value="Rp. {{ number_format(auth()->user()->balance,0,',','.') }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="rekening">Rekening</label>
                        <input type="text" class="form-control" id="rekening" name="rekening" value="{{ auth()->user()->freelance->jenis_rekening }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="no_rekening">No Rekening</label>
                        <input type="text" class="form-control" id="no_rekening" name="no_rekening" value="{{ auth()->user()->freelance->no_rekening }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="transfer">Nominal Penarikan</label>
                        <input type="number" class="form-control" id="transfer" name="transfer" required>
                        <div class="mt-3">
                            <p class="small m-0 p-0">Minimal Penarikan Rp. 100.000 dan Maksimal Rp. 25.000.000</p>
                            <p class="small m-0 p-0">Biaya Admin Rp. {{ number_format(optional(app('web_conf')->where('conf_key', 'take_fee_withdraw')->first())->conf_value,0,',','.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
