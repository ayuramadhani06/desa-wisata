<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            Halo {{ auth()->user()->level }}
        </div>
    </a>

    <hr class="sidebar-divider">

    @if(auth()->user()->level == 'admin')

        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <div class="sidebar-heading">Admin</div>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('userm') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>User Management</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('news') }}">
                <i class="fas fa-fw fa-newspaper"></i>
                <span>News</span>
            </a>
        </li>

    @elseif(auth()->user()->level == 'bendahara')

        <li class="nav-item">
            <a class="nav-link" href="{{ url('bendahara') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <div class="sidebar-heading">Bendahara</div>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('homestay') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>Home Stay</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('obwi') }}">
                <i class="fas fa-fw fa-map-marked-alt"></i>
                <span>Objek Wisata</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('konfir') }}">
                <i class="fas fa-fw fa-check-circle"></i>
                <span>Konfirmasi Reservasi</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('pakwis') }}">
                <i class="fas fa-fw fa-suitcase-rolling"></i>
                <span>Paket Wisata</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('diskon') }}">
                <i class="fas fa-fw fa-tags"></i>
                <span>Diskon</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('jenispembayaran') }}">
                <i class="fas fa-fw fa-credit-card"></i>
                <span>Jenis Pembayaran</span>
            </a>
        </li>

    @elseif(auth()->user()->level == 'pemilik')

        <li class="nav-item">
            <a class="nav-link" href="{{ url('owner') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

    @endif

    <hr class="sidebar-divider d-none d-md-block">
</ul>