<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>{{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }}</title>

    <link rel="shortcut icon" href="assets/img/favicon.png">

    @include('front.components.styles')
</head>

<body>

    <div class="main-wrapper">

        @include('front.components.navbar')


        {{-- @include('front.components.breadcrumbs') --}}


        <!-- Content -->
            @yield('content')
        <!-- End Content -->

        @include('front.components.footer')


        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>


        <div class="back-to-top">
            <a class="back-to-top-icon align-items-center justify-content-center d-flex" href="#top">
                <img src="assets/img/icons/arrow-badge-up.svg" alt="img">
            </a>
        </div>

    </div>


    @include('front.components.scripts')
</body>

</html>