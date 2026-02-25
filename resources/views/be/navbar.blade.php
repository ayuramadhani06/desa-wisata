<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">

    <!-- Sidebar Toggle -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fas fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto align-items-center">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Info -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle d-flex align-items-center"
               href="#"
               id="userDropdown"
               role="button"
               data-toggle="dropdown">

                <!-- User Text -->
                <div class="text-right mr-3 d-none d-lg-block">
                    <div class="font-weight-bold text-dark">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="small text-muted">
                        {{ auth()->user()->email }}
                    </div>
                </div>

                <!-- Avatar -->
                <img class="img-profile rounded-circle border"
                     style="width:40px; height:40px; object-fit:cover;"
                     src="{{ asset('be/img/undraw_profile.svg') }}">
            </a>

            <!-- Dropdown -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">

                <div class="dropdown-header text-center py-3">

                    <img class="rounded-circle mb-2"
                         width="60"
                         src="{{ asset('be/img/undraw_profile.svg') }}">

                    <div class="font-weight-bold">
                        {{ auth()->user()->name }}
                    </div>

                    <div class="small text-muted">
                        {{ auth()->user()->email }}
                    </div>

                    <!-- Role Badge -->
                    <div class="mt-2">
                        <span class="badge badge-primary text-uppercase px-3 py-1">
                            {{ auth()->user()->level }}
                        </span>
                    </div>

                </div>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item text-danger"
                   href="#"
                   data-toggle="modal"
                   data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                    Logout
                </a>

            </div>
        </li>

    </ul>
</nav>