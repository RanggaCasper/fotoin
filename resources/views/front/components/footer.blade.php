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
                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                    <div class="footer-widget">
                        <h3>Our Company</h3>
                        <ul class="menu-items">
                            <li><a href="about-us.html">About Us</a></li>
                            <li><a href="categories-2.html">Categories</a></li>
                            <li><a href="add-gigs.html">Create Gigs</a></li>
                            <li><a href="pricing.html">Pricing</a></li>
                            <li><a href="faq.html">FAQ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                    <div class="footer-widget">
                        <h3>Dashboard</h3>
                        <ul class="menu-items">
                            <li><a href="user-purchase.html">Purchase</a></li>
                            <li><a href="user-sales.html">Sales</a></li>
                            <li><a href="user-payments.html">Payments</a></li>
                            <li><a href="user-files.html">Files</a></li>
                            <li><a href="user-wishlist.html">Wishlist</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="footer-widget">
                        <h3>Featured Categories</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="menu-items">
                                    <li><a href="categories.html">Programming & Tech</a></li>
                                    <li><a href="categories.html">Music & Audio</a></li>
                                    <li><a href="categories.html">Lifestyle</a></li>
                                    <li><a href="categories.html">Photography</a></li>
                                    <li><a href="categories.html">Business</a></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="menu-items extra-menu">
                                    <li><a href="categories.html">eBook Publishing</a></li>
                                    <li><a href="categories.html">AI Artists</a></li>
                                    <li><a href="categories.html">AI Services</a></li>
                                    <li><a href="categories.html">Data</a></li>
                                    <li><a href="categories.html">Consulting</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
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
                <div class="col-lg-6">
                    <div class="footer-bottom-links">
                        <ul>
                            <li><a href="privacy-policy.html">Privacy Policy</a></li>
                            <li><a href="terms-condition.html">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>