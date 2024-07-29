<header class="header">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg header-nav">
            <div class="navbar-header">
                <a id="mobile_btn" href="javascript:void(0);">
                    <span class="bar-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </a>
                <a href="index.html" class="navbar-brand logo">
                    <img src="{{ optional(app('web_conf')->where('conf_key', 'web_logo')->first())->conf_value }}" class="img-fluid" alt="Logo">
                </a>
                <a href="index.html" class="navbar-brand logo-small">
                    <img src="{{ optional(app('web_conf')->where('conf_key', 'web_logo')->first())->conf_value }}" class="img-fluid" alt="Logo">
                </a>
            </div>
            <div class="main-menu-wrapper">
                <div class="menu-header">
                    <a href="index.html" class="menu-logo">
                        <img src="{{ optional(app('web_conf')->where('conf_key', 'web_logo')->first())->conf_value }}" class="img-fluid" alt="Logo">
                    </a>
                    <a id="menu_close" class="menu-close" href="#"> <i class="fas fa-times"></i></a>
                </div>
                <ul class="main-nav navbar-nav">
                    <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Beranda</a></li>
                    <li class="has-submenu">
                        <a href="javascript:void(0);">Kategori <i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                            @php
                                use App\Models\Category;
                                $categorys = Category::get();
                            @endphp
                            @foreach ($categorys as $category)
                                <li><a href="{{ route('search', ['search' => $category->name])  }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @auth    
                        @if(auth()->user()->role == 'Admin')
                            <li><a href="{{ route('dashboard-admin') }}">Dashboard</a></li>
                        @elseif(auth()->user()->role == 'Master')
                            <li><a href="{{ route('dashboard-master') }}">Dashboard</a></li>
                        @elseif(auth()->user()->role == 'Freelance')
                            <li><a href="{{ route('dashboard-freelance') }}">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('dashboard_user') }}">Dashboard</a></li>
                        @endif
                    @else
                        <li><a href="{{ route('dashboard_user') }}">Dashboard</a></li>
                    @endauth
                    <li class="nav-item"><a href="{{ route('home') }}#about" class="nav-link">Tentang Kami</a></li>
                    <li class="nav-item"><a href="{{ route('home') }}#faq" class="nav-link">FAQ</a></li>
                    <li class="nav-item"><a href="{{ route('home') }}#kontak" class="nav-link">Kontak</a></li>
                    @auth
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <li class="nav-item responsive-link"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a></li>
                    @else
                        <li class="nav-item responsive-link"><a href="{{ route('register-freelance') }}" class="nav-link">Daftar Freelancer</a></li>
                        <li class="nav-item responsive-link"><a href="{{ route('login') }}" class="nav-link">Masuk</a></li>
                    @endauth
                </ul>
            </div>
            <ul class="nav header-navbar-rht">
                @auth
                    <li class="nav-item dropdowns has-arrow logged-item">
                        <a href="#" class="nav-link toggle">
                            <span class="log-user dropdown-toggle">
                                <span class="users-img">
                                    <img class="rounded-circle" src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) : 'https://caspertopup.com/images/avatars/default.jpg' }}" alt="Profile">
                                </span>
                                <span class="user-text">{{ auth()->user()->username }}</span>
                            </span>
                        </a>
                        <div class="dropdown-menu list-group">
                            <div class="user-item">
                                <img src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) : 'https://caspertopup.com/images/avatars/default.jpg' }}" alt="Profile">
                                <div class="user-name">
                                    <h6>{{ auth()->user()->fullname }}</h6>
                                    <p>{{ auth()->user()->username }}</p>
                                </div>
                            </div>
                            @if (auth()->user()->role === "Freelance")
                                <a class="dropdown-item drop-line" href="{{ route('dashboard-freelance') }}">
                                    <i class="ti ti-home me-2"></i>Dashboard
                                </a>
                                <a class="dropdown-item" href="{{ route('view_message') }}">
                                    <i class="ti ti-message me-2"></i>Message
                                </a>
                                <a class="dropdown-item" href="{{ route('catalog-freelance') }}">
                                    <i class="ti ti-category-2 me-2"></i> Manajemen Katalog
                                </a>
                                <a class="dropdown-item" href="{{ route('view_withdraw_freelance') }}">
                                    <i class="ti ti-credit-card-refund me-2"></i>Penarikan
                                </a>
                                <a class="dropdown-item" href="{{ route('freelance-calendar') }}">
                                    <i class="ti ti-calendar-month me-2"></i>Manajemen Kalender
                                </a>
                                <a class="dropdown-item" href="{{ route('freelance-calendar') }}">
                                    <i class="ti ti-shopping-cart me-2"></i>Manajemen Transaksi
                                </a>
                            @elseif (auth()->user()->role === "User")
                                <a class="dropdown-item drop-line" href="{{ route('dashboard_user') }}">
                                    <i class="ti ti-home me-2"></i>Dashboard
                                </a>
                                <a class="dropdown-item" href="{{ route('view_message') }}">
                                    <i class="ti ti-message me-2"></i>Message
                                </a>
                                <a class="dropdown-item" href="{{ route('view_transaction_user') }}">
                                    <i class="ti ti-shopping-cart me-2"></i>Transaksi
                                </a>
                                <a class="dropdown-item" href="{{ route('view-wishlist') }}">
                                    <i class="ti ti-shopping-cart-heart me-2"></i>Wishlist
                                </a>
                            @endif
                            <hr>
                            <a class="dropdown-item log-out" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <img src="{{ asset('asset/img/icons/logout.svg') }}" class="img-fluid" alt="img">Logout
                            </a>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-secondary" href="{{ route('register-freelance') }}">Daftar Freelancer</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="{{ route('login') }}">Masuk</a>
                    </li>
                @endauth

            </ul>
        </nav>
    </div>
</header>