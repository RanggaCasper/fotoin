@extends('front.layouts.main')

@section('content')
    <div class="page-content content">
        <div class="container">
            <div class="dashboard-header">
                <div class="main-title">
                    <h3>Overview</h3>
                </div>
            </div>
        <div class="service-gigs">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        @foreach ($catalogs as $catalog)
                        <div class="col-lg-4 col-md-6">
                            <div class="gigs-grid">
                                <div class="gigs-img">
                                    <div class="img-slider owl-carousel">
                                        @foreach ($catalog->portfolios as $portfolio)
                                            <div class="slide-images">
                                                <a href="service-details.html">
                                                    @php
                                                        $fileExtension = pathinfo($portfolio->path_image, PATHINFO_EXTENSION);
                                                    @endphp
                                                    @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                        <img src="{{ asset('storage/' . $portfolio->path_image) }}" class="img-fluid" alt="img">
                                                    @elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                                        <video controls class="img-fluid">
                                                            <source src="{{ asset('storage/' . $portfolio->path_image) }}" type="video/{{ $fileExtension }}">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    @endif
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="card-overlay-badge">
                                        <a href="service.html"><span class="badge bg-warning"><i class="feather-star"></i>Featured</span></a>
                                        <a href="service.html"><span class="badge bg-danger"><i class="fa-solid fa-meteor"></i>Hot</span></a>
                                    </div>
                                    <div class="fav-selection">
                                        <a href="javascript:void(0);" class="video-icon"><i class="feather-video"></i></a>
                                        <a href="javascript:void(0);" class="fav-icon"><i class="feather-heart"></i></a>
                                    </div>
                                    <div class="user-thumb">
                                        <a href="user-profile.html"><img src="{{ url('asset/img/user/user-01.jpg') }}" alt="img"></a>
                                    </div>
                                </div>
                                <div class="gigs-content">
                                    <div class="gigs-info">
                                        <a href="service-details.html" class="badge bg-primary-light">Website Promotion</a>
                                        <p><i class="feather-map-pin"></i>Newyork</p>
                                    </div>
                                    <div class="gigs-title">
                                        <h3>
                                            <a href="service-details.html">{{ $catalog->title_name }}</a>
                                        </h3>
                                    </div>
                                    <div class="star-rate">
                                        <span><i class="fa-solid fa-star"></i>5.0 (28 Reviews)</span>
                                    </div>
                                    <div class="gigs-card-footer">
                                        <div>
                                            <a href="javascript:void(0);" class="share-icon"><i class="feather-share-2"></i></a>
                                            <span class="badge">Delivery in 1 day</span>
                                        </div>
                                        <h5>$780</h5>
                                    </div>
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
@endsection
