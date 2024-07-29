<!-- Navbar -->

<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
      <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="ti ti-menu-2 ti-sm"></i>
      </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
      <div class="navbar-nav align-items-center">
        <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
          <i class="ti ti-sm"></i>
        </a>
      </div>

      <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
          <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar avatar-online">
              <img src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) : 'https://caspertopup.com/images/avatars/default.jpg' }}" alt class="h-auto rounded-circle" />
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item" href="#">
                <div class="d-flex">
                  <div class="flex-shrink-0 me-3">
                    <div class="avatar avatar-online">
                      <img src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) : 'https://caspertopup.com/images/avatars/default.jpg' }}" alt class="h-auto rounded-circle" />
                    </div>
                  </div>
                  <div class="flex-grow-1">
                    <span class="fw-semibold d-block">{{ auth()->user()->fullname }}</span>
                    <small class="text-muted">{{ auth()->user()->role }}</small>
                  </div>
                </div>
              </a>
            </li>
            <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="dropdown-item" type="submit">
                  <i class="ti ti-logout me-2 ti-sm"></i>
                  <span class="align-middle">Log Out</span>
                </button>
              </form>
            </li>
          </ul>
        </li>
        <!--/ User -->
      </ul>
    </div>
  </nav>

  <!-- / Navbar -->