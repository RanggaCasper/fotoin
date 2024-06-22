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
                                <li><a href="user-dashboard.html">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item"><a href="index.html" class="nav-link">Tentang Kami</a></li>
                    <li class="nav-item"><a href="index.html" class="nav-link">Kontak</a></li>
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
                                    <h6>{{ auth()->user()->username }}</h6>
                                    <p>{{ auth()->user()->role }}</p>
                                </div>
                            </div>
                            <a class="dropdown-item drop-line" href="user-dashboard.html">
                                <img src="{{ asset('asset/img/icons/dashboard-icon-01.svg') }}" class="img-fluid" alt="img">Dashboard
                            </a>
                            <a class="dropdown-item" href="user-purchase.html">
                                <img src="{{ asset('asset/img/icons/dashboard-icon-03.svg') }}" class="img-fluid" alt="img">My
                                Purchase
                            </a>
                            <a class="dropdown-item" href="user-sales.html">
                                <img src="{{ asset('asset/img/icons/dashboard-icon-04.svg') }}" class="img-fluid" alt="img">My
                                Sales
                            </a>
                            <a class="dropdown-item" href="user-wallet.html">
                                <img src="{{ asset('asset/img/icons/dashboard-icon-09.svg') }}" class="img-fluid" alt="img">My
                                Wallet
                            </a>
                            <hr>
                            <a class="dropdown-item" href="user-settings.html">
                                <img src="{{ asset('asset/img/icons/settings-cog.svg') }}" class="img-fluid" alt="img">Settings
                            </a>
                            <a class="dropdown-item" href="user-profile.html">
                                <img src="{{ asset('asset/img/icons/user-cog.svg') }}" class="img-fluid" alt="img">My Profile
                            </a>
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