@extends('front.layouts.panel')

@push('styles')
    <style>
        @media (min-width: 767px) {
            .uniform-size {
                width: 100%;
                height: 250px; 
                object-fit: cover; 
            }

            .slide-images {
                width: 100%;
                height: 250px; 
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
@endpush

@push('scripts')
    <script>
        if ($(".img-slider").length > 0) {
            $(".img-slider").owlCarousel({
                loop: true,
                margin: 24,
                nav: false,
                dots: true,
                smartSpeed: 2000,
                autoplay: false,
                navText: [
                    '<i class="fa-solid fa-chevron-left"></i>',
                    '<i class="fa-solid fa-chevron-right"></i>',
                ],
                responsive: {
                    0: { items: 1 },
                    550: { items: 1 },
                    768: { items: 1 },
                    1000: { items: 1 },
                },
            });
        }

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
                    alert('Terjadi kesalahan saat ' + (isFavourite ? 'menghapus' : 'menambahkan') + ' wishlist');
                }
            });
        }
        </script>
@endpush

@section('content')
<div class="dashboard-header">
    <div class="main-title">
        <h3>Wishlist</h3>
    </div>
</div>
<div class="row">
    @foreach ($catalogs as $catalog)
        <div class="col-md-6">
            <div class="gigs-grid">
                <div class="gigs-img">
                    <div class="img-slider owl-carousel">
                        @foreach ($catalog->catalog->portofolios as $portofolio)
                            <div class="slide-images">
                                <a href="{{ route('view-catalog', ['username' => $catalog->catalog->user->username, 'slug' => $catalog->catalog->slug]) }}">
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
                        <a href="javascript:void(0);" data-id="{{ $catalog->catalog->id }}" onclick="toggleWishlist({{ $catalog->catalog->id }})" class="fav-icon @if($catalog->catalog->isInWishlist()) favourite @else @endif"><i class="feather-heart"></i></a>
                    </div>
                </div>
                <div class="gigs-content">
                    <div class="gigs-title">
                        <h3>
                            <a href="{{ route('view-catalog', ['username' => $catalog->catalog->user->username, 'slug' => $catalog->catalog->slug]) }}">{{ $catalog->catalog->title_name }}</a>
                        </h3>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="d-block m-0 small">0 Terjual</h6>
                            <div class="star-rate">
                                <span><i class="fa-solid fa-star"></i>5.0 (28)</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="d-block small">Mulai</span>
                            <h6 class="m-0 text-primary">Rp {{ number_format($catalog->catalog->packages->min('price'),0,',','.') }}</h6>
                        </div>
                    </div>
                    <div class="gigs-card-footer">
                        <p class="m-0"><i class="feather-map-pin me-1"></i>Denpasar</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
