<!-- /*
* Template Name: Sterial
* Template Author: Untree.co
* Tempalte URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<meta name="author" content="Untree.co">
	<link rel="shortcut icon" href="favicon.png">

	<meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap5" />
	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Brygada+1918:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@400;700&display=swap" rel="stylesheet">

	

	<link rel="stylesheet" href="{{asset('fe/fonts/icomoon/style.css')}}">
	<link rel="stylesheet" href="{{asset('fe/fonts/flaticon/font/flaticon.css')}}">

	<link rel="stylesheet" href="{{asset('fe/css/tiny-slider.css')}}">
	<link rel="stylesheet" href="{{asset('fe/css/aos.css')}}">
	<link rel="stylesheet" href="{{asset('fe/css/flatpickr.min.css')}}">
	<link rel="stylesheet" href="{{asset('fe/css/glightbox.min.css')}}">
	<link rel="stylesheet" href="{{asset('fe/css/style.css')}}">
	<link href="{{asset('be/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">


	<title>Sterial &mdash; Free Bootstrap 5 Website Template by Untree.co </title>
</head>
<link rel="icon" href="{{asset('images/logo.png')}}">
<body>

	<div class="site-mobile-menu site-navbar-target">
		<div class="site-mobile-menu-header">
			<div class="site-mobile-menu-close">
				<span class="icofont-close js-menu-toggle"></span>
			</div>
		</div>
		<div class="site-mobile-menu-body"></div>
	</div>

	<nav class="site-nav mt-3">
		<div class="container">
	
			<div class="site-navigation">
				<div class="row">
					<div class="col-6 col-lg-3">
						<a href="/" class="logo m-0 float-start">Desa Serangan</a>
					</div>
					<div class="col-lg-6 d-none d-lg-inline-block text-center nav-center-wrap">
						<ul class="js-clone-nav  text-center site-menu p-0 m-0">
							<li class="active"><a href="/">Home</a></li>
							<li><a href="penginapan">Penginapan</a></li>
							<li><a href="wisata">Wisata</a></li>
							{{-- <li class="has-children"> --}}
								{{-- <a href="#">Obyek Wisata</a>
								<ul class="dropdown">
									<li><a href="#">Menu One</a></li>
									<li class="has-children">
										<a href="#">Obyek Wisata</a>
										<ul class="dropdown">
											<li><a href="#">Sub Menu One</a></li>
											<li><a href="#">Sub Menu Two</a></li>
											<li><a href="#">Sub Menu Three</a></li>
										</ul>
									</li>
									<li><a href="#">Menu Three</a></li>
								</ul> --}}
							{{-- </li> --}}
							<li><a href="contact">Contact</a></li>
							<li><a href="berita">Berita</a></li>
	
						</ul>
					</div>
					@if(Auth::check())
					<div class="col-lg-3 d-none d-lg-flex justify-content-end align-items-center gap-3">
						<img src="{{ Auth::user()->pelanggan && Auth::user()->pelanggan->foto 
										? asset('storage/' . Auth::user()->pelanggan->foto) 
										: asset('default-user.png') }}" 
										alt="User Photo" 
										style="width: 30px; height: 30px; border-radius: 50%;">
									 	
						<div class="dropdown">
							<a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle" 
								id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
								<span class="text-white">
										{{ Auth::user()->pelanggan && Auth::user()->pelanggan->nama_lengkap 
											? Auth::user()->pelanggan->nama_lengkap 
											: 'Nama Tidak Tersedia' }}
									</span>
							</a>
								<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
										<form action="{{ route('reservasi.riwayat') }}" method="GET" class="text-left">
											@csrf
											<button type="submit" class="dropdown-item">Daftar Reservasi</button>									
										</form>
										<form method="POST" action="{{ route('logoutP') }}">
											@csrf
											<button type="submit" class="dropdown-item">Logout</button>
										</form>
									</li>
								</ul>
						</div>
						<!-- <form method="POST" action="{{ route('logoutP') }}" id="logout-form">
							@csrf
							<ul class="js-clone-nav d-none d-lg-inline-block text-end site-menu">
								<li class="cta-button">
									<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">Logout</a>
								</li>
							</ul>
						</form> -->
					</div>
					
					@else
					<div class="col-6 col-lg-3 text-lg-end">
						<ul class="js-clone-nav d-none d-lg-inline-block text-end site-menu ">
							<li class="cta-button"><a href="loginn">Login</a></li>
						</ul>
						<ul class="js-clone-nav d-none d-lg-inline-block text-end site-menu ">
							<li class="cta-button"><a href="register">Register</a></li>
						</ul>
	
						<a href="#" class="burger ms-auto float-end site-menu-toggle js-menu-toggle d-inline-block d-lg-none light" data-toggle="collapse" data-target="#main-navbar">
							<span></span>
						</a>
					</div>
					@endif
				</div>
			</div>
			
		</div>
	</nav>

	@isset($title)
		@if ($title === 'Home')
			@yield('troon')
			@yield('berita')
			@yield('paketwisata')
			@yield('services')
			@yield('diskon')
			@yield('penginapan')
		@elseif ($title === 'Penginapan')
			@yield('troon')
			@yield('penginapan')
		@elseif ($title === 'Wisata')
			@yield('troon')
			@yield('wisata')
			@yield('testimoni')
		@elseif ($title === 'Contact')
			@yield('troon')
			@yield('contact')
		@elseif ($title === 'Berita')
			@yield('troon')
			@yield('berita')
		@endif
		@yield('troon2')
		@yield('content')
		
	@endisset


	



	<div class="site-footer">
		<div class="container">

			<div class="row">
				<div class="col-lg-4">
					<div class="widget">
						<h3>Tentang Serangan<span class="text-primary"></span> </h3>
						<p>Desa Wisata Serangan adalah sebuah pulau kecil di selatan Bali yang terkenal dengan keindahan alam pesisir, budaya lokal, dan ekowisata berbasis pelestarian penyu.</p>
					</div> <!-- /.widget -->
					<div class="widget">
						<h3>Connect</h3>
						<ul class="list-unstyled social">
							<li><a href="https://www.instagram.com/desa_wisata_serangan?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><span class="icon-instagram"></span></a></li>
							<li><a href="https://twitter.com/Kemenparekraf/status/1842024512814252380"><span class="icon-twitter"></span></a></li>
							<li><a href="https://www.facebook.com/DenpasarNow/videos/wujudkan-transformasi-pariwisata-desa-seranganwalikota-jaya-negara-resmikan-prog/849723697347945/"><span class="icon-facebook"></span></a></li>
							<li><a href="https://www.youtube.com/channel/UCZZiOB4JImoIzWfof3oOB3g"><span class="icon-youtube"></span></a></li>
							<!-- <li><a href="#"><span class="icon-dribbble"></span></a></li> -->
							<!-- <li><a href="#"><span class="icon-linkedin"></span></a></li> -->
							<!-- <li><a href="#"><span class="icon-pinterest"></span></a></li> -->
						</ul>
					</div> <!-- /.widget -->
				</div> <!-- /.col-lg-3 -->

				{{-- <div class="col-lg-2 ml-auto">
					<div class="widget">
						<h3>Links</h3>
						<ul class="list-unstyled float-left links">
							<li><a href="{{route('penginapan.index')}}">Penginapan</a></li>
							<li><a href="#">Services</a></li>
							<li><a href="#">News</a></li>
							<li><a href="#">Careers</a></li>
							<li><a href="#">Contact</a></li>
						</ul>
					</div> <!-- /.widget -->
				</div> <!-- /.col-lg-3 --> --}}

				<div class="col-lg-2">
					<div class="widget">
						<h3></h3>
						<ul class="list-unstyled float-left links">
							<li><a href="/">Home</a></li>
							<li><a href="penginapan">Penginapan</a></li>
							<li><a href="wisata">Wisata</a></li>
							<li><a href="penginapan">Berita</a></li>
							<li><a href="penginapan">Contact</a></li>
						</ul>
					</div> <!-- /.widget -->
				</div> <!-- /.col-lg-3 -->


				<div class="col-lg-3">
					<div class="widget">
						<h3>Contact</h3>
						<address>Jl. Pulau Serangan, Serangan, Denpasar Sel., Kota Denpasar, Bali 80229</address>
						<ul class="list-unstyled links mb-4">
							<li><a href="tel://11234567890">+1(123)-456-7890</a></li>
							<li><a href="tel://11234567890">+1(123)-456-7890</a></li>
							<li><a href="mailto:info@mydomain.com">info@mydomain.com</a></li>
						</ul>
					</div> <!-- /.widget -->
				</div> <!-- /.col-lg-3 -->
				
				

			</div> <!-- /.row -->
			<!-- <img src="images/logo.png" alt="Logo Desa Serangan" style="max-width: 150px; margin-bottom: 10px; margin-left: 1000px"> -->
			<div class="row mt-5">
				<div class="col-12 text-center">
					<p class="mb-0">Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash; Designed with love by <a href="https://untree.co">Untree.co</a> <!-- License information: https://untree.co/license/ --> Distributed By <a href="https:/themewagon.com" target="_blank">ThemeWagon</a>
					</p>
				</div>
			</div> 
		</div>
	</div>
		<!-- Preloader -->
		<div id="overlayer"></div>
		<div class="loader">
			<div class="spinner-border text-primary" role="status">
				<span class="visually-hidden">Loading...</span>
			</div>
		</div>


		<script src="{{asset('fe/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{asset('fe/js/tiny-slider.js')}}"></script>
		<script src="{{asset('fe/js/aos.js')}}"></script>
		<script src="{{asset('fe/js/navbar.js')}}"></script>
		<script src="{{asset('fe/js/counter.js')}}"></script>
		<script src="{{asset('fe/js/rellax.js')}}"></script>
		<script src="{{asset('fe/js/flatpickr.js')}}"></script>
		<script src="{{asset('fe/js/glightbox.min.js')}}"></script>
		<script src="{{asset('fe/js/custom.js')}}"></script>
		<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>
