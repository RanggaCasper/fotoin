<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>{{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }}</title>

    @yield('meta')

    <link rel="icon" href="{{ optional(app('web_conf')->where('conf_key', 'web_icon')->first())->conf_value }}" type="image/png">

    @include('front.components.styles')
</head>

<body>

    <div class="main-wrapper">

        @include('front.components.navbar')

        <div class="page-content content">
            <div class="container">
                <div class="row">
        
                    @include('front.components.menu')
                    <!-- Content -->
                    <div class="col-xl-9 col-lg-8">
                        @yield('content')
                    </div>
                    <!-- End Content -->
                </div>
            </div>
        </div>

        @include('front.components.footer')


        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>


        <div class="back-to-top">
            <a class="back-to-top-icon align-items-center justify-content-center d-flex" href="#top">
                <img src="{{ asset('asset/img/icons/arrow-badge-up.svg') }}" alt="img">
            </a>
        </div>

    </div>


    @include('front.components.scripts')
</body>

</html>