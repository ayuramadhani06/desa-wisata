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


	<title>Desa Wisata Serangan </title>
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


	    {{-- Navbar (bisa dimatikan per halaman) --}}
    @unless(isset($hideNavbar) && $hideNavbar === true)
        @include('fe.navbar')
    @endunless

    <main>
        @yield('content')
    </main>

    {{-- Footer (bisa dimatikan per halaman) --}}
    @unless(isset($hideFooter) && $hideFooter === true)
        @include('fe.footer')
    @endunless
	
		<!-- Preloader -->
		<!-- <div id="overlayer"></div>
		<div class="loader">
			<div class="spinner-border text-primary" role="status">
				<span class="visually-hidden">Loading...</span>
			</div>
		</div> -->


		<script src="{{asset('fe/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{asset('fe/js/tiny-slider.js')}}"></script>
		<script src="{{asset('fe/js/aos.js')}}"></script>
		<script src="{{asset('fe/js/navbar.js')}}"></script>
		<script src="{{asset('fe/js/counter.js')}}"></script>
		<script src="{{asset('fe/js/rellax.js')}}"></script>
		<script src="{{asset('fe/js/flatpickr.js')}}"></script>
		<script src="{{asset('fe/js/glightbox.min.js')}}"></script>
		<script src="{{asset('fe/js/custom.js')}}"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			function confirmLogout(formId) {
				Swal.fire({
					title: 'Yakin mau keluar?',
					text: "Sesi Anda akan berakhir sekarang.",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#ff6a00',
					cancelButtonColor: '#6c757d',
					confirmButtonText: 'Ya, Logout',
					cancelButtonText: 'Batal',
					reverseButtons: true
				}).then((result) => {
					if (result.isConfirmed) {
						document.getElementById(formId).submit();
					}
				})
			}
		</script>
		<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>
