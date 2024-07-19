@extends('front.layouts.main')

@push('styles')
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
@endpush

@push('scripts')
<script>
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var searchQuery = document.getElementById('search').value;
        if (searchQuery) {
            var url = '{{ route("search-catalog", ["search" => "SEARCH_PLACEHOLDER"]) }}';
            url = url.replace('SEARCH_PLACEHOLDER', encodeURIComponent(searchQuery));
            window.location.href = url;
        } else {
            alert('Masukkan kata kunci pencarian.');
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
@endpush

@section('content')

@include('front.components.search')

<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="trend-section">
                    <div class="row align-items-center">
                        <div class="col-sm-10">
                            <h3>Hasil pencarian untuk "{{ $search }}"</h3>
                        </div>
                        <div class="col-sm-2 text-sm-end">
                            <div class="owl-nav trend-nav nav-control nav-top"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="trend-items owl-carousel">
                                @foreach ($categorys as $category)     
                                <div class="trend-box">
                                    <div class="trend-info">
                                        <h6><a href="{{ route('search-category', ['category' => $category->name])  }}">{{ $category->name }}</a></h6>
                                        <p>({{ $category->catalogs_count }} Katalog)</p>
                                    </div>
                                    <a href="{{ route('search-category', ['category' => $category->name])  }}"><i
                                            class="feather-arrow-up-right"></i></a>
                                </div>
                                @endforeach
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="filters-section">
                    <ul class="filters-wrap">
                        <li>
                            <div class="collapse-card">
                                <div class="filter-header">
                                    <a href="javascript:void(0);">
                                        <img src="{{ asset('asset/img/icons/category-icon.svg') }}" alt="icon">Categories
                                    </a>
                                </div>
                                <div id="categories" class="collapse-body">
                                    <div class="form-group search-group">
                                        <span class="search-icon"><i class="feather-search"></i></span>
                                        <input type="text" class="form-control" placeholder="Search Category">
                                    </div>
                                    <ul class="checkbox-list">
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="checked-title">Programming & Coding</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="checked-title">Data Science & Analysis</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="checked-title">Databases </span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="checked-title">Mobile App Development</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="checked-title">Email Template Development</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="checked-title">CMS Development</span>
                                            </label>
                                        </li>
                                        <li>
                                            <div class="view-content">
                                                <div class="viewall-one">
                                                    <ul>
                                                        <li>
                                                            <label class="custom_check">
                                                                <input type="checkbox">
                                                                <span class="checkmark"></span>
                                                                <span class="checked-title">ECommerce CMS
                                                                    Development</span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="custom_check">
                                                                <input type="checkbox">
                                                                <span class="checkmark"></span>
                                                                <span class="checked-title">Programming</span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="view-all">
                                                <a href="javascript:void(0);"
                                                    class="viewall-button-one"><span>More 20+
                                                        Categories</span></a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="filter-btn">
                                        <a href="javascript:void(0);">Reset</a>
                                        <button class="btn btn-primary">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </li>


                        <li>
                            <div class="collapse-card">
                                <div class="filter-header">
                                    <a href="javascript:void(0);">
                                        <img src="{{ asset('asset/img/icons/map-icon.svg') }}" alt="icon">Locations
                                    </a>
                                </div>
                                <div id="locations" class="collapse-body">
                                    <div class="form-group search-group">
                                        <span class="search-icon"><i class="feather-search"></i></span>
                                        <input type="text" class="form-control" placeholder="Search Locations">
                                    </div>
                                    <ul class="checkbox-list">
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="checked-title">Canada</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="checked-title">Bolivia</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="checked-title">Tunsania</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="checked-title">Indonesia</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="checked-title">UK</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="checked-title">UAE</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="checked-title">USA</span>
                                            </label>
                                        </li>
                                        <li>
                                            <div class="view-content">
                                                <div class="viewall-location">
                                                    <ul>
                                                        <li>
                                                            <label class="custom_check">
                                                                <input type="checkbox">
                                                                <span class="checkmark"></span>
                                                                <span class="checked-title">Malaysia</span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="custom_check">
                                                                <input type="checkbox">
                                                                <span class="checkmark"></span>
                                                                <span class="checked-title">Japan</span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="view-all">
                                                <a href="javascript:void(0);"
                                                    class="viewall-btn-location"><span>More 20+
                                                        Locations</span></a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="filter-btn">
                                        <a href="javascript:void(0);">Reset</a>
                                        <button class="btn btn-primary">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="collapse-card">
                                <div class="filter-header">
                                    <a href="javascript:void(0);">
                                        <img src="{{ asset('asset/img/icons/rating-icon.svg') }}" alt="icon">Reviews
                                    </a>
                                </div>
                                <div id="ratings" class="collapse-body">
                                    <ul class="checkbox-list star-rate">
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="ratings">
                                                    <i class="fa-solid fa-star filled"></i>
                                                    <i class="fa-solid fa-star filled"></i>
                                                    <i class="fa-solid fa-star filled"></i>
                                                    <i class="fa-solid fa-star filled"></i>
                                                    <i class="fa-solid fa-star filled"></i>
                                                </span>
                                                <span class="rating-count">(5.0)</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="ratings">
                                                    <i class="fa-solid fa-star filled"></i>
                                                    <i class="fa-solid fa-star filled"></i>
                                                    <i class="fa-solid fa-star filled"></i>
                                                    <i class="fa-solid fa-star filled"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                </span>
                                                <span class="rating-count">(4.0)</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="ratings">
                                                    <i class="fa-solid fa-star filled"></i>
                                                    <i class="fa-solid fa-star filled"></i>
                                                    <i class="fa-solid fa-star filled"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star "></i>
                                                </span>
                                                <span class="rating-count">(3.0)</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="ratings">
                                                    <i class="fa-solid fa-star filled"></i>
                                                    <i class="fa-solid fa-star filled"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                </span>
                                                <span class="rating-count">(2.0)</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_check">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <span class="ratings">
                                                    <i class="fa-solid fa-star filled"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                </span>
                                                <span class="rating-count">(1.0)</span>
                                            </label>
                                        </li>
                                    </ul>
                                    <div class="filter-btn">
                                        <a href="javascript:void(0);">Reset</a>
                                        <button class="btn btn-primary">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="collapse-card">
                                <div class="filter-header">
                                    <a href="javascript:void(0);">
                                        <img src="{{ asset('asset/img/icons/money-icon.svg') }}" alt="icon">Budget
                                    </a>
                                </div>
                                <div id="budget" class="collapse-body">
                                    <div class="form-group">
                                        <input type="text" class="form-control"
                                            placeholder="Enter Custom Budget">
                                    </div>
                                    <ul class="checkbox-list">
                                        <li>
                                            <label class="custom_radio">
                                                <input type="radio" name="budget" checked>
                                                <span class="checkmark"></span><span class="text-dark"> Value
                                                    :</span> Under $4500
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_radio">
                                                <input type="radio" name="budget">
                                                <span class="checkmark"></span><span class="text-dark">
                                                    Mid-range :</span> Under $4500
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_radio">
                                                <input type="radio" name="budget">
                                                <span class="checkmark"></span><span class="text-dark"> High-end
                                                    :</span> Under $4500
                                            </label>
                                        </li>
                                    </ul>
                                    <div class="filter-btn">
                                        <a href="javascript:void(0);">Reset</a>
                                        <button class="btn btn-primary">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="more-content">
                            <div class="collapse-card">
                                <div class="filter-header">
                                    <a href="javascript:void(0);">
                                        <img src="{{ asset('asset/img/icons/user-icon.svg') }}" alt="icon">Seller Details
                                    </a>
                                </div>
                                <div id="seller" class="collapse-body">
                                    <ul class="seller-list">
                                        <li>
                                            <a href="javascript:void(0):">Seller Level<span><i
                                                        class="feather-chevron-right"></i></span></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0):">Seller Availability<span><i
                                                        class="feather-chevron-right"></i></span></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0):">Seller Speaks<span><i
                                                        class="feather-chevron-right"></i></span></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0):">Seller Lives in<span><i
                                                        class="feather-chevron-right"></i></span></a>
                                        </li>
                                    </ul>
                                    <div class="filter-btn">
                                        <a href="javascript:void(0);">Reset</a>
                                        <button class="btn btn-primary">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="more-content">
                            <div class="collapse-card">
                                <div class="filter-header">
                                    <a href="javascript:void(0);">
                                        <img src="{{ asset('asset/img/icons/time-icon.svg') }}" alt="icon">Delivery Time
                                    </a>
                                </div>
                                <div id="deivery" class="collapse-body">
                                    <ul class="checkbox-list">
                                        <li>
                                            <label class="custom_radio">
                                                <input type="radio" name="budget" checked>
                                                <span class="checkmark"></span>Enter 24H
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_radio">
                                                <input type="radio" name="budget">
                                                <span class="checkmark"></span>Upto 3 days
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_radio">
                                                <input type="radio" name="budget">
                                                <span class="checkmark"></span>Upto 7 days
                                            </label>
                                        </li>
                                        <li>
                                            <label class="custom_radio">
                                                <input type="radio" name="budget">
                                                <span class="checkmark"></span>Anytime
                                            </label>
                                        </li>
                                    </ul>
                                    <div class="filter-btn">
                                        <a href="javascript:void(0);">Reset</a>
                                        <button class="btn btn-primary">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="view-all">
                            <a href="javascript:void(0);" class="show-more"><span><img
                                        src="{{ asset('asset/img/icons/add-icon.svg') }}" alt="img"></span><span>Show
                                    More</span></a>
                        </li>
                    </ul>


                    <div class="search-filter-selected float-lg-end">
                        <div class="form-group">
                            <span class="sort-text">Sort By</span>
                            <select class="select">
                                <option>Featured</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                                <option>Recommended</option>
                            </select>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="service-gigs">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        @foreach ($catalogs->shuffle() as $catalog)
                            <div class="col-lg-3 col-md-4">
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
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection