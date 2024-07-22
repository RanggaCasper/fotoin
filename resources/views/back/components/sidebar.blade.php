<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link">
        <img src="{{ optional(app('web_conf')->where('conf_key', 'web_logo')->first())->conf_value }}" width="36" alt="Logo">
        <span class="app-brand-text demo menu-text fw-bold">{{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }}</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Page -->
      @if (auth()->user()->role == "Master")  
        <li class="menu-item {{ request()->routeIs('dashboard-master') ? 'active' : '' }}">
          <a href="{{ route('dashboard-master') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div>Dashboard</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('view-admin') ? 'active' : '' }}">
          <a href="{{ route('view-admin') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-user"></i>
            <div>Kelola Admin</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('view-website-conf') ? 'active' : '' }}">
          <a href="{{ route('view-website-conf') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-settings"></i>
            <div>Konfigurasi Website</div>
          </a>
        </li>
      @elseif (auth()->user()->role == "Admin")
      <li class="menu-item {{ request()->routeIs('dashboard-admin') ? 'active' : '' }}">
        <a href="{{ route('dashboard-admin') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-smart-home"></i>
          <div>Dashboard</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('view-kelola-freelance') ? 'active' : '' }}">
        <a href="{{ route('view-kelola-freelance') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-user"></i>
          <div>Kelola Freelance</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('view-validasi-freelance') ? 'active' : '' }}">
        <a href="{{ route('view-validasi-freelance') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-user-check"></i>
          <div>Validasi Freelance</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('view_suspend_request') ? 'active' : '' }}">
        <a href="{{ route('view_suspend_request') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-users-minus"></i>
          <div>Laporan Penanguhan</div>
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('view_suspend') ? 'active' : '' }}">
        <a href="{{ route('view_suspend') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-user-cancel"></i>
          <div>Kelola Penanguhan</div>
        </a>
      </li>
      @endif
    </ul>
  </aside>
  <!-- / Menu -->