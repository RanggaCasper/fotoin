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
                    <a href="user-dashboard.html" class="active">
                        <img src="asset/img/icons/dashboard-icon-01.svg" class="img-fluid"
                            alt="img">Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('catalog-freelance') }}">
                        <img src="asset/img/icons/dashboard-icon-02.svg" class="img-fluid" alt="img">Manajemen Katalog
                    </a>
                </li>
                <li>
                    <a href="user-purchase.html">
                        <img src="asset/img/icons/dashboard-icon-03.svg" class="img-fluid"
                            alt="img">Purchase
                    </a>
                </li>
                <li>
                    <a href="user-sales.html">
                        <img src="asset/img/icons/dashboard-icon-04.svg" class="img-fluid"
                            alt="img">Sales
                    </a>
                </li>
                <li>
                    <a href="user-files.html">
                        <img src="asset/img/icons/dashboard-icon-05.svg" class="img-fluid"
                            alt="img">Files
                    </a>
                </li>
                <li>
                    <a href="user-reviews.html">
                        <img src="asset/img/icons/dashboard-icon-06.svg" class="img-fluid"
                            alt="img">My Reviews
                    </a>
                </li>
                <li>
                    <a href="user-wishlist.html">
                        <img src="asset/img/icons/dashboard-icon-07.svg" class="img-fluid"
                            alt="img">Wishlist
                    </a>
                </li>
                <li>
                    <a href="user-message.html">
                        <img src="asset/img/icons/dashboard-icon-08.svg" class="img-fluid"
                            alt="img">Messages
                    </a>
                </li>
                <li>
                    <a href="user-wallet.html">
                        <img src="asset/img/icons/dashboard-icon-09.svg" class="img-fluid"
                            alt="img">Wallet
                    </a>
                </li>
                <li>
                    <a href="user-payments.html">
                        <img src="asset/img/icons/dashboard-icon-10.svg" class="img-fluid"
                            alt="img">Payments
                    </a>
                </li>
                <li>
                    <a href="user-settings.html">
                        <img src="asset/img/icons/dashboard-icon-11.svg" class="img-fluid"
                            alt="img">Settings
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>