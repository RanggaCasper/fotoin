@extends('front.layouts.panel')

@section('content')

    <div class="dashboard-header">
        <div class="main-title">
            <h3>Dashboard</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 d-flex">
            <div class="dash-earning flex-fill">
                <div class="earning-info">
                    <p>Saldo</p>
                    <h3>Rp. {{ number_format(auth()->user()->balance,0,'','.') }}</h3>
                    <h6>Saldo yang bisa ditarik.</h6>
                </div>
                <div class="earning-btn">
                    <a href="{{ route('view_withdraw_freelance') }}" class="btn btn-primary">Tarik Saldo</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex">
            <div class="dash-widget flex-fill">
                <span class="dash-icon bg-primary">
                    <i class="ti ti-shopping-cart"></i>
                </span>
                <p>Jumlah Katalog</p>
                <h3>{{ number_format($catalog->count(),0,',','.') }}</h3>
            </div>
        </div>
        <div class="col-md-6 d-flex">
            <div class="dash-widget flex-fill">
                <span class="dash-icon bg-success">
                    <img src="asset/img/icons/check-icon.svg" class="img-fluid" alt="img">
                </span>
                <p>Pesanan Selesai</p>
                <h3>{{ number_format($transaction->where('status','COMPLETED')->count(),0,',','.') }}</h3>
            </div>
        </div>
    </div>

@endsection
