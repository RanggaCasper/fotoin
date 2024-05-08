<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Fotoin - Verify Email</title>

    @include('front.components.styles')
</head>

<body>

    <div class="main-wrapper">

        <div class="row gx-0">

            <div class="col-lg-6">
                <div class="authentication-wrapper">
                    <div class="authentication-content">
                        <div class="login-carousel owl-carousel">
                            <div class="login-slider">
                                <img src="{{ asset('asset/img/login-card.png') }}" class="img-fluid" alt="img">
                                <h2>Looking to Buy/Sell a service?</h2>
                                <p>Browse Listing & More 900 Services </p>
                            </div>
                            <div class="login-slider">
                                <img src="{{ asset('asset/img/login-card.png') }}" class="img-fluid" alt="img">
                                <h2>Looking to Buy/Sell a service?</h2>
                                <p>Browse Listing & More 900 Services </p>
                            </div>
                        </div>
                    </div>
                    <div class="login-bg">
                        <img src="{{ asset('asset/img/bg/shape-01.png') }}" alt="img" class="shape-01">
                        <img src="{{ asset('asset/img/bg/shape-02.png') }}" alt="img" class="shape-02">
                        <img src="{{ asset('asset/img/bg/shape-03.png') }}" alt="img" class="shape-03">
                        <img src="{{ asset('asset/img/bg/shape-04.png') }}" alt="img" class="shape-04">
                        <img src="{{ asset('asset/img/bg/shape-05.png') }}" alt="img" class="shape-05">
                        <img src="{{ asset('asset/img/bg/shape-06.png') }}" alt="img" class="shape-06">
                        <img src="{{ asset('asset/img/bg/shape-07.png') }}" alt="img" class="shape-07">
                    </div>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="login-wrapper">
                    <div class="login-content">
                        <form method="POST">
                            @csrf
                            <div class="login-userset">
                                <div class="login-logo">
                                    <img src="{{ asset('asset/img/logo.svg') }}" alt="img">
                                </div>
                                <div class="login-card">
                                    <div class="login-heading mb-2">
                                        <h3>Hi, Selamat Datang!</h3>
                                        <p>Silahkan masukan token yang telah dikirim di email, untuk memverifikasikan akun anda.</p>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger" role="alert">
                                            <ul class="ms-3" style="list-style-type: disc;">
                                                @foreach($errors->all() as $error)
                                                    <li class="small">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if(session('error'))
                                        <div class="alert alert-danger small">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    <div class="form-wrap form-focus">
                                        <span class="form-icon">
                                            <i class="feather-lock"></i>
                                        </span>
                                        <input type="text" name="token" value="{{ old('token') }}" class="form-control floating @error('token') is-invalid @enderror">
                                        <label class="focus-label">Token</label>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Verifikasi</button>
                                </div>
                                <div class="acc-in">
                                    <form id="logout" action="{{ route('logout') }}">
                                        @csrf
                                    </form>
                                    <p>Ganti akun? <a href="#" onclick="event.preventDefault(); document.getElementById('logout').submit();">Ganti</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>


        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>

    </div>

    @include('front.components.scripts')

</body>

</html>