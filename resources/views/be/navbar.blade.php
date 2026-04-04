<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 sticky-top shadow-sm">

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fas fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto align-items-center">

        @if(auth()->user()->level == 'bendahara')
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                @if(isset($notifCount) && $notifCount > 0)
                    <span class="badge badge-danger badge-counter">{{ $notifCount }}</span>
                @endif
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Reservasi Baru
                </h6>
                
                @if(isset($notifItems) && $notifItems->count() > 0)
                    @foreach($notifItems as $item)
                    <a class="dropdown-item d-flex align-items-center" href="{{ url('konfir') }}">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary text-white">
                                <i class="fas fa-receipt"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-muted">{{ $item->created_at->diffForHumans() }}</div>
                            <span class="font-weight-bold">{{ $item->nama_pelanggan }} memesan {{ $item->paketWisata->nama_paket }}</span>
                        </div>
                    </a>
                    @endforeach
                    <a class="dropdown-item text-center small text-gray-500" href="{{ url('konfir') }}">Lihat Semua Reservasi</a>
                @else
                    <a class="dropdown-item text-center small text-gray-500" href="#">Belum ada pesanan baru</a>
                @endif
            </div>
        </li>
        @endif

        <div class="topbar-divider d-none d-sm-block"></div>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle d-flex align-items-center"
               href="#"
               id="userDropdown"
               role="button"
               data-toggle="dropdown">

                <div class="text-right mr-3 d-none d-lg-block">
                    <div class="font-weight-bold text-dark">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="small text-muted">
                        {{ auth()->user()->email }}
                    </div>
                </div>

                <img class="img-profile rounded-circle border"
                     style="width:40px; height:40px; object-fit:cover;"
                     src="{{ asset('be/img/undraw_profile.svg') }}">
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                <div class="dropdown-header text-center py-3">
                    <img class="rounded-circle mb-2"
                         width="60"
                         src="{{ asset('be/img/undraw_profile.svg') }}">
                    <div class="font-weight-bold">{{ auth()->user()->name }}</div>
                    <div class="small text-muted">{{ auth()->user()->email }}</div>
                    <div class="mt-2">
                        <span class="badge badge-primary text-uppercase px-3 py-1">
                            {{ auth()->user()->level }}
                        </span>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>
</nav>