@extends('back.layouts.main')

@push('scripts')
<script>
    $(function() {
        $('#datatable').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: '{{ route('get_data_catalog') }}',
                data: function(d) {
                    d.start_date = $('#catalog-start-date').val();
                    d.end_date = $('#catalog-end-date').val();
                }
            },
            columns: [
                { data: 'no', name: 'no' },
                { data: 'title_name', name: 'title_name' },
                { data: 'freelance', name: 'freelance' },
                { data: 'package', name: 'package' },
                { data: 'count_views', name: 'count_views' },
                { data: 'created_at', name: 'created_at' },
                { data: 'aksi', name: 'aksi' },
            ]
        });
    });

    $(document).ready(function() {
        function fetchData(route, startDate, endDate, chartElement) {
            $.get(route, { start_date: startDate, end_date: endDate }, function(data) {
                const labels = data.map(item => item.x);
                const totals = data.map(item => item.y);

                var options = {
                    series: [{
                        name: 'Penambahan Katalog',
                        data: totals
                    }],
                    chart: {
                        type: 'line',
                        height: 350
                    },
                    xaxis: {
                        type: 'datetime',
                        categories: labels,
                        labels: {
                            format: 'yyyy-MM-dd'
                        },
                        title: {
                            text: 'Tanggal'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Jumlah Penambahan'
                        }
                    },
                    colors: ['#4CAF50'],
                    dataLabels: {
                        enabled: false
                    }
                };

                var chart = new ApexCharts(document.querySelector(chartElement), options);
                chart.render();
            });
        }
        
        let endDate = new Date().toISOString().split('T')[0];
        let startDate = new Date();
        startDate.setDate(startDate.getDate() - 29);
        startDate = startDate.toISOString().split('T')[0];

        $('#catalog-start-date').val(startDate);
        $('#catalog-end-date').val(endDate);

        fetchData('{{ route('catalog_chart') }}', startDate, endDate, "#chart-catalog");

        $('#filter-button').click(function() {
            const startDate = $('#catalog-start-date').val();
            const endDate = $('#catalog-end-date').val();
            $('#datatable').DataTable().ajax.reload();
            fetchData('{{ route('catalog_chart') }}', startDate, endDate, "#chart-catalog");
        });

        $('#download-pdf').click(function() {
            const startDate = $('#catalog-start-date').val();
            const endDate = $('#catalog-end-date').val();
            window.location.href = '{{ route('pdf_data_catalog') }}?start_date=' + startDate + '&end_date=' + endDate;
        });
    });

    $(document).on('click', '.btn-toggle-status', function() {
        var id = $(this).data('id');
        var status = $(this).data('status');
        var token = "{{ csrf_token() }}";

        $.ajax({
            url: "{{ route('toggle_status') }}",
            type: 'POST',
            data: {
                _token: token,
                id: id,
                status: status
            },
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.success,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#datatable').DataTable().ajax.reload();
                    }
                });
            },
            error: function(response) {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while changing the status.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Statistik Katalog</h5>
        <div class="row">
            <div class="col-md-5">
                <label for="catalog-start-date">Start Date</label>
                <input type="date" id="catalog-start-date" class="form-control">
            </div>
            <div class="col-md-5">
                <label for="catalog-end-date">End Date</label>
                <input type="date" id="catalog-end-date" class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button id="filter-button" class="btn btn-primary col-12">Filter</button>
            </div>
        </div>
        <div class="mt-3">
            <button id="download-pdf" class="btn btn-primary">Download PDF</button>
        </div>
    </div>
    <div class="card-body">
        <div id="chart-catalog"></div>
    </div>
</div>
<div class="card mt-3">
    <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
                <span>Jumlah Katalog</span>
                <div class="d-flex align-items-center my-1">
                    <h5 class="mb-0 me-2">{{ number_format($catalog->count(),0,',','.') }}</h5>
                </div>  
            </div>
        </div>
    </div>
</div>
<div class="card mt-3">
    <div class="card-header">
        <h5>Data Katalog</h5>
    </div>
    <div class="card-datatable">
        <table class="table datatable table-responsive" id="datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Katalog</th>
                    <th>Freelance</th>
                    <th>Jumlah Paket</th>
                    <th>Total Pengunjung</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection
