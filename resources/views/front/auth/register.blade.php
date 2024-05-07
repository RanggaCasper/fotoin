<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Fotoin - Login</title>

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
                                        <p>Isi semua kolom untuk daftar akun.</p>
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
                                            <i class="feather-user"></i>
                                        </span>
                                        <input type="username" name="username" value="{{ old('username') }}" class="form-control floating @error('username') is-invalid @enderror">
                                        <label class="focus-label">Username</label>
                                    </div>
                                    <div class="form-wrap form-focus">
                                        <span class="form-icon">
                                            <i class="feather-user"></i>
                                        </span>
                                        <input type="fullname" name="fullname" value="{{ old('fullname') }}" class="form-control floating @error('fullname') is-invalid @enderror">
                                        <label class="focus-label">Nama Lengkap</label>
                                    </div>
                                    <div class="form-wrap form-focus">
                                        <span class="form-icon">
                                            <i class="feather-phone"></i>
                                        </span>
                                        <input type="no_telp" name="no_telp" value="{{ old('no_telp') }}" class="form-control floating @error('no_telp') is-invalid @enderror">
                                        <label class="focus-label">Nomor Handphone</label>
                                    </div>
                                    <div class="form-wrap form-focus">
                                        <span class="form-icon">
                                            <i class="feather-mail"></i>
                                        </span>
                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control floating @error('email') is-invalid @enderror">
                                        <label class="focus-label">Email</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="form-wrap form-focus">
                                                <input type="otp" name="otp" value="{{ old('otp') }}" class="form-control floating @error('otp') is-invalid @enderror">
                                                <label class="focus-label">OTP</label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-primary">Kirim</button>
                                        </div>
                                    </div>
                                    <div class="form-wrap form-focus pass-group">
                                        <span class="form-icon">
                                            <i class="toggle-password feather-eye-off"></i>
                                        </span>
                                        <input type="password" name="password" class="pass-input form-control floating @error('password') is-invalid @enderror">
                                        <label class="focus-label">Password</label>
                                    </div>
                                    <div class="form-wrap form-focus pass-group">
                                        <span class="form-icon">
                                            <i class="toggle-password feather-eye-off"></i>
                                        </span>
                                        <input type="password" name="confirm_password" class="pass-input form-control floating @error('confirm_password') is-invalid @enderror">
                                        <label class="focus-label">Konfirmasi Password</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Daftar</button>
                                </div>
                                <div class="acc-in">
                                    <p>Sudah memiliki akun? <a href="{{ route('login') }}">Masuk</a></p>
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