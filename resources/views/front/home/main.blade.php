<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>DreamGigs</title>

    @include('front.components.styles')
</head>

<body>
    {{-- <div class="loader-main">
        <span class="page-loader"></span>
    </div> --}}

    <div class="main-wrapper">

        @include('front.components.navbar')


        <section class="hero-section">
            <div class="banner-bg-imgs">
                <img src="asset/img/bg/banner-bg-01.png" class="banner-bg-one" alt="img">
                <img src="asset/img/bg/banner-bg-02.png" class="banner-bg-two" alt="img">
                <img src="asset/img/bg/banner-bg-03.png" class="banner-bg-three" alt="img">
                <img src="asset/img/bg/banner-bg-04.png" class="banner-bg-four" alt="img">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="banner-content aos" data-aos="fade-up">
                            <div class="banner-head">
                                <h1>Temukan freelancer fotografer di Fotoin!</h1>
                                <p>Kualitas foto profesional untuk setiap momen spesial Anda. Pesan sekarang! 📸</p>
                            </div>
                            <div class="banner-form">
                                <form action="https://dreamgigs.dreamstechnologies.com/html/template/service.html">
                                    <div class="banner-search-list">
                                        <div class="input-block border-0">
                                            <label>Cari Freelance</label>
                                            <input type="text" class="form-control" placeholder="Butuh seorang fotografer">
                                        </div>
                                    </div>
                                    <div class="input-block-btn">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-magnifying-glass"></i> Cari
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="popular-search">
                                <h5>Popular Searches : </h5>
                                <ul>
                                    <li><a href="service-grid-sidebar.html">Online Mockup</a></li>
                                    <li><a href="service-grid-sidebar.html">Carpentering</a></li>
                                    <li><a href="service-grid-sidebar.html">Event Organiser</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="banner-img">
                            <div class="banner-img-right">
                                <img src="asset/img/banner-img.png" class="img-fluid" alt="img">
                            </div>
                            <img src="asset/img/bg/banner-small-bg-01.svg" class="banner-small-bg-one" alt="img">
                            <img src="asset/img/bg/banner-small-bg-02.png" class="banner-small-bg-two" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="popular-section">
            <div class="popular-img">
                <div class="popular-img-left">
                    <img src="asset/img/bg/banner-bg-04.png" alt="Shape">
                </div>
                <div class="popular-img-right">
                    <img src="asset/img/bg/shape-08.png" alt="Shape">
                </div>
            </div>
            <div class="container">
                <div class="section-header aos" data-aos="fade-up">
                    <h2 class="text-white"><span>Pilih</span> Kategori.</h2>
                </div>
                <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 align-items-center">
                    @foreach ($categorys as $category)    
                        <div class="col d-flex aos" data-aos="fade-up">
                            <div class="category-grid flex-fill">
                                <div class="popular-icon">
                                    <span>
                                        {!! $category->icon !!}
                                    </span>
                                </div>
                                <div class="popular-content">
                                    <h5>{{ $category->name }}</h5>
                                    <p>{{ $category->catalogs_count }}</p>
                                </div>
                                <div class="category-overlay">
                                    <a href="categories.html">
                                        <div class="category-overlay-img">
                                            <img src="{{ url($category->image) }}" class="img-fluid" alt="Service">
                                            <div class="category-overlay-content">
                                                <h5>{{ $category->name }}</h5>
                                                <i class="feather-arrow-up-right"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="provide-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-9">
                        <div class="section-header aos" data-aos="fade-up">
                            <h2><span>Kami</span> disini untuk membantu anda mencari freelance.</h2>
                            <p>Dengan pengalaman luas dalam berbagai tema dan layanan yang komprehensif, termasuk editing dan lainnya.</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="provide-box">
                            <div class="provide-icon">
                                <img src="asset/img/icons/ipad-icon.svg" alt="icon">
                            </div>
                            <h3>Pesan Freelance</h3>
                            <p>Temukan freelancer yang tepat untuk memenuhi kebutuhan Anda sekarang juga!</p>
                            <a href="service.html" class="btn btn-primary">Pesan<i
                                    class="fa-solid fa-caret-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="provide-box">
                            <div class="provide-icon">
                                <img src="asset/img/icons/service-icon.svg" alt="icon">
                            </div>
                            <h3>Daftar Freelance</h3>
                            <p>Menawarkan jasa Anda sebagai freelancer di Fotoin untuk menjangkau calon pembeli.</p>
                            <a href="{{ route('register-freelance') }}" class="btn btn-primary">Daftar<i
                                    class="fa-solid fa-caret-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="testimonial-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-header aos" data-aos="fade-up">
                            <h2><span>Ulasan</span> pelanggan Fotoin.</h2>
                        </div>
                        <div class="testimonial-slider owl-carousel">
                            <div class="testimonial-item aos" data-aos="fade-up">
                                <div class="testimonial-icon">
                                    <img src="asset/img/icons/arrow-icon.svg" alt="icon">
                                </div>
                                <h4>Great Work</h4>
                                <p>“Amazing design, easy to customize and a design quality superlative account on its
                                    cloud platform for the optimized performance. And we didn’t on our original designs
                                    & quality is good.”</p>
                                <div class="star-rate">
                                    <span>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                    </span>
                                </div>
                                <div class="testimonial-user">
                                    <img src="asset/img/user/user-17.jpg" alt="img">
                                    <div class="testimonial-info">
                                        <h6>Gloria Weber</h6>
                                        <p>United States</p>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-item aos" data-aos="fade-up">
                                <div class="testimonial-icon">
                                    <img src="asset/img/icons/arrow-icon.svg" alt="icon">
                                </div>
                                <h4>Seamless Experience</h4>
                                <p>“Communication with the service provider was smooth and efficient through the
                                    platform's messaging system. The built-in tools for file sharing ensuring a
                                    productive experience.”</p>
                                <div class="star-rate">
                                    <span>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                    </span>
                                </div>
                                <div class="testimonial-user">
                                    <img src="asset/img/user/user-18.jpg" alt="img">
                                    <div class="testimonial-info">
                                        <h6>John Cramer</h6>
                                        <p>UK</p>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-item aos" data-aos="fade-up">
                                <div class="testimonial-icon">
                                    <img src="asset/img/icons/arrow-icon.svg" alt="icon">
                                </div>
                                <h4>Great Work</h4>
                                <p>“This service marketplace is a game-changer, delivering a polished professional
                                    platform that exceeded our expectations and it saved us time & resources, allowing
                                    for a quick launch.”</p>
                                <div class="star-rate">
                                    <span>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                    </span>
                                </div>
                                <div class="testimonial-user">
                                    <img src="asset/img/user/user-19.jpg" alt="img">
                                    <div class="testimonial-info">
                                        <h6>Mary Marquez</h6>
                                        <p>United States</p>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-item aos" data-aos="fade-up">
                                <div class="testimonial-icon">
                                    <img src="asset/img/icons/arrow-icon.svg" alt="icon">
                                </div>
                                <h4>Great Effort</h4>
                                <p>“ The built-in tools for file sharing ensuring a productive experience. Communication
                                    with the service provider was smooth & efficient through the platform's messaging
                                    system. ”</p>
                                <div class="star-rate">
                                    <span>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                        <i class="fa-solid fa-star filled"></i>
                                    </span>
                                </div>
                                <div class="testimonial-user">
                                    <img src="asset/img/user/user-16.jpg" alt="img">
                                    <div class="testimonial-info">
                                        <h6>James Don</h6>
                                        <p>Canada</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial-bg">
                <div class="testimonial-bg1">
                    <img src="asset/img/bg/testimonial-bg-01.png" alt="Shape">
                </div>
                <div class="testimonial-bg2">
                    <img src="asset/img/bg/testimonial-bg-02.png" alt="Shape">
                </div>
                <div class="testimonial-bg3">
                    <img src="asset/img/bg/testimonial-bg-03.png" alt="Shape">
                </div>
            </div>
        </section>


        <section class="popular-section expert-section">
            <div class="popular-img">
                <div class="popular-img-left">
                    <img src="asset/img/bg/banner-bg-04.png" alt="Shape">
                </div>
                <div class="popular-img-right">
                    <img src="asset/img/bg/shape-08.png" alt="Shape">
                </div>
            </div>
            <div class="container">
                <div class="expert-header">
                    <div class="section-header aos" data-aos="fade-up">
                        <h2><span>Apa</span> yang membuat Fotoin berbeda?</h2>
                    </div>
                </div>
                <div class="expert-wrapper">
                    <div class="row gx-0 justify-content-center">
                        <div class="col-lg-4 col-md-6 aos" data-aos="fade-up">
                            <div class="expert-item">
                                <div class="expert-icon">
                                    <img src="asset/img/icons/flag-icon.svg" alt="img">
                                </div>
                                <div class="expert-info">
                                    <h4>Freelancer Professional</h4>
                                    <p>Freelancer telah melalui proses seleksi dan verifikasi yang ketat di Fotoin, sehingga Anda dapat yakin akan kualitas dan profesionalisme layanan yang mereka tawarkan. </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 aos" data-aos="fade-up">
                            <div class="expert-item">
                                <div class="expert-icon">
                                    <img src="asset/img/icons/expert-icon.svg" alt="img">
                                </div>
                                <div class="expert-info">
                                    <h4>Keamanan Transaksi</h4>
                                    <p>Kami menjamin keamanan transaksi Anda dengan mengamankan dana Anda hingga proses transaksi selesai.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 aos" data-aos="fade-up">
                            <div class="expert-item">
                                <div class="expert-icon">
                                    <img src="asset/img/icons/users-icon.svg" alt="img">
                                </div>
                                <div class="expert-info">
                                    <h4>Layanan Terpercaya </h4>
                                    <p>Layanan kami didukung oleh kepercayaan dan komitmen untuk memberikan yang terbaik bagi Anda.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="explore-services-sec">
            <div class="section-bg">
                <img src="asset/img/bg/section-bg-06.png" class="explore-bg1" alt="img">
            </div>
            <div class="container">
                <div class="faq-sec">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <div class="faq-heading aos" data-aos="fade-up">
                                <div class="section-header">
                                    <h2><span>Your</span> Frequently Added Question’s</h2>
                                </div>
                                <p>Don’t find the answer? We can help you.</p>
                                <a href="faq.html" class="btn btn-primary">Ask a Question<i
                                        class="fa-solid fa-caret-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="faq-wrapper faq-lists">
                                <div class="faq-card aos" data-aos="fade-up">
                                    <h4 class="faq-title">
                                        <a class="collapsed" data-bs-toggle="collapse" href="#faqone"
                                            aria-expanded="false">What are website development services?</a>
                                    </h4>
                                    <div id="faqone" class="card-collapse collapse">
                                        <div class="faq-content">
                                            <p>Whether you’re looking to launch, update, or overhaul your website, we
                                                offers a talented pool of freelancers who turn ideas into action. From
                                                personal brand pages to eCommerce stores and everything in between,
                                                website development services cover virtually any use case, industry, and
                                                niche. In turn, you can make every digital first impression count.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="faq-card aos" data-aos="fade-up">
                                    <h4 class="faq-title">
                                        <a class="collapsed" data-bs-toggle="collapse" href="#faqtwo"
                                            aria-expanded="false">What are the stages of a project?</a>
                                    </h4>
                                    <div id="faqtwo" class="card-collapse collapse">
                                        <div class="faq-content">
                                            <p>Yes! My service guarantees you 24/7 lifetime support for anything related
                                                to your website. Whenever you encounter a problem, feel free to reach
                                                out to me anytime.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="faq-card aos" data-aos="fade-up">
                                    <h4 class="faq-title">
                                        <a class="collapsed" data-bs-toggle="collapse" href="#faqOne"
                                            aria-expanded="false">What types of service can I pick?</a>
                                    </h4>
                                    <div id="faqOne" class="card-collapse collapse">
                                        <div class="faq-content">
                                            <p>Yes! My service guarantees you 24/7 lifetime support for anything related
                                                to your website. Whenever you encounter a problem, feel free to reach
                                                out to me anytime.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="faq-card aos" data-aos="fade-up">
                                    <h4 class="faq-title">
                                        <a class="collapsed" data-bs-toggle="collapse" href="#faqfour"
                                            aria-expanded="false">How much does it cost to develop a basic projects?</a>
                                    </h4>
                                    <div id="faqfour" class="card-collapse collapse">
                                        <div class="faq-content">
                                            <p>Yes! My service guarantees you 24/7 lifetime support for anything related
                                                to your website. Whenever you encounter a problem, feel free to reach
                                                out to me anytime.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="faq-card aos" data-aos="fade-up">
                                    <h4 class="faq-title">
                                        <a class="collapsed" data-bs-toggle="collapse" href="#faqfive"
                                            aria-expanded="false">What are the most popular development platforms?</a>
                                    </h4>
                                    <div id="faqfive" class="card-collapse collapse">
                                        <div class="faq-content">
                                            <p>Yes! My service guarantees you 24/7 lifetime support for anything related
                                                to your website. Whenever you encounter a problem, feel free to reach
                                                out to me anytime.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <footer class="footer">
            <div class="section-bg">
                <img src="asset/img/bg/footer-bg-01.png" class="footer-bg-one" alt="img">
                <img src="asset/img/bg/footer-bg-02.png" class="footer-bg-two" alt="img">
            </div>
            <div class="container">
                <div class="footer-top">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12" data-aos="fade-up" data-aos-delay="500">
                            <div class="footer-widget">
                                <a href="index.html">
                                    <img src="asset/img/white-logo.svg" alt="logo">
                                </a>
                                <p>Our mission is to lead the way in digital transformation and automation. We aim to
                                    enabling them to navigate the evolving digital landscape with confidence.</p>
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
                        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="600">
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
                        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="800">
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
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="700">
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
                    <div class="contact-widget">
                        <div class="row align-items-center">
                            <div class="col-xl-9">
                                <ul class="location-list">
                                    <li>
                                        <span><i class="feather-map-pin"></i></span>
                                        <div class="location-info">
                                            <h6>Address</h6>
                                            <p>367 Hillcrest Lane, Irvine, California,USA</p>
                                        </div>
                                    </li>
                                    <li>
                                        <span><i class="feather-phone"></i></span>
                                        <div class="location-info">
                                            <h6>Phone</h6>
                                            <p>310-437-2766</p>
                                        </div>
                                    </li>
                                    <li>
                                        <span><i class="feather-mail"></i></span>
                                        <div class="location-info">
                                            <h6>Email</h6>
                                            <p><a href="../../cdn-cgi/l/email-protection.html" class="__cf_email__"
                                                    data-cfemail="543d3a323b14312c35392438317a373b39">[email&#160;protected]</a>
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xl-3 text-xl-end">
                                <div class="paypal-icons">
                                    <a href="javascript:void(0);">
                                        <img src="asset/img/icons/stripe-icon.svg" alt="icon">
                                    </a>
                                    <a href="javascript:void(0);">
                                        <img src="asset/img/icons/paypal-icon.svg" alt="icon">
                                    </a>
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


        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>


        <div class="back-to-top">
            <a class="back-to-top-icon align-items-center justify-content-center d-flex" href="#top">
                <i class="fa fa-arrow-up" aria-hidden="true"></i>
            </a>
        </div>

    </div>


    @include('front.components.scripts')
</body>
</html>