<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Customer - Login</title>

    <link href="{{asset('be/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="{{asset('be/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link rel="icon" href="{{asset('images/logo.png')}}">

    <style>
        body {
            background: linear-gradient(135deg, #fff4e6, #ffe0b3) !important;
            min-height: 100vh;
        }
        .card {
            border-radius: 20px !important;
            overflow: hidden;
        }
        .bg-login-orange {
            background: linear-gradient(135deg, #ff8c00, #ff6a00) !important;
        }
        .btn-orange {
            background-color: #ff6a00 !important;
            border-color: #ff6a00 !important;
            color: white !important;
            transition: 0.3s;
        }
        .btn-orange:hover {
            background-color: #e65c00 !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 106, 0, 0.3);
        }
        .form-control-user:focus {
            border-color: #ff8c00 !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 0, 0.25) !important;
        }
        .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #ff6a00 !important;
            border-color: #ff6a00 !important;
        }
        a.small {
            color: #ff6a00 !important;
            transition: 0.3s;
        }
        a.small:hover {
            color: #e65c00 !important;
            text-decoration: none;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center text-white bg-login-orange">
                                <div class="text-center px-5">
                                    <i class="fas fa-umbrella-beach fa-5x mb-4"></i>
                                    <h2 class="font-weight-bold">Welcome Back</h2>
                                    <p class="small opacity-75">
                                        Jelajahi keindahan Desa Serangan. Login sekarang untuk mengakses reservasi dan informasi wisata terbaik.
                                    </p>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center mb-4">
                                        <h1 class="h4 text-gray-900 font-weight-bold">Login Member</h1>
                                        <p class="text-muted small">Silakan masuk ke akun Anda</p>
                                    </div>

                                    @if ($errors->any())
                                    <div class="alert alert-danger py-2 small" style="border-radius: 10px;">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $item)
                                            <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <form class="user" method="POST" action="{{ route('loginn.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" 
                                                name="email" 
                                                value="{{ Cookie::get('remember_email') ?? old('email') }}"
                                                id="exampleInputEmail" 
                                                placeholder="Alamat Email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" 
                                                name="password"
                                                placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck" name="remember"
                                                    {{ Cookie::get('remember_email') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-orange btn-user btn-block font-weight-bold shadow-sm">
                                            LOGIN
                                        </button>
                                    </form>

                                    <hr class="my-4">

                                    <div class="text-center">
                                        <p class="small mb-0 text-muted">Belum punya akun?</p>
                                        <a class="small font-weight-bold" href="register">Create an Account!</a>
                                    </div>
                                    
                                    <div class="text-center mt-2">
                                        <a class="small" href="/"><i class="fas fa-arrow-left fa-sm mr-1"></i> Back to Home</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('be/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('be/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('be/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('be/js/sb-admin-2.min.js')}}"></script>

</body>
</html>