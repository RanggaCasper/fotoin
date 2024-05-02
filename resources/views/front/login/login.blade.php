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
                        <form action="https://dreamgigs.dreamstechnologies.com/html/template/index.html">
                            <div class="login-userset">
                                <div class="login-logo">
                                    <img src="{{ asset('asset/img/logo.svg') }}" alt="img">
                                </div>
                                <div class="login-card">
                                    <div class="login-heading">
                                        <h3>Hi, Welcome Back!</h3>
                                        <p>Fill the fields to get into your account</p>
                                    </div>
                                    <div class="form-wrap form-focus">
                                        <span class="form-icon">
                                            <i class="feather-mail"></i>
                                        </span>
                                        <input type="email" class="form-control floating">
                                        <label class="focus-label">Email</label>
                                    </div>
                                    <div class="form-wrap form-focus pass-group">
                                        <span class="form-icon">
                                            <i class="toggle-password feather-eye-off"></i>
                                        </span>
                                        <input type="password" class="pass-input form-control  floating">
                                        <label class="focus-label">Password</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-wrap">
                                                <label class="custom_check mb-0">Remember Me
                                                    <input type="checkbox" name="remeber">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-wrap text-md-end">
                                                <a href="forgot-password.html" class="forgot-link">Forgot Password?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-wrap mantadory-info d-none">
                                        <p><i class="feather-alert-triangle"></i>Fill all the fields to submit</p>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Sign In</button>
                                    <div class="login-or">
                                        <span class="span-or">or sign up with</span>
                                    </div>
                                    <ul class="login-social-link">
                                        <li>
                                            <a href="javascript:void(0);">
                                                <img src="{{ asset('asset/img/icons/google-icon.svg') }}" alt="Facebook"> Google
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <img src="{{ asset('asset/img/icons/fb.svg') }}" alt="Google"> Facebook
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="acc-in">
                                    <p>Don’t have an account? <a href="signup.html">Sign Up</a></p>
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