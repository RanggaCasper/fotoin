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
    $(document).ready(function() {
        function loadCatalog(search) {
            $.ajax({
                url: '{{ route("get_catalog", ["search" => ":search"]) }}'.replace(':search', search),
                type: 'GET',
                success: function(response) {
                    $('#fetch-catalog').html(response);
                    initializeOwlCarousel();
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                }
            });
        }

        function initializeOwlCarousel() {
            $('.img-slider').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                items: 1
            });
        }

        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            var search = $('#search').val();
            loadCatalog(search);
        });

        var initialSearch = $('#search').val();
        if (initialSearch) {
            loadCatalog(initialSearch);
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
                                        <h6><a href="{{ route('search', ['search' => $category->name])  }}">{{ $category->name }}</a></h6>
                                        <p>({{ $category->catalogs_count }} Katalog)</p>
                                    </div>
                                    <a href="{{ route('search', ['search' => $category->name])  }}"><i
                                            class="feather-arrow-up-right"></i></a>
                                </div>
                                @endforeach
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="service-gigs">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row" id="fetch-catalog">
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection