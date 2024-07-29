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