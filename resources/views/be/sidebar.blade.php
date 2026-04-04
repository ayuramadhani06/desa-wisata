<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion sticky-top" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            Halo {{ ucfirst(auth()->user()->level) }}
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    @if(auth()->user()->level == 'admin')
        <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('admin') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Manajemen Sistem</div>

        <li class="nav-item {{ Request::is('userm*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('userm') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>User Management</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('news*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('news') }}">
                <i class="fas fa-fw fa-newspaper"></i>
                <span>News</span>
            </a>
        </li>

    @elseif(auth()->user()->level == 'bendahara')
        <li class="nav-item {{ Request::is('bendahara') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('bendahara') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Data Operasional</div>

        <li class="nav-item {{ Request::is('homestay*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('homestay') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>Home Stay</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('obwi*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('obwi') }}">
                <i class="fas fa-fw fa-map-marked-alt"></i>
                <span>Objek Wisata</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('pakwis*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('pakwis') }}">
                <i class="fas fa-fw fa-suitcase-rolling"></i>
                <span>Paket Wisata</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Transaksi</div>

        <li class="nav-item {{ Request::is('konfir*') ? 'active' : '' }}">
            <a class="nav-link d-flex justify-content-between align-items-center" href="{{ url('konfir') }}">
                <div>
                    <i class="fas fa-fw fa-check-circle"></i>
                    <span>Konfirmasi Reservasi</span>
                </div>
                @if(isset($notifCount) && $notifCount > 0)
                    <span class="badge badge-danger badge-counter">{{ $notifCount }}</span>
                @endif
            </a>
        </li>

        <li class="nav-item {{ Request::is('diskon*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('diskon') }}">
                <i class="fas fa-fw fa-tags"></i>
                <span>Diskon</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('jenispembayaran*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('jenispembayaran') }}">
                <i class="fas fa-fw fa-credit-card"></i>
                <span>Jenis Pembayaran</span>
            </a>
        </li>

    @elseif(auth()->user()->level == 'pemilik')
        <li class="nav-item {{ Request::is('owner') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('owner') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
    @endif

    <hr class="sidebar-divider d-none d-md-block">
    
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>