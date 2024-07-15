<div class="col-lg-4 col-xl-3 theiaStickySidebar">
    <div class="user-sidebar">
        <div class="user-head">
            <span class="flex-shrink-0">
                <img src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) : 'https://caspertopup.com/images/avatars/default.jpg' }}" class="img-fluid" alt="img">
            </span>
            <div class="user-information">
                <div>
                    <h6>{{ auth()->user()->username }}</h6>
                    <ul>
                        <li>USA</li>
                        <li><i class="fa-solid fa-star"></i> 5.0 (45)</li>
                    </ul>
                </div>
                <a href="#" class="user-edit"><i class="fa-solid fa-user-pen"></i></a>
            </div>
        </div>
        <div class="user-body">
            <ul>
                <li>
                    <a href="{{ route('dashboard-freelance') }}" @class(['active' => request()->routeIs('dashboard-freelance')])>
                        <i class="ti ti-home me-1"></i>Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('catalog-freelance') }}" @class(['active' => request()->routeIs('catalog-freelance')])>
                        <i class="ti ti-category-2 me-1"></i> Manajemen Katalog
                    </a>
                </li>
                <li>
                    <a href="{{ route('view_message') }}">
                        <i class="ti ti-message me-1"></i>Message
                    </a>
                </li>
                <li>
                    <a href="{{ route('freelance-calendar') }}" @class(['active' => request()->routeIs('freelance-calendar')])>
                        <i class="ti ti-calendar-month me-1"></i>Manajemen Kalender
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>