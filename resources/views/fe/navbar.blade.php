<nav class="site-nav mt-3">
    <div class="container">
        <div class="site-navigation">
            <div class="row align-items-center">
                <div class="col-6 col-lg-3">
                    <a href="/" class="logo m-0 float-start text-decoration-none fw-bold" >Desa Serangan</a>
                </div>

                <div class="col-lg-6 d-none d-lg-inline-block text-center nav-center-wrap">
                    <ul class="js-clone-nav text-center site-menu p-0 m-0">
                        <li class="{{ $title === 'Home' ? 'active' : '' }}">
                            <a href="{{ route('home') }}" style="{{ $title === 'Home'}}">Home</a>
                        </li>
                        <li class="{{ $title === 'Penginapan' ? 'active' : '' }}">
                            <a href="{{ route('penginapan.index') }}" style="{{ $title === 'Penginapan'}}">Penginapan</a>
                        </li>
                        <li class="{{ $title === 'Wisata' ? 'active' : '' }}">
                            <a href="{{ route('wisata.index') }}" style="{{ $title === 'Wisata'}}">Wisata</a>
                        </li>
                        <li class="{{ $title === 'Contact' ? 'active' : '' }}">
                            <a href="{{ route('contact.index') }}" style="{{ $title === 'Contact'}}">Contact</a>
                        </li>
                        <li class="{{ $title === 'Berita' ? 'active' : '' }}">
                            <a href="{{ route('berita.index') }}" style="{{ $title === 'Berita'}}">Berita</a>
                        </li>
                    </ul>
                </div>

                <div class="col-6 col-lg-3 text-end">
                    @if(Auth::check())
                        <div class="d-none d-lg-flex justify-content-end align-items-center gap-3">
                            <img src="{{ Auth::user()->pelanggan && Auth::user()->pelanggan->foto ? asset('storage/' . Auth::user()->pelanggan->foto) : asset('default-user.png') }}" 
                                 alt="User" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid #ff8c00;">
                            
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle text-decoration-none fw-bold" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="color: #ff6a00;">
                                    {{ Auth::user()->pelanggan->nama_lengkap ?? 'User' }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('reservasi.riwayat') }}">Daftar Reservasi</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logoutP') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="d-none d-lg-block">
                            <a href="loginn" class="btn btn-sm me-2 fw-bold" style="border: 1px solid #ff6a00; color: #ff6a00;">Login</a>
                            <a href="register" class="btn btn-sm text-white fw-bold" style="background-color: #ff6a00;">Register</a>
                        </div>
                    @endif

                    <a href="#" class="burger ms-auto float-end site-menu-toggle d-inline-block d-lg-none light text-decoration-none" 
                       data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" style="background: none; border: none;">
                        <span style="background: #ff6a00;"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-end border-0" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel" 
     style="background: linear-gradient(135deg, #fff4e6, #ffe0b3); width: 280px;">
    
    <div class="offcanvas-header border-bottom" style="background: linear-gradient(135deg, #ff8c00, #ff6a00);">
        <h5 class="offcanvas-title text-white fw-bold" id="mobileMenuLabel">Menu Desa Serangan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <ul class="list-unstyled">
            @php 
                $links = [
                    'Home' => '/', 
                    'Penginapan' => 'penginapan', 
                    'Wisata' => 'wisata', 
                    'Berita' => 'berita', 
                    'Contact' => 'contact'
                ]; 
            @endphp

            @foreach($links as $label => $url)
                <li class="mb-3">
                    <a href="{{ $url }}" class="text-decoration-none fs-5 transition" 
                       style="color: {{ $title === $label ? '#ff6a00' : '#6c757d' }}; font-weight: {{ $title === $label ? 'bold' : 'normal' }};">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>
        
        <hr style="border-top: 2px solid #ff8c00; opacity: 0.3;">
        
        @if(Auth::check())
            <div class="d-flex align-items-center gap-3 mb-4 p-2 rounded" style="background: rgba(255, 140, 0, 0.1);">
                <img src="{{ Auth::user()->pelanggan && Auth::user()->pelanggan->foto ? asset('storage/' . Auth::user()->pelanggan->foto) : asset('default-user.png') }}" 
                     style="width: 45px; height: 45px; border-radius: 50%; border: 2px solid #ff8c00;">
                <div>
                    <div class="fw-bold" style="color: #ff6a00;">{{ Auth::user()->pelanggan->nama_lengkap ?? 'User' }}</div>
                    <small class="text-muted">Pelanggan</small>
                </div>
            </div>
            
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-dark w-100 mb-2 border-secondary">Edit Profile</a>
            
            <form method="POST" action="{{ route('logoutP') }}">
                @csrf
                <button type="submit" class="btn text-white w-100 fw-bold" style="background-color: #ff6a00;">Logout</button>
            </form>
        @else
            <a href="loginn" class="btn w-100 mb-2 fw-bold" style="border: 1px solid #ff6a00; color: #ff6a00;">Login</a>
            <a href="register" class="btn text-white w-100 fw-bold" style="background-color: #ff6a00;">Register</a>
        @endif
    </div>
</div>