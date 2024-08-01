<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>{{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }}  - Marketplace Fotografer Profesional di Bali</title>
    <meta name="description" content="{{ optional(app('web_conf')->where('conf_key', 'web_description')->first())->conf_value }}">
    <meta name="author" content="{{ optional(app('web_conf')->where('conf_key', 'web_author')->first())->conf_value }}">
    <meta name="keywords" content="{{ optional(app('web_conf')->where('conf_key', 'web_keywords')->first())->conf_value }}">
    
    <!-- Open Graph Meta Tags for better social media integration -->
    <meta property="og:title" content="{{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }} - Marketplace Fotografer Profesional di Bali">
    <meta property="og:description" content="{{ optional(app('web_conf')->where('conf_key', 'web_description')->first())->conf_value }}">
    <meta property="og:image" content="{{ optional(app('web_conf')->where('conf_key', 'web_logo')->first())->conf_value }}">
    <meta property="og:url" content="{{ url('') }}">
    <meta property="og:type" content="website">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }} - Marketplace Fotografer Profesional di Bali">
    <meta name="twitter:description" content="{{ optional(app('web_conf')->where('conf_key', 'web_description')->first())->conf_value }}">
    <meta name="twitter:image" content="{{ optional(app('web_conf')->where('conf_key', 'web_logo')->first())->conf_value }}">
    
    <link rel="icon" href="{{ optional(app('web_conf')->where('conf_key', 'web_icon')->first())->conf_value }}" type="image/png">

    @include('front.components.styles')
    <style>
        @media (min-width: 767px) {
            .uniform-size {
                width: 100%;
                height: 175px; 
                object-fit: cover; 
            }

            .slide-images {
                width: 100%;
                height: 175px; 
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        }

        @media (max-width: 767px) {
            .uniform-size {
                width: 100%;
                height: 200px; 
                object-fit: cover; 
            }

            .slide-images {
                width: 100%;
                height: 200px; 
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        }
    </style>
</head>

<body>
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
                                <h1>Temukan freelancer fotografer di {{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }}!</h1>
                                <p>Kualitas foto profesional untuk setiap momen spesial Anda. Pesan sekarang! 📸</p>
                            </div>
                            <div class="banner-form">
                                <form id="searchForm">
                                    <div class="banner-search-list">
                                        <div class="input-block border-0">
                                            <label for="search">Cari Freelance</label>
                                            <input type="text" id="search" name="search" class="form-control" placeholder="Butuh seorang fotografer">
                                        </div>
                                    </div>
                                    <div class="input-block-btn">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-magnifying-glass"></i> Cari
                                        </button>
                                    </div>
                                </form>
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

        <section class="explore-gigs-section" id="main">
            <div class="container">
                <div class="section-head d-flex">
                    <div class="section-header aos" data-aos="fade-up">
                        <h2><span>Jelajahi</span> Katalog Kami.</h2>
                    </div>
                    <div class="section-tab">
                        <ul class="nav nav-pills inner-tab aos" id="pills-tab" role="tablist" data-aos="fade-up">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-random-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-random" type="button" role="tab"
                                    aria-controls="pills-random" aria-selected="false">Random</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-popular-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-popular" type="button" role="tab"
                                    aria-controls="pills-popular" aria-selected="false">Populer</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-rating-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-rating" type="button" role="tab" aria-controls="pills-rating"
                                    aria-selected="false">Rating Terbanyak</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content dashboard-tab">
                    <div class="tab-pane fade show active" id="pills-random" role="tabpanel" aria-labelledby="pills-random-tab">
                        <div class="row aos" data-aos="fade-up" data-aos-delay="500">
                            <div class="col-md-12">
                                <div class="gigs-card-slider owl-carousel">
                                    @foreach ($catalogs->shuffle()->take(10) as $catalog)
                                        <div class="gigs-grid">
                                            <div class="gigs-img">
                                                <div class="img-slider owl-carousel">
                                                    @foreach ($catalog->portofolios as $portofolio)
                                                        <div class="slide-images">
                                                            <a href="{{ route('view-catalog', ['username' => $catalog->user->username, 'slug' => $catalog->slug]) }}">
                                                                @php
                                                                    $fileExtension = pathinfo($portofolio->path_image, PATHINFO_EXTENSION);
                                                                @endphp
                                                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                    <img src="{{ asset('storage/' . $portofolio->path_image) }}" class="img-fluid" alt="img">
                                                                @elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                                                    <video controls class="img-fluid">
                                                                        <source src="{{ asset('storage/' . $portofolio->path_image) }}" type="video/{{ $fileExtension }}">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                @endif
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="fav-selection">
                                                    <a href="javascript:void(0);" data-id="{{ $catalog->id }}" onclick="toggleWishlist({{ $catalog->id }})" class="fav-icon @if($catalog->isInWishlist()) favourite @else @endif"><i class="feather-heart"></i></a>
                                                </div>
                                            </div>
                                            <div class="gigs-content">
                                                <div class="gigs-title">
                                                    <h3>
                                                        <a href="{{ route('view-catalog', ['username' => $catalog->user->username, 'slug' => $catalog->slug]) }}">{{ $catalog->title_name }}</a>
                                                    </h3>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h6 class="d-block m-0 small">{{ number_format($catalog->transactions->where('status', 'COMPLETED')->count(),0,',','.') }} Terjual</h6>
                                                        <div class="star-rate">
                                                            <span><i class="fa-solid fa-star"></i>{{ number_format($catalog->feedback->avg('rate') ?? 0, 1) }} ({{ $catalog->feedback->count() }})</span>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <span class="d-block small">Mulai</span>
                                                        <h6 class="m-0 text-primary">Rp {{ number_format($catalog->packages->min('price'),0,',','.') }}</h6>
                                                    </div>
                                                </div>
                                                <div class="gigs-card-footer">
                                                    <p class="m-0 small"><i class="feather-map-pin me-1"></i>{{ $catalog->user->freelance->provinsi.', '.$catalog->user->freelance->kota }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-popular" role="tabpanel" aria-labelledby="pills-popular-tab">
                        <div class="row aos" data-aos="fade-up" data-aos-delay="500">
                            <div class="col-md-12">
                                <div class="gigs-card-slider owl-carousel">
                                    @php
                                        $popular = $catalogs->sortByDesc(function ($catalog) {
                                            return $catalog->transactions->where('status', 'COMPLETED')->count();
                                        })->take(10);
                                    @endphp

                                    @foreach ($popular as $catalog)
                                        <div class="gigs-grid">
                                            <div class="gigs-img">
                                                <div class="img-slider owl-carousel">
                                                    @foreach ($catalog->portofolios as $portofolio)
                                                        <div class="slide-images">
                                                            <a href="{{ route('view-catalog', ['username' => $catalog->user->username, 'slug' => $catalog->slug]) }}">
                                                                @php
                                                                    $fileExtension = pathinfo($portofolio->path_image, PATHINFO_EXTENSION);
                                                                @endphp
                                                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                    <img src="{{ asset('storage/' . $portofolio->path_image) }}" class="img-fluid" alt="img">
                                                                @elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                                                    <video controls class="img-fluid">
                                                                        <source src="{{ asset('storage/' . $portofolio->path_image) }}" type="video/{{ $fileExtension }}">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                @endif
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="fav-selection">
                                                    <a href="javascript:void(0);" data-id="{{ $catalog->id }}" onclick="toggleWishlist({{ $catalog->id }})" class="fav-icon @if($catalog->isInWishlist()) favourite @else @endif"><i class="feather-heart"></i></a>
                                                </div>
                                            </div>
                                            <div class="gigs-content">
                                                <div class="gigs-title">
                                                    <h3>
                                                        <a href="{{ route('view-catalog', ['username' => $catalog->user->username, 'slug' => $catalog->slug]) }}">{{ $catalog->title_name }}</a>
                                                    </h3>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h6 class="d-block m-0 small">{{ number_format($catalog->transactions->where('status', 'COMPLETED')->count(),0,',','.') }} Terjual</h6>
                                                        <div class="star-rate">
                                                            <span><i class="fa-solid fa-star"></i>{{ number_format($catalog->feedback->avg('rate') ?? 0, 1) }} ({{ $catalog->feedback->count() }})</span>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <span class="d-block small">Mulai</span>
                                                        <h6 class="m-0 text-primary">Rp {{ number_format($catalog->packages->min('price'),0,',','.') }}</h6>
                                                    </div>
                                                </div>
                                                <div class="gigs-card-footer">
                                                    <p class="m-0 small"><i class="feather-map-pin me-1"></i>{{ $catalog->user->freelance->provinsi.', '.$catalog->user->freelance->kota }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-rating" role="tabpanel" aria-labelledby="pills-rating-tab">
                        <div class="row aos" data-aos="fade-up" data-aos-delay="500">
                            <div class="col-md-12">
                                <div class="gigs-card-slider owl-carousel">
                                    @php
                                        $popular = $catalogs->sortByDesc(function ($catalog) {
                                            return $catalog->feedback->count();
                                        })->take(10);
                                    @endphp

                                    @foreach ($popular as $catalog)
                                        <div class="gigs-grid">
                                            <div class="gigs-img">
                                                <div class="img-slider owl-carousel">
                                                    @foreach ($catalog->portofolios as $portofolio)
                                                        <div class="slide-images">
                                                            <a href="{{ route('view-catalog', ['username' => $catalog->user->username, 'slug' => $catalog->slug]) }}">
                                                                @php
                                                                    $fileExtension = pathinfo($portofolio->path_image, PATHINFO_EXTENSION);
                                                                @endphp
                                                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                    <img src="{{ asset('storage/' . $portofolio->path_image) }}" class="img-fluid" alt="img">
                                                                @elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                                                    <video controls class="img-fluid">
                                                                        <source src="{{ asset('storage/' . $portofolio->path_image) }}" type="video/{{ $fileExtension }}">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                @endif
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="fav-selection">
                                                    <a href="javascript:void(0);" data-id="{{ $catalog->id }}" onclick="toggleWishlist({{ $catalog->id }})" class="fav-icon @if($catalog->isInWishlist()) favourite @else @endif"><i class="feather-heart"></i></a>
                                                </div>
                                            </div>
                                            <div class="gigs-content">
                                                <div class="gigs-title">
                                                    <h3>
                                                        <a href="{{ route('view-catalog', ['username' => $catalog->user->username, 'slug' => $catalog->slug]) }}">{{ $catalog->title_name }}</a>
                                                    </h3>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h6 class="d-block m-0 small">{{ number_format($catalog->transactions->where('status', 'COMPLETED')->count(),0,',','.') }} Terjual</h6>
                                                        <div class="star-rate">
                                                            <span><i class="fa-solid fa-star"></i>{{ number_format($catalog->feedback->avg('rate') ?? 0, 1) }} ({{ $catalog->feedback->count() }})</span>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <span class="d-block small">Mulai</span>
                                                        <h6 class="m-0 text-primary">Rp {{ number_format($catalog->packages->min('price'),0,',','.') }}</h6>
                                                    </div>
                                                </div>
                                                <div class="gigs-card-footer">
                                                    <p class="m-0 small"><i class="feather-map-pin me-1"></i>{{ $catalog->user->freelance->provinsi.', '.$catalog->user->freelance->kota }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
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
                                    <a href="{{ route('search', ['search' => $category->name])  }}">
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
                            <a href="#main" class="btn btn-primary">Pesan<i
                                    class="fa-solid fa-caret-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="provide-box">
                            <div class="provide-icon">
                                <img src="asset/img/icons/service-icon.svg" alt="icon">
                            </div>
                            <h3>Daftar Freelance</h3>
                            <p>Menawarkan jasa Anda sebagai freelancer di {{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }} untuk menjangkau calon pembeli.</p>
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
                            <h2><span>Ulasan</span> pelanggan {{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }}.</h2>
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
                        <h2><span>Apa</span> yang membuat {{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }} berbeda?</h2>
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
                                    <p>Freelancer telah melalui proses seleksi dan verifikasi yang ketat di {{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }}, sehingga Anda dapat yakin akan kualitas dan profesionalisme layanan yang mereka tawarkan. </p>
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


        <section class="explore-services-sec" id="faq">
            <div class="section-bg">
                <img src="asset/img/bg/section-bg-06.png" class="explore-bg1" alt="img">
            </div>
            <div class="container">
                <div class="faq-sec">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <div class="faq-heading aos" data-aos="fade-up">
                                <div class="section-header">
                                    <h2><span>Frequently</span> Asked Question’s</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="faq-wrapper faq-lists">
                                <div class="faq-card aos" data-aos="fade-up">
                                    <h4 class="faq-title">
                                        <a class="collapsed" data-bs-toggle="collapse" href="#faqone" aria-expanded="false">Apa itu {{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }}?</a>
                                    </h4>
                                    <div id="faqone" class="card-collapse collapse">
                                        <div class="faq-content">
                                            <p>{{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }} adalah platform marketplace yang mempertemukan klien dengan fotografer profesional di Bali. Kami menyediakan layanan untuk berbagai kebutuhan fotografi, mulai dari acara pernikahan, sesi keluarga, hingga fotografi produk.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="faq-card aos" data-aos="fade-up">
                                    <h4 class="faq-title">
                                        <a class="collapsed" data-bs-toggle="collapse" href="#faqtwo" aria-expanded="false">Bagaimana cara memesan fotografer di {{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }}?</a>
                                    </h4>
                                    <div id="faqtwo" class="card-collapse collapse">
                                        <div class="faq-content">
                                            <p>Untuk memesan fotografer, Anda bisa mengikuti langkah-langkah berikut:
                                                <ol>
                                                    <li>Kunjungi website {{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }}.</li>
                                                    <li>Cari fotografer yang sesuai dengan kebutuhan Anda.</li>
                                                    <li>Pilih fotografer yang diinginkan dan cek ketersediaannya.</li>
                                                    <li>Lakukan pemesanan dan pembayaran melalui platform kami.</li>
                                                    <li>Konfirmasi pemesanan dan nikmati layanan fotografi Anda.</li>
                                                </ol>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="faq-card aos" data-aos="fade-up">
                                    <h4 class="faq-title">
                                        <a class="collapsed" data-bs-toggle="collapse" href="#faqthree" aria-expanded="false">Apakah saya bisa memilih fotografer berdasarkan portofolio?</a>
                                    </h4>
                                    <div id="faqthree" class="card-collapse collapse">
                                        <div class="faq-content">
                                            <p>Ya, Anda bisa melihat portofolio fotografer sebelum memutuskan untuk memesan. Kami menyediakan informasi lengkap tentang karya dan pengalaman fotografer untuk membantu Anda membuat keputusan yang tepat.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="faq-card aos" data-aos="fade-up">
                                    <h4 class="faq-title">
                                        <a class="collapsed" data-bs-toggle="collapse" href="#faqfour" aria-expanded="false">Bagaimana saya bisa membayar layanan fotografi?</a>
                                    </h4>
                                    <div id="faqfour" class="card-collapse collapse">
                                        <div class="faq-content">
                                            <p>Pembayaran dilakukan melalui platform {{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }}. Kami menerima berbagai metode pembayaran, termasuk transfer bank, kartu kredit, dan pembayaran digital.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="faq-card aos" data-aos="fade-up">
                                    <h4 class="faq-title">
                                        <a class="collapsed" data-bs-toggle="collapse" href="#faqeight" aria-expanded="false">Bagaimana cara menjadi fotografer di {{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }}?</a>
                                    </h4>
                                    <div id="faqeight" class="card-collapse collapse">
                                        <div class="faq-content">
                                            <p>Jika Anda seorang fotografer profesional dan ingin bergabung dengan {{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }}, Anda bisa mendaftar melalui halaman "Daftar Fotografer" di website kami. Setelah pendaftaran, tim kami akan melakukan verifikasi dan menghubungi Anda untuk langkah selanjutnya.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="faq-card aos" data-aos="fade-up">
                                    <h4 class="faq-title">
                                        <a class="collapsed" data-bs-toggle="collapse" href="#faqnine" aria-expanded="false">Apakah {{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }} menyediakan layanan edit foto?</a>
                                    </h4>
                                    <div id="faqnine" class="card-collapse collapse">
                                        <div class="faq-content">
                                            <p>Beberapa fotografer di {{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }} menawarkan layanan edit foto sebagai bagian dari paket mereka. Anda bisa memeriksa detail layanan yang disediakan oleh setiap fotografer untuk informasi lebih lanjut.</p>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>


        @include('front.components.footer')


        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>


        <div class="back-to-top">
            <a class="back-to-top-icon align-items-center justify-content-center d-flex" href="#top">
                <i class="fa fa-arrow-up" aria-hidden="true"></i>
            </a>
        </div>

    </div>


    @include('front.components.scripts')
    <script>
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var searchQuery = document.getElementById('search').value;
            if (searchQuery) {
                var url = '{{ route("search", ["search" => "SEARCH_PLACEHOLDER"]) }}';
                url = url.replace('SEARCH_PLACEHOLDER', encodeURIComponent(searchQuery));
                window.location.href = url;
            }
        });

        function toggleWishlist(catalogId) {
            var $icon = $('a.fav-icon[data-id="' + catalogId + '"]');
            var isFavourite = $icon.hasClass('favourite');
            var url = isFavourite ? '{{ route("remove-wishlist") }}' : '{{ route("add-wishlist") }}';

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: catalogId
                },
                success: function(response) {
                    if (response.success) {
                        if (isFavourite) {
                            $icon.removeClass('favourite');
                        } else {
                            $icon.addClass('favourite');
                        }
                    } else {
                        alert('Gagal ' + (isFavourite ? 'menghapus' : 'menambahkan') + ' wishlist');
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 401) {
                        window.location.href = '{{ route("login") }}';
                    } else {
                        alert('Terjadi kesalahan saat ' + (isFavourite ? 'menghapus' : 'menambahkan') + ' wishlist');
                    }
                }
            });
        }
    </script>
</body>
</html>