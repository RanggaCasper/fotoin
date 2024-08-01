@extends('front.layouts.main')

@section('meta')
<meta name="description" content="{{ $catalog->description }}">
<meta name="author" content="{{ optional(app('web_conf')->where('conf_key', 'web_author')->first())->conf_value }}">
<meta name="keywords" content="{{ optional(app('web_conf')->where('conf_key', 'web_keywords')->first())->conf_value }}">

<meta property="og:title" content="{{ $catalog->title_name }}">
<meta property="og:description" content="{{ $catalog->description }}">
<meta property="og:image" content="{{ Storage::url($catalog->portofolios->first()->path_image) }}">
<meta property="og:url" content="{{ route('view-catalog', ['username' => $catalog->user->username, 'slug' => $catalog->slug]) }}">
<meta property="og:type" content="website">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $catalog->title_name }}">
<meta name="twitter:description" content="{{ $catalog->description }}">
<meta name="twitter:image" content="{{ asset('storage/' . $catalog->portofolios->first()->path_image) }}">
@endsection

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

    $(document).ready(function() {
        var currentUrl = window.location.href;
        $('#shareLink').val(currentUrl);

        $('#copyButton').click(function() {
            var shareLink = $('#shareLink');
            shareLink.select();
            document.execCommand('copy');
            toastr.success('Link berhasil disalin ke clipboard!','Success!');
            $(this).text('Copied!');
        });
    });


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
            const nama_paket = $(event.target).data('name');
            const harga_paket = $(event.target).text().trim();
            
            $('#modal-nama-paket').text(nama_paket);
            $('#modal-harga-paket').text(harga_paket);
            $('#id_paket').val(targetId);
        });

        $('#submit-btn').on('click', function() {
            $('#submit-btn').prop('disabled', true);
            $('#submit-btn').html('<span id="loadingSpinner" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...');

            $.ajax({
                url: '{{ route("create_transaction") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    package_id: $('#id_paket').val(),
                    booked_at: $('#booked_at').val()
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
                    $('#submit-btn').prop('disabled', false).html('Pesan');
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
                        <a href="#" data-bs-toggle="modal" data-bs-target="#shareModal"><span><i class="feather-share-2"></i></span>Bagikan</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Bagikan Katalog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="order-item mb-3">
                    <div class="order-img">
                        <img src="{{ asset('storage/' . $catalog->portofolios->first()->path_image) }}" alt="img">
                    </div>
                    <div class="order-info">
                        <h5>{{ $catalog->title_name }}</h5>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="shareLink" readonly>
                    <button class="btn btn-primary" type="button" id="copyButton">Copy Link</button>
                </div>
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
                                <div class="col-md-10">
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
                                            <img src="{{ Storage::url($feedback->user->profile_image) }}" alt="img">
                                        </div>
                                        <div class="reviewer-info">
                                            <div class="reviewer-loc">
                                                <h6><a href="javascript:void(0);">{{ $feedback->user->fullname }}</a></h6>
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
                                    <button type="button" class="nav-link {{ $index == 0 ? 'active' : '' }}" role="tab" data-bs-toggle="tab" data-name="{{ $package->package_name }}" data-bs-target="#{{ $package->id }}" aria-controls="{{ $package->id }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
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
                    
                    <button type="button" data-bs-toggle="modal" data-bs-target="#order_details" class="btn btn-primary w-100"><i class="feather-shopping-cart"></i> Pesan Sekarang!</button>

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
                            <img src="{{ Storage::url($catalog->user->profile_image) }}" alt="img">
                        </div>
                        <div class="user-info">
                            <h5><span class="me-2">{{ $catalog->user->username }}</span> @if ($catalog->user->isOnline())<span class="badge badge-success"><i class="fa-solid fa-circle"></i> Online</span> @else <span class="badge bg-danger"><i class="fa-solid fa-circle"></i> Offline</span> @endif</h5>
                            <p><i class="fa-solid fa-star"></i>Ratings {{ number_format( min(($feedback->count() > 0 ? $feedback->sum('rate') / $feedback->count() : 0),5),1)}}  ({{ $feedback->count() }} Reviews)</p>
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
                    </ul>
                    <div class="about-me">
                        <h6>Tentang Saya</h6>
                        <p>{{ $catalog->user->freelance->about }}</p>
                    </div>
                    <a href="{{ route('view_message') }}?id={{ $catalog->user->id }}&text=Hallo Saya Tertarik Dengan : {{ $catalog->title_name   }}"
                        class="btn btn-primary mb-0 w-100 mb-3"><i class="ti ti-message"></i>Chat Freelance</a>
                    <a href="{{ route('view_calendar', ['user' => $catalog->user->username]) }}"
                        class="btn btn-primary mb-0 w-100"><i class="ti ti-calendar-week"></i>Lihat Activity</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal new-modal fade" id="order_details" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body service-modal">
                <div class="row">
                    <div class="col-md-12">
                        <div class="order-status">
                            <div class="order-item">
                                <div class="order-img">
                                    <img src="{{ asset('storage/' . $catalog->portofolios->first()->path_image) }}" alt="img">
                                </div>
                                <div class="order-info">
                                    <h5>{{ $catalog->title_name }}</h5>
                                </div>
                            </div>
                            <h6 class="title">Freelance</h6>
                            <div class="user-details">
                                <div class="user-img">
                                    <img src="{{ Storage::url($catalog->user->profile_image) }}" alt="img">
                                </div>
                                <div class="user-info">
                                    <h5>{{ $catalog->user->username }}<span class="location">{{ $catalog->user->freelance->provinsi.', '.$catalog->user->freelance->kota }}</span></h5>
                                    <p><i class="fa-solid fa-star"></i>Ratings {{ number_format( min(($feedback->count() > 0 ? $feedback->sum('rate') / $feedback->count() : 0),5),1)}} ({{ $catalog->feedback->count() }} Reviews)</p>
                                </div>
                            </div>
                            <div class="detail-table table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Paket</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="modal-nama-paket">{{ $catalog->packages->sortBy('price')->first()->package_name }}</td>
                                            <td class="text-primary" id="modal-harga-paket">Rp. {{ number_format($catalog->packages->sortBy('price')->first()->price,0,',','.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <input type="number" id="id_paket" value="{{ $catalog->packages->sortBy('price')->first()->id }}" hidden>
                            <label for="booked_at">Waktu Booking</label>
                            <input type="datetime-local" id="booked_at" class="form-control mb-3">
                            <div class="modal-btn">
                                <div class="row gx-2">
                                    <div class="col-6">
                                        <a href="#" data-bs-dismiss="modal"
                                            class="btn btn-secondary w-100 justify-content-center">Tutup</a>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" id="submit-btn" class="btn btn-primary w-100">Pesan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection