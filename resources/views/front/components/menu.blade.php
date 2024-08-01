<div class="col-lg-4 col-xl-3 theiaStickySidebar">
    <div class="user-sidebar">
        <div class="user-head">
            <span class="flex-shrink-0">
                <img src="{{ Storage::url(auth()->user()->profile_image) }}" alt="Profile Image">
            </span>
            <div class="user-information">
                <div>
                    <h6>{{ auth()->user()->fullname }}</h6>
                    <ul>
                        @if(auth()->user()->role === "Freelance")
                            <li>Rp. {{ number_format(auth()->user()->balance, 0,',','.') }}</li>
                        @else
                            <li>{{ auth()->user()->created_at }}</li>
                        @endif
                    </ul>
                </div>
                @if(auth()->user()->role === "Freelance")
                    <a href="{{ route('view_profile_freelance') }}" class="user-edit"><i class="fa-solid fa-user-pen"></i></a>
                @else
                    <a href="{{ route('view_profile_user') }}" class="user-edit"><i class="fa-solid fa-user-pen"></i></a>
                @endif
            </div>
        </div>
        <div class="user-body">
            <ul>
                @auth
                    @if (auth()->user()->role === "Freelance")
                        <li>
                            <a href="{{ route('dashboard-freelance') }}" @class(['active' => request()->routeIs('dashboard-freelance')])>
                                <i class="ti ti-home me-1"></i>Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('view_message') }}">
                                <i class="ti ti-message me-1"></i>Message
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('catalog-freelance') }}" @class(['active' => request()->routeIs('catalog-freelance')])>
                                <i class="ti ti-category-2 me-1"></i> Manajemen Katalog
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('view_withdraw_freelance') }}" @class(['active' => request()->routeIs('view_withdraw_freelance')])>
                                <i class="ti ti-credit-card-refund me-1"></i>Penarikan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('freelance-calendar') }}" @class(['active' => request()->routeIs('freelance-calendar')])>
                                <i class="ti ti-calendar-month me-1"></i>Manajemen Kalender
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('view_transaction_freelance') }}" @class(['active' => request()->routeIs('view_transaction_freelance')])>
                                <i class="ti ti-shopping-cart me-1"></i>Manajemen Transaksi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('view_feedback_freelance') }}" @class(['active' => request()->routeIs('view_feedback_freelance')])>
                                <i class="ti ti-star me-1"></i>Ulasan Pelanggan
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('dashboard_user') }}" @class(['active' => request()->routeIs('dashboard_user')])>
                                <i class="ti ti-home me-1"></i>Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('view_message') }}">
                                <i class="ti ti-message me-1"></i>Message
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('view_transaction_user') }}" @class(['active' => request()->routeIs('view_transaction_user')])>
                                <i class="ti ti-shopping-cart me-1"></i>Manajemen Transaksi
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('view-wishlist') }}" @class(['active' => request()->routeIs('view-wishlist')])>
                            <i class="ti ti-shopping-cart-heart me-1"></i>Wishlist
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ti ti-logout me-1"></i>Keluar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</div>