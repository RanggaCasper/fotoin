@extends('back.layouts.main')

@push('styles')
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        function fetchData(route, startDate, endDate, chartElement) {
            $.get(route, { start_date: startDate, end_date: endDate }, function(data) {
                const labels = data.map(item => item.x);
                const totals = data.map(item => item.y);

                var options = {
                    series: [{
                        name: chartElement.includes("catalog") ? 'Penambahan Katalog' : 'Total Transaksi',
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
                            text: chartElement.includes("catalog") ? 'Jumlah Penambahan' : 'Jumlah Transaksi'
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

        $('#transaction-start-date').val(startDate);
        $('#transaction-end-date').val(endDate);

        fetchData('{{ route('catalog_chart') }}', startDate, endDate, "#chart-catalog");
        fetchData('{{ route('transaction_chart') }}', startDate, endDate, "#chart-transaction");

        $('#filter-catalog-button').click(function() {
            fetchData('{{ route('catalog_chart') }}', $('#catalog-start-date').val(), $('#catalog-end-date').val(), "#chart-catalog");
        });

        $('#filter-transaction-button').click(function() {
            fetchData('{{ route('transaction_chart') }}', $('#transaction-start-date').val(), $('#transaction-end-date').val(), "#chart-transaction");
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
                <button id="filter-catalog-button" class="btn btn-primary col-12">Filter</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="chart-catalog"></div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5>Statistik Transaksi</h5>
        <div class="row">
            <div class="col-md-5">
                <label for="transaction-start-date">Start Date</label>
                <input type="date" id="transaction-start-date" class="form-control">
            </div>
            <div class="col-md-5">
                <label for="transaction-end-date">End Date</label>
                <input type="date" id="transaction-end-date" class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button id="filter-transaction-button" class="btn btn-primary col-12">Filter</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="chart-transaction"></div>
    </div>
</div>
@endsection
