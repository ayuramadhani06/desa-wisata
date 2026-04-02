<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Profile' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #fff4e6, #ffe0b3);
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .card-header {
            background: linear-gradient(135deg, #ff8c00, #ff6a00);
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .btn-primary {
            background-color: #ff6a00;
            border: none;
        }

        .btn-primary:hover {
            background-color: #e65c00;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .img-thumbnail {
            border: 3px solid #ff8c00;
        }

        .form-control:focus {
            border-color: #ff8c00;
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 0, 0.25);
        }
    </style>

</head>
<body class="d-flex justify-content-center align-items-center">

    @yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>