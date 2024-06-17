@extends('front.layouts.main')

@section('content')
<div class="page-content content">
    <div class="container">
        <div class="row">

            @include('front.components.menu')

            <div class="col-xl-9 col-lg-8">
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
                                <a href="user-wallet.html" class="btn btn-primary">Tarik Saldo</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex">
                        <div class="dash-widget flex-fill">
                            <span class="dash-icon bg-primary">
                                <img src="asset/img/icons/check-icon.svg" class="img-fluid" alt="img">
                            </span>
                            <p>Jumlah Katalog</p>
                            <h3>-</h3>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex">
                        <div class="dash-widget flex-fill">
                            <span class="dash-icon bg-success">
                                <img src="asset/img/icons/check-icon.svg" class="img-fluid" alt="img">
                            </span>
                            <p>Pesanan Selesai</p>
                            <h3>-</h3>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex">
                        <div class="dash-widget flex-fill">
                            <span class="dash-icon bg-info">
                                <i class="feather-credit-card"></i>
                            </span>
                            <p>Transaksi Hari Ini</p>
                            <h3>Rp. -</h3>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex">
                        <div class="dash-widget flex-fill">
                            <span class="dash-icon bg-info">
                                <i class="feather-credit-card"></i>
                            </span>
                            <p>Transaksi Kemarin</p>
                            <h3>Rp. -</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card dashboard-card">
                            <div class="card-header">
                                <div class="gig-card-head">
                                    <h4 class="card-title">Chart</h4>
                                    <ul class="gigs-list nav">
                                        <li><a href="#" data-bs-toggle="tab" data-bs-target="#amount">Amount</a>
                                        </li>
                                        <li><a href="#" class="active" data-bs-toggle="tab"
                                                data-bs-target="#gig">Gigs</a></li>
                                    </ul>
                                </div>
                                <a href="user-sales.html" class="view-link">View All<i
                                        class="feather-arrow-right"></i></a>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade" id="amount">
                                        <div id="amount-chart"></div>
                                    </div>
                                    <div class="tab-pane show active" id="gig">
                                        <div id="purchase-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
