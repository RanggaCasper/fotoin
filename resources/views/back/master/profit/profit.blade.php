@extends('back.layouts.main')

@push('scripts')
    <script>
        $(document).ready(function() {
            function fetchProfitData(startDate, endDate) {
                $.get('{{ route('profit_chart') }}', { start_date: startDate, end_date: endDate }, function(data) {
                    let options = {
                        series: [{
                            name: 'Total Profit',
                            data: data
                        }],
                        chart: {
                            height: 350,
                            type: 'line',
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth'
                        },
                        xaxis: {
                            type: 'datetime',
                            categories: data.map(item => item.x),
                            labels: {
                                format: 'yyyy-MM-dd'
                            },
                            title: {
                                text: 'Tanggal'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Total Profit'
                            }
                        },
                        tooltip: {
                            x: {
                                format: 'dd/MM/yy'
                            },
                        }
                    };

                    let chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();
                });
            }

            function fetchTableData(startDate, endDate) {
                $('#datatable').DataTable().destroy();
                $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('get_profit') }}',
                        data: {
                            start_date: startDate,
                            end_date: endDate
                        }
                    },
                    columns: [
                        { data: 'no', name: 'no' },
                        { data: 'profit', name: 'profit' },
                        { data: 'transaction', name: 'transaction' },
                        { data: 'freelance', name: 'freelance' },
                        { data: 'client', name: 'client' },
                        { data: 'created_at', name: 'created_at' },
                    ]
                });
            }

            let endDate = new Date().toISOString().split('T')[0];
            let startDate = new Date();
            startDate.setDate(startDate.getDate() - 29);
            startDate = startDate.toISOString().split('T')[0];

            $('#profit-start-date').val(startDate);
            $('#profit-end-date').val(endDate);

            fetchProfitData(startDate, endDate);
            fetchTableData(startDate, endDate);

            $('#filter-profit-button').click(function() {
                let startDate = $('#profit-start-date').val();
                let endDate = $('#profit-end-date').val();
                fetchProfitData(startDate, endDate);
                fetchTableData(startDate, endDate);
            });
        });
    </script>
@endpush

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <h5>Statistik Profit</h5>
        <div class="row">
            <div class="col-md-5">
                <label for="profit-start-date">Start Date</label>
                <input type="date" id="profit-start-date" class="form-control">
            </div>
            <div class="col-md-5">
                <label for="profit-end-date">End Date</label>
                <input type="date" id="profit-end-date" class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button id="filter-profit-button" class="btn btn-primary col-12">Filter</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="chart"></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>History Profit</h5>
    </div>
    <div class="card-body">
        <table id="datatable" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Profit</th>
                    <th>Invoice</th>
                    <th>Freelance</th>
                    <th>Klien</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
