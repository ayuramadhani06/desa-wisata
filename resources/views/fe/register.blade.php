<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Desa Serangan - Register</title>

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

        /* Sisi kiri: Ganti Success Hijau ke Orange Gradasi */
        .bg-register-orange {
            background: linear-gradient(135deg, #ff8c00, #ff6a00) !important;
        }

        /* Button Styling */
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

        /* Focus Input */
        .form-control-user:focus {
            border-color: #ff8c00 !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 0, 0.25) !important;
        }

        /* Custom File Label */
        .custom-file-input:focus ~ .custom-file-label {
            border-color: #ff8c00 !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 0, 0.25) !important;
        }

        a.small {
            color: #ff6a00 !important;
        }

        a.small:hover {
            color: #e65c00 !important;
            text-decoration: none;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center">

    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center text-white bg-register-orange">
                        <div class="text-center px-4">
                            <i class="fas fa-user-plus fa-5x mb-4"></i>
                            <h2 class="font-weight-bold">Join With Us!</h2>
                            <p class="small opacity-75">
                                Daftarkan diri Anda untuk menjelajahi keindahan Wisata Desa Serangan dan nikmati kemudahan reservasi.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 font-weight-bold mb-4">Create an Account!</h1>
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

                            <form class="user" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="nama_lengkap" class="form-control form-control-user"
                                            placeholder="Nama Lengkap" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="no_hp" class="form-control form-control-user" 
                                            placeholder="No. Handphone" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-user" 
                                        placeholder="Alamat Email" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            placeholder="Password" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="alamat" class="form-control form-control-user"
                                            placeholder="Alamat" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold d-block mb-2 ml-2 small text-muted">Foto Profil (Opsional)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="foto" name="foto" accept="image/*">
                                        <label class="custom-file-label" for="foto" style="border-radius: 20px;">Choose image...</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-orange btn-user btn-block font-weight-bold mt-4">
                                    REGISTER ACCOUNT
                                </button>
                            </form>
                            
                            <hr class="my-4">

                            <div class="text-center">
                                <p class="small mb-0 text-muted">Sudah punya akun?</p>
                                <a class="small font-weight-bold" href="loginn">Already have an account? Login!</a>
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

    <script src="{{asset('be/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('be/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('be/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('be/js/sb-admin-2.min.js')}}"></script>

    <script>
        // Script agar nama file muncul di label setelah dipilih
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>
</body>

</html>