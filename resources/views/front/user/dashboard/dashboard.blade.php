@extends('front.layouts.panel')

@section('content')

    <div class="dashboard-header">
        <div class="main-title">
            <h3>Dashboard</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 d-flex">
            <div class="dash-widget flex-fill">
                <span class="dash-icon bg-primary">
                    <img src="asset/img/icons/check-icon.svg" class="img-fluid" alt="img">
                </span>
                <p>Jumlah Transaksi</p>
                <h3>{{ number_format($transaction->count(),0,',','.') }}</h3>
            </div>
        </div>
    </div>

@endsection
