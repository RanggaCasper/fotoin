@extends('front.layouts.panel')

@section('content')
<div class="dashboard-header">
    <div class="main-title">
        <h3>Ulasan Pelanggan</h3>
    </div>
    <div class="head-info">
        <p>Total Ulasan <span class="text-primary">({{ number_format($feedback_count, 0,',','.') }})</span></p>
    </div>
</div>
<div class="user-review">
    <ul class="review-lists">
        @foreach ($feedbacks as $feedback)  
        <li>
            <div class="review-wrap w-100">
                <div>
                    <div class="review-user-info">
                        <div class="review-img">
                            <img src="{{ $feedback->profile_image ? asset($feedback->profile_image) : 'https://caspertopup.com/images/avatars/default.jpg' }}" alt="img">
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
                        <p class="mt-3">#{{ $feedback->transaction->invoice }}</p>
                    </div>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    @if ($feedbacks->hasPages())
        <div class="pagination">
            <ul>
                @if ($feedbacks->onFirstPage())
                @else
                    <li><a href="{{ $feedbacks->previousPageUrl() }}" class="previous"><i class="fa-solid fa-chevron-left"></i></a></li>
                @endif

                @foreach ($feedbacks->links()->elements[0] as $page => $url)
                    @if ($page == $feedbacks->currentPage())
                        <li><a href="javascript:void(0);" class="active">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                @if ($feedbacks->hasMorePages())
                    <li><a href="{{ $feedbacks->nextPageUrl() }}" class="next"><i class="fa-solid fa-chevron-right"></i></a></li>
                @endif
            </ul>
        </div>
    @endif

</div>
@endsection
