<footer class="footer">
    <div class="section-bg">
        <img src="asset/img/bg/footer-bg-01.png" class="footer-bg-one" alt="img">
        <img src="asset/img/bg/footer-bg-02.png" class="footer-bg-two" alt="img">
    </div>
    <div class="container">
        <div class="footer-top">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="footer-widget">
                        <a href="{{ route('home') }}"> 
                            <img src="{{ optional(app('web_conf')->where('conf_key', 'web_logo')->first())->conf_value }}" height="50" alt="logo">
                        </a>
                        <p>{{ optional(app('web_conf')->where('conf_key', 'web_footer')->first())->conf_value }}</p>
                        <div class="social-links">
                            <ul>
                                <li><a href="javascript:void(0);"><i class="fa-brands fa-facebook"></i></a></li>
                                <li><a href="javascript:void(0);"><i class="fa-brands fa-x-twitter"></i></a>
                                </li>
                                <li><a href="javascript:void(0);"><i class="fa-brands fa-instagram"></i></a>
                                </li>
                                <li><a href="javascript:void(0);"><i class="fa-brands fa-google"></i></a></li>
                                <li><a href="javascript:void(0);"><i class="fa-brands fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="footer-widget">
                        <h3>Menu</h3>
                        <ul class="menu-items">
                            <li><a href="{{ route('home') }}">Beranda</a></li>
                            @auth
                                @if(auth()->user()->role == 'Admin')
                                    <li><a href="{{ route('dashboard-admin') }}">Dashboard</a></li>
                                @elseif(auth()->user()->role == 'Master')
                                    <li><a href="{{ route('dashboard-master') }}">Dashboard</a></li>
                                @elseif(auth()->user()->role == 'Freelance')
                                    <li><a href="{{ route('dashboard-freelance') }}">Dashboard</a></li>
                                @else
                                    <li><a href="{{ route('dashboard_user') }}">Dashboard</a></li>
                                @endif
                            @else
                                <li><a href="{{ route('dashboard_user') }}">Dashboard</a></li>
                            @endauth
                            <li><a href="{{ route('home') }}#kontak">Kontak</a></li>
                            <li><a href="{{ route('home') }}#faq">FAQ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="footer-widget">
                        <h3>Kategori</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="menu-items">
                                    @php
                                        use App\Models\Category;
                                        $categorys = Category::get();
                                        $half = ceil($categorys->count() / 2);
                                    @endphp
                                    @foreach ($categorys->slice(0, $half) as $category)
                                        <li><a href="{{ route('search', ['search' => $category->name]) }}">{{ $category->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="menu-items extra-menu">
                                    @foreach ($categorys->slice($half) as $category)
                                        <li><a href="{{ route('search', ['search' => $category->name]) }}">{{ $category->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-widget" id="kontak">
            <div class="row align-items-center">
                <div class="col-xl-9">
                    <ul class="location-list">
                        <li>
                            <span><i class="feather-map-pin"></i></span>
                            <div class="location-info">
                                <h6>Address</h6>
                                <p>{{ optional(app('web_conf')->where('conf_key', 'web_location')->first())->conf_value }}</p>
                            </div>
                        </li>
                        <li>
                            <span><i class="feather-phone"></i></span>
                            <div class="location-info">
                                <h6>Phone</h6>
                                <p>{{ optional(app('web_conf')->where('conf_key', 'cs_phone')->first())->conf_value }}</p>
                            </div>
                        </li>
                        <li>
                            <span><i class="feather-mail"></i></span>
                            <div class="location-info">
                                <h6>Email</h6>
                                <p>{{ optional(app('web_conf')->where('conf_key', 'cs_email')->first())->conf_value }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="copy-right">
                        <p>Copyright © 2024 DreamGigs. All rights reserved.</p>
                    </div>
                </div>
                {{-- <div class="col-lg-6">
                    <div class="footer-bottom-links">
                        <ul>
                            <li><a href="privacy-policy.html">Privacy Policy</a></li>
                            <li><a href="terms-condition.html">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</footer>