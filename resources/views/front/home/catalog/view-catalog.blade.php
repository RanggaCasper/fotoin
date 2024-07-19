@extends('front.layouts.main')

@push('styles')
    <style>
        @media (max-width: 768px) {
            .service-img-wrap img,
            .service-img-wrap video {
                width: 100%;
                height: 200px;
                object-fit: cover;
            }

            .slider-nav-thumbnails img,
            .slider-nav-thumbnails video {
                width: 100%;
                height: 50px;
                object-fit: cover;
            }
        }

        @media (min-width: 768px) {
            .service-img-wrap img,
            .service-img-wrap video {
                width: 100%;
                height: 400px;
                object-fit: cover;
            }

            .slider-nav-thumbnails img,
            .slider-nav-thumbnails video {
                width: 100%;
                height: 100px;
                object-fit: cover;
            }
        }

    </style>
@endpush

@push('scripts')
<script>
    function toggleWishlist(catalogId, $span) {
        var fav = $span.hasClass('fav');

        $.ajax({
            url: fav ? '{{ route("remove-wishlist") }}' : '{{ route("add-wishlist") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: catalogId
            },
            success: function(response) {
                if(response.success) {
                    if (fav) {
                        $span.removeClass('fav').css({
                            'background': '',
                            'color': ''
                        });
                    } else {
                        $span.addClass('fav').css({
                            'background': 'rgba(255, 105, 0, 1)',
                            'color': '#fff'
                        });
                    }
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 401) {
                    window.location.href = '{{ route("login") }}';
                }
            }
        });
    }



    $(document).ready(function () {
        var serviceSlider = $('.service-slider');
        var sliderNavThumbnails = $('.slider-nav-thumbnails');

        serviceSlider.owlCarousel({
            items: 1,
            margin: 10,
            slideSpeed: 2000,
            nav: true,
            autoplay: false,
            dots: false,
            loop: true,
            smartSpeed: 2000,
            responsiveRefreshRate: 200,
        });

        sliderNavThumbnails.owlCarousel({
            slideSpeed: 2000,
            nav: true,
            autoplay: false,
            dots: false,
            loop: false,
            smartSpeed: 2000,
            responsiveRefreshRate: 200,
            margin: 5,
            responsive: {
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }
        });

        sliderNavThumbnails.on('click', '.owl-item', function () {
            var index = $(this).index();
            serviceSlider.trigger('to.owl.carousel', [index, 2000, true]);
        });

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (event) {
            const targetId = $(event.target).data('bs-target').substring(1); // Remove the leading #
            $('#inp-paket').val(targetId);
        });

        $('#submit-btn').on('click', function() {
            $('#submit-btn').prop('disabled', true);
            $('#submit-btn').html('<span id="loadingSpinner" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...');

            $.ajax({
                url: '{{ route("create_transaction") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    package_id: $('#inp-paket').val()
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success!');
                        window.location.href = response.redirect_url;
                    } else {
                        toastr.error(response.message,'Oops!');
                    }
                },
                error: function(xhr) {
                    toastr.error('Gagal membuat transaksi.','Oops!');
                },
                complete: function() {
                    $('#submit-btn').prop('disabled', false).html('<i class="feather-shopping-cart"></i> Pesan Sekarang!');
                }
            });
        });
    });

    if ($(window).width() > 767) {
        if ($(".theiaStickySidebar").length > 0) {
            $(".theiaStickySidebar").theiaStickySidebar({
                additionalMarginTop: 30,
            });
        }
    }
</script>

@endpush

@section('content')
<div class="breadcrumb-bar breadcrumb-bar-info breadcrumb-info">
    <div class="breadcrumb-img">
        <div class="breadcrumb-left">
            <img src="../../asset/img/bg/banner-bg-03.png" alt="img">
        </div>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-12">
                <h2 class="breadcrumb-title">
                    {{ $catalog->title_name }}
                </h2>
                <ul class="info-links">
                    <li>
                        <i class="feather-calendar"></i>{{ $catalog->created_at->diffForHumans() }}
                    </li>
                </ul>
            </div>
            <div class="col-lg-5 col-12">
                <ul class="breadcrumb-links">
                    <li>
                        <a href="javascript:void(0);" onclick="toggleWishlist({{ $catalog->id }}, $(this).find('span'));">
                            <span class="@if($catalog->isInWishlist()) fav @else @endif" @if($catalog->isInWishlist()) style="background: rgb(255, 105, 0); color: rgb(255, 255, 255);" @else @endif><i class="feather-heart" data-id="{{ $catalog->id }}"></i></span>
                            Wishlist
                        </a>
                    </li>
                    <li>
                        <a href="#"><span><i class="feather-share-2"></i></span>Share this gigs</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-content content">
    <div class="container">
        <div class="row">

            <div class="col-lg-8">

                <div class="slider-card">
                    <div class="owl-carousel service-slider" id="large-img">
                        @foreach ($catalog->portofolios as $portofolio)                            
                            <div class="service-img-wrap">
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
                            </div>
                        @endforeach
                    </div>
                    <div class="owl-carousel slider-nav-thumbnails" id="small-img">
                        @foreach ($catalog->portofolios as $portofolio)                            
                            <div>
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
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="service-wrap">
                    <h3>Deskripsi</h3>
                    <p>{{ $catalog->description }}</p>
                </div>

                <div class="extra-service">
                    <h3>Harga Paket untuk {{ $catalog->title_name }}</h3>
                    <ul class="service-time rounded-lg">
                        @foreach ($catalog->packages->sortBy('price') as $package)    
                        <li>
                            <div class="row align-items-center rounded">
                                <div class="col-md-8">
                                    <div class="delivery-info">
                                        <h5>{{ $package->package_name }}</h5>
                                        <span>{{ $package->description }}</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="delivery-amt">
                                        <h6 class="amt">Rp. {{ number_format($package->price,0,',','.') }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="delivery-add">
                                        <a href="javascript:void(0);" class="btn btn-light-primary add-btn"><i
                                                class="feather-plus-circle"></i> Pesan</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="review-widget">
                    <div class="review-title sort-search-gigs">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <h3>Ulasan ({{ $catalog->feedback->count() }})</h3>
                            </div>
                        </div>
                    </div>
                    <ul class="review-lists">
                        @foreach ($catalog->feedback as $feedback)    
                            <li>
                                <div class="review-wrap">
                                    <div class="review-user-info">
                                        <div class="review-img">
                                            <img src="../../asset/img/user/user-01.jpg" alt="img">
                                        </div>
                                        <div class="reviewer-info">
                                            <div class="reviewer-loc">
                                                <h6><a href="javascript:void(0);">{{ $feedback->user->username }}</a></h6>
                                            </div>
                                            <div class="reviewer-rating">
                                                <div class="star-rate">
                                                    <span class="ratings">
                                                        @for ($i = 0; $i < 5; $i++)
                                                            @if ($i < $feedback->rate)
                                                                <i class="fa-solid fa-star filled"></i>
                                                            @else
                                                                <i class="fa-regular fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </span>
                                                    <span class="rating-count">{{ $feedback->rate }}.0</span>
                                                </div>
                                                <p>{{ $feedback->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-content">
                                        <p>{{ $feedback->feedback }}</p>
                                        <a href="javascript:void(0);" class="reply-btn"><i
                                                class="feather-corner-up-left"></i>Reply</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    {{-- <div class="pagination">
                        <ul>
                            <li>
                                <a href="javascript:void(0);" class="previous"><i class="fa-solid fa-chevron-left"></i></a>
                            </li>
                            @for ($i = 1; $i <= $totalPages; $i++)
                                <li>
                                    <a href="javascript:void(0);" class="{{ $i === $currentPage ? 'active' : '' }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li>
                                <a href="javascript:void(0);" class="next"><i class="fa-solid fa-chevron-right"></i></a>
                            </li>
                        </ul>
                    </div> --}}
                </div>
            </div>


            <div class="col-lg-4 theiaStickySidebar">
                <div class="service-widget">
                    <div class="nav-align-top mb-4">
                        <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                            @foreach ($catalog->packages->sortBy('price') as $index => $package)
                                <li class="nav-item" role="presentation">
                                    <button type="button" class="nav-link {{ $index == 0 ? 'active' : '' }}" role="tab" data-bs-toggle="tab" data-bs-target="#{{ $package->id }}" aria-controls="{{ $package->id }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                        Rp. {{ number_format($package->price,0,',','.') }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach ($catalog->packages->sortBy('price') as $index => $package)
                                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="{{ $package->id }}" role="tabpanel">
                                    <h5 class="m-0">{{ $package->package_name }}</h5>
                                    <p>{{ $package->description }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>                    
                    
                    <input type="number" id="inp-paket" value="{{ $catalog->packages->sortBy('price')->first()->id }}" hidden>
                    <button type="button" id="submit-btn" class="btn btn-primary w-100"><i class="feather-shopping-cart"></i> Pesan Sekarang!</button>

                    <ul class="buy-items">
                        <li>
                            <div class="buy-box">
                                <i class="feather-star"></i>
                                <p>Ratings</p>
                                <h6>{{ number_format($catalog->feedback->avg('rate') ?? 0, 1) }}</h6>
                            </div>
                        </li>
                        <li>
                            <div class="buy-box">
                                <i class="feather-cloud"></i>
                                <p>Total Terjual</p>
                                <h6>{{ number_format($catalog->transactions->where('status', 'COMPLETED')->count(),0,',','.') }}</h6>
                            </div>
                        </li>
                        <li>
                            <div class="buy-box">
                                <i class="feather-eye"></i>
                                <p>Total Dilihat</p>
                                <h6>{{ $catalog->count_views }}</h6>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="service-widget member-widget">
                    <div class="user-details">
                        <div class="user-img">
                            <img src="../../asset/img/user/user-05.jpg" alt="img">
                        </div>
                        <div class="user-info">
                            <h5><span class="me-2">{{ $catalog->user->username }}</span> @if ($catalog->user->isOnline())<span class="badge badge-success"><i class="fa-solid fa-circle"></i> Online</span> @else <span class="badge bg-danger"><i class="fa-solid fa-circle"></i> Offline</span> @endif</h5>
                            <p><i class="fa-solid fa-star"></i>Ratings {{ number_format($catalog->feedback->sum('rate') ?? 0, 1) }} ({{ $catalog->feedback->count() }} Reviews)</p>
                        </div>
                    </div>
                    <ul class="member-info">
                        <li>
                            Dari
                            <span>{{ $catalog->user->freelance->provinsi.', '.$catalog->user->freelance->kota }}</span>
                        </li>
                        <li>
                            Anggota Sejak
                            <span>{{ $catalog->user->freelance->created_at }}</span>
                        </li>
                        <li>
                            Terakhir Login
                            <span>{{ $catalog->user->last_seen }}</span>
                        </li>
                        <li>
                            Rata - Rata Pesan dibalas
                            <span>About 8 hours</span>
                        </li>
                    </ul>
                    <div class="about-me">
                        <h6>Tentang Saya</h6>
                        <p>{{ $catalog->user->freelance->about }}</p>
                    </div>
                    <a href="{{ route('view_message') }}?id={{ $catalog->user->id }}&text=Hallo Saya Tertarik Dengan : {{ $catalog->title_name   }}"
                        class="btn btn-primary mb-0 w-100">Contact Me</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection