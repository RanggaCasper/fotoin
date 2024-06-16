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
                    <li class="nav-item"><a href="index.html" class="nav-link">Home</a></li>
                    <li class="has-submenu megamenu">
                        <a href="index.html">Explore <i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu mega-submenu">
                            <li>
                                <div class="megamenu-wrapper">
                                    <div class="row row-cols-xxl-5 row-cols-xl-4 row-cols-lg-3 row-cols-md-1">
                                        <div class="col">
                                            <div class="menu-list">
                                                <div class="menu-heading">
                                                    <span>
                                                        <img src="assets/img/icons/service-02.svg"
                                                            class="img-fluid" alt="img">
                                                    </span>
                                                    <h5>Business</h5>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <h6><a href="categories.html">Finance & Accounting</a>
                                                        </h6>
                                                        <p><a href="categories.html">General Ledger
                                                                Maintenance</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">Consulting</a></h6>
                                                        <p><a href="categories.html">Budgeting and
                                                                Forecasting</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">Legal Services</a></h6>
                                                        <p><a href="categories.html">Tax Compliance and
                                                                Advisory</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">Management &
                                                                Development</a></h6>
                                                        <p><a href="categories.html">Insurance Advisory</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">Corporate Business</a>
                                                        </h6>
                                                        <p><a href="categories.html">Fonts & Typography
                                                                Services</a></p>
                                                    </li>
                                                    <li>
                                                        <a href="service.html" class="more-link">More Services<i
                                                                class="feather-external-link"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="menu-list">
                                                <div class="menu-heading">
                                                    <span>
                                                        <img src="assets/img/icons/service-03.svg"
                                                            class="img-fluid" alt="img">
                                                    </span>
                                                    <h5>Social Media</h5>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <h6><a href="categories.html">Social Media Strategy</a>
                                                        </h6>
                                                        <p><a href="categories.html">Content Creation and
                                                                Scheduling</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">Social Media
                                                                Monitoring</a></h6>
                                                        <p><a href="categories.html">Performance Monitoring</a>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">Social Bookmarking</a>
                                                        </h6>
                                                        <p><a href="categories.html">Assessing Platform
                                                                Effectiveness</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">Social Media Analysis</a>
                                                        </h6>
                                                        <p><a href="categories.html">Data Analysis and
                                                                Reporting</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">Community Management</a>
                                                        </h6>
                                                        <p><a href="categories.html">Community Engagement</a>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <a href="service.html" class="more-link">More Services<i
                                                                class="feather-external-link"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="menu-list">
                                                <div class="menu-heading">
                                                    <span>
                                                        <img src="assets/img/icons/service-04.svg"
                                                            class="img-fluid" alt="img">
                                                    </span>
                                                    <h5>Artificial Intelligence</h5>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <h6><a href="categories.html">AI Applications</a></h6>
                                                        <p><a href="categories.html">Developing Analytics
                                                                Applications</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">AI Websites</a></h6>
                                                        <p><a href="categories.html">AI-Powered Search
                                                                Engines</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">ChatGPT Applications</a>
                                                        </h6>
                                                        <p><a href="categories.html">Virtual Assistance</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">AI Chatbots</a></h6>
                                                        <p><a href="categories.html">Automated Conversations</a>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">AI Agents</a></h6>
                                                        <p><a href="categories.html">Intelligent Digital
                                                                Assistants</a></p>
                                                    </li>
                                                    <li>
                                                        <a href="service.html" class="more-link">More Services<i
                                                                class="feather-external-link"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="menu-list">
                                                <div class="menu-heading">
                                                    <span>
                                                        <img src="assets/img/icons/service-01.svg"
                                                            class="img-fluid" alt="img">
                                                    </span>
                                                    <h5>Music & Audio</h5>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <h6><a href="categories.html">Producers & Composers</a>
                                                        </h6>
                                                        <p><a href="categories.html">Collab with Producers &
                                                                Composers</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">Songwriters</a></h6>
                                                        <p><a href="categories.html">Crafting original and
                                                                compelling lyrics</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">Beat Making</a></h6>
                                                        <p><a href="categories.html">Crafting unique and
                                                                personalized beats</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">Singers & Vocalists</a>
                                                        </h6>
                                                        <p><a href="categories.html">Providing voiceover
                                                                services</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">Session Musicians</a></h6>
                                                        <p><a href="categories.html">Providing professional
                                                                musicians</a></p>
                                                    </li>
                                                    <li>
                                                        <a href="service.html" class="more-link">More Services<i
                                                                class="feather-external-link"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="menu-list">
                                                <div class="menu-heading">
                                                    <span>
                                                        <img src="assets/img/icons/service-05.svg"
                                                            class="img-fluid" alt="img">
                                                    </span>
                                                    <h5>Design</h5>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <h6><a href="categories.html">Logo Design</a></h6>
                                                        <p><a href="categories.html">Stand out with a logo that
                                                                fits brand </a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">Books & Magazines</a></h6>
                                                        <p><a href="categories.html">Books & Magazines
                                                                Services</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">Cards & Stationery</a>
                                                        </h6>
                                                        <p><a href="categories.html">Cards & Stationery
                                                                Services</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">Label & Merchandising</a>
                                                        </h6>
                                                        <p><a href="categories.html">Licensing brand logos and
                                                                designs</a></p>
                                                    </li>
                                                    <li>
                                                        <h6><a href="categories.html">Fonts & Typography</a>
                                                        </h6>
                                                        <p><a href="categories.html">Licensing and customizing
                                                                fonts</a></p>
                                                    </li>
                                                    <li>
                                                        <a href="service.html" class="more-link">More Services<i
                                                                class="feather-external-link"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="javascript:void(0);" class="active">Gigs <i
                                class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                            <li><a href="service.html">Gigs Grid</a></li>
                            <li><a href="service-grid-sidebar.html">Gig Left Sidebar</a></li>
                            <li><a href="service-details.html">Gig Details</a></li>
                            <li><a href="categories.html">Gig Category</a></li>
                            <li><a href="categories-2.html">Gig Category 2</a></li>
                            <li><a href="service-sub-category.html">Gig Subcategory</a></li>
                            <li><a href="add-gigs.html" class="active">Create a Gig</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href>Pages <i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                            <li><a href="about-us.html">About Us</a></li>
                            <li class="has-submenu">
                                <a href="javascript:void(0);">Our Team</a>
                                <ul class="submenu">
                                    <li><a href="team.html">Team Grid</a></li>
                                    <li><a href="team-carousel.html">Team Carousel</a></li>
                                    <li><a href="team-details.html">Team Details</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu">
                                <a href="javascript:void(0);">Authentication</a>
                                <ul class="submenu">
                                    <li><a href="signin.html">Login</a></li>
                                    <li><a href="signup.html">Register</a></li>
                                    <li><a href="forgot-password.html">Forgot Password</a></li>
                                    <li><a href="lock-screen.html">Lock Screen</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu">
                                <a href="javascript:void(0);">Error pages</a>
                                <ul class="submenu">
                                    <li><a href="error-404.html">Error 404</a></li>
                                    <li><a href="error-500.html">Error 500</a></li>
                                </ul>
                            </li>
                            <li><a href="portfolio.html">Portfolio</a></li>
                            <li><a href="pricing.html">Pricing</a></li>
                            <li><a href="under-construction.html">Maintenance</a></li>
                            <li><a href="coming-soon.html">Coming Soon</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="javascript:void(0);">Blog <i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                            <li><a href="blog.html">Blog 3 Grid</a></li>
                            <li><a href="blog-2-grid.html">Blog 2 Grid</a></li>
                            <li><a href="blog-list.html">Blog List</a></li>
                            <li><a href="blog-carousel.html">Blog Carousal</a></li>
                            <li><a href="blog-mansory.html">Blog Mansory</a></li>
                            <li><a href="blog-sidebar.html">Blog Left Sidebar</a></li>
                            <li><a href="blog-right-sidebar.html">Blog Right Sidebar</a></li>
                            <li><a href="blog-details.html">Blog Details</a></li>
                            <li><a href="blog-details-sidebar.html">Blog Details Left Sidebar</a></li>
                            <li><a href="blog-details-right-sidebar.html">Blog Details Right Sidebar</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="javascript:void(0);">User Dashboard <i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                            <li><a href="user-dashboard.html">Dashboard</a></li>
                            <li><a href="user-profile.html">My Profile</a></li>
                            <li><a href="user-gigs.html">Manage Gigs</a></li>
                            <li><a href="user-purchase.html">Purchase</a></li>
                            <li><a href="user-sales.html">Sales</a></li>
                            <li><a href="user-files.html">Files</a></li>
                            <li><a href="user-reviews.html">My Reviews</a></li>
                            <li><a href="user-wishlist.html">Wishlist</a></li>
                            <li><a href="user-message.html">Messages</a></li>
                            <li><a href="user-wallet.html">Wallet</a></li>
                            <li><a href="user-payments.html">Payments</a></li>
                            <li><a href="user-settings.html">Settings</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="javascript:void(0);">Contact <i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                            <li><a href="contact-us.html">Contact V1</a></li>
                            <li><a href="contact-us-v2.html">Contact V2</a></li>
                            <li><a href="contact-us-v3.html">Contact V3</a></li>
                        </ul>
                    </li>
                    <li class="nav-item responsive-link"><a href="signin.html" class="nav-link">Sign In</a></li>
                    <li class="nav-item responsive-link"><a href="signup.html" class="nav-link">Get Started</a>
                    </li>
                </ul>
            </div>
            <ul class="nav header-navbar-rht">

                <li class="nav-item logged-item noti-nav noti-wrapper">
                    <a href="user-notification.html" class="nav-link">
                        <span class="bell-icon"><img src="assets/img/icons/bell-icon.svg" alt="Bell"></span>
                        <span class="badge badge-pill"></span>
                    </a>
                </li>


                <li class="nav-item dropdowns has-arrow logged-item">
                    <a href="#" class="nav-link toggle">
                        <span class="log-user dropdown-toggle">
                            <span class="users-img">
                                <img class="rounded-circle" src="assets/img/user/user-05.jpg" alt="Profile">
                            </span>
                            <span class="user-text">Harry Brooks</span>
                        </span>
                    </a>
                    <div class="dropdown-menu list-group">
                        <div class="user-item">
                            <img src="assets/img/user/user-05.jpg" alt="Profile">
                            <div class="user-name">
                                <h6>Harry Brooks</h6>
                                <p>Joined On : 14 Jan 2024</p>
                            </div>
                        </div>
                        <div class="search-filter-selected select-icon">
                            <div class="form-group">
                                <span class="sort-text"><img src="assets/img/icons/user-cog.svg"
                                        class="img-fluid" alt="img"></span>
                                <select class="select">
                                    <option>Seller</option>
                                    <option>Purchase</option>
                                </select>
                            </div>
                        </div>
                        <a class="dropdown-item drop-line" href="user-dashboard.html">
                            <img src="assets/img/icons/dashboard-icon-01.svg" class="img-fluid"
                                alt="img">Dashboard
                        </a>
                        <a class="dropdown-item" href="user-purchase.html">
                            <img src="assets/img/icons/dashboard-icon-03.svg" class="img-fluid" alt="img">My
                            Purchase
                        </a>
                        <a class="dropdown-item" href="user-sales.html">
                            <img src="assets/img/icons/dashboard-icon-04.svg" class="img-fluid" alt="img">My
                            Sales
                        </a>
                        <a class="dropdown-item" href="user-wallet.html">
                            <img src="assets/img/icons/dashboard-icon-09.svg" class="img-fluid" alt="img">My
                            Wallet
                        </a>
                        <hr>
                        <a class="dropdown-item" href="user-settings.html">
                            <img src="assets/img/icons/settings-cog.svg" class="img-fluid" alt="img">Settings
                        </a>
                        <a class="dropdown-item" href="user-profile.html">
                            <img src="assets/img/icons/user-cog.svg" class="img-fluid" alt="img">My Profile
                        </a>
                        <hr>
                        <a class="dropdown-item log-out" href="index.html">
                            <img src="assets/img/icons/logout.svg" class="img-fluid" alt="img">Logout
                        </a>
                    </div>
                </li>

            </ul>
        </nav>
    </div>
</header>