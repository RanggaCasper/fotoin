<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Fotoin - Lupa Password</title>

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
                        <form id="reset-token-form">
                            @csrf
                            <div class="login-userset">
                                <div class="login-logo">
                                    <img src="{{ optional(app('web_conf')->where('conf_key', 'web_logo')->first())->conf_value }}" width="100" alt="img">
                                </div>
                                <div class="login-card">
                                    <div class="login-heading mb-2">
                                        <h3>Hi, Selamat Datang!</h3>
                                        <p>Silakan masukkan alamat email Anda dan kami akan mengirimkan kode untuk mengubah Password Anda.
                                        </p>
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
                                            <i class="feather-mail"></i>
                                        </span>
                                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control floating @error('email') is-invalid @enderror">
                                        <label class="focus-label">Email</label>
                                    </div>
                                
                                    <div class="form-group form-focus gap-0">
                                        <div class="input-group">
                                            <input type="text" name="token" value="{{ old('token') }}" class="form-control @error('token') is-invalid @enderror">
                                            <label class="focus-label">Token</label>
                                            <div class="input-group-append">
                                                <button id="send-token" class="btn btn-primary rounded-start-0">Kirim</button>
                                            </div>
                                        </div>
                                    </div>                                
                                                                      
                                    <div class="form-wrap form-focus pass-group">
                                        <span class="form-icon">
                                            <i class="toggle-password feather-eye-off"></i>
                                        </span>
                                        <input type="password" name="password" class="pass-input form-control floating @error('email') is-invalid @enderror">
                                        <label class="focus-label">Password Baru</label>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Verifikasi</button>
                                </div>
                                <div class="acc-in">
                                    <p>Kehalaman Login? <a href="{{ route('login') }}">Login</a></p>
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
    <script>
        $(document).ready(function() {
            $('#send-token').on('click', function(event) {
                event.preventDefault();

                var button = $(this);
                button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...');

                $.ajax({
                    url: '{{ route("send_reset_token") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: $('#email').val(),
                    },
                    success: function(response) {
                        button.prop('disabled', false).text('Kirim');
                        toastr.success(response.message,'Success!');
                    },
                    error: function(xhr) {
                        button.prop('disabled', false).text('Kirim');
                        var errorMessage = xhr.responseJSON.message || 'Terjadi kesalahan saat mengirim token reset password. Silakan coba lagi.';
                        toastr.error(errorMessage,'Oops!');
                    }
                });
            });

            $('#reset-token-form').on('submit', function(event) {
                event.preventDefault();

                var button = $(this).find('button[type="submit"]');
                button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...');

                $.ajax({
                    url: '{{ route("reset_password") }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        button.prop('disabled', false).text('Verifikasi');
                        if (response.status) {
                            toastr.success(response.message);
                            window.location.href = response.redirect;
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        button.prop('disabled', false).text('Verifikasi');
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                toastr.error(value,'Oops!');
                            });
                        } else {
                            var errorMessage = xhr.responseJSON.message || 'Terjadi kesalahan saat mengubah kata sandi. Silakan coba lagi.';
                            toastr.error(errorMessage,'Oops!');
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>