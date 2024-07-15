@extends('front.layouts.panel')

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

    </script>
@endpush

@section('content')
<div class="dashboard-header">
    <div class="main-title">
        <h3>Manajemen Katalog</h3>
    </div>
    <div class="head-info">
        <a href="{{ route('create-catalog-freelance') }}" class="btn btn-primary">Tambah Katalog</a>
    </div>
</div>
<div class="row">
    @foreach ($catalogs as $catalog)
    <div class="col-lg-4">
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
            </div>
            <div class="gigs-content">
                <div class="gigs-title">
                    <h3>
                        <a href="{{ route('view-catalog', ['username' => $catalog->user->username, 'slug' => $catalog->slug]) }}">{{ $catalog->title_name }}</a>
                    </h3>
                </div>
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="d-block m-0 small">0 Terjual</h6>
                        <div class="star-rate">
                            <span><i class="fa-solid fa-star"></i>{{ number_format($catalog->feedback->avg('rate') ?? 0, 1) }} ({{ $catalog->feedback->count() }})</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="d-block small">Mulai</span>
                        <h6 class="m-0 text-primary">Rp {{ number_format($catalog->packages->min('price'),0,',','.') }}</h6>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-end mt-2">
                    <a href="" class="btn btn-sm btn-primary">Edit</a>
                    <form action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus katalog ini?')">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

</div>
@endsection
