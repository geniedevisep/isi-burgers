<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER - Authentification</title>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('template/css/style.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary: #FFD700;
            --secondary: #212529;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(45deg, rgba(33, 37, 41, 0.95), rgba(33, 37, 41, 0.8)),
                        url('{{ asset('template/img/OIP.jpg') }}') center/cover fixed;
        }

        .auth-card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: var(--secondary);
        }

        .btn-primary:hover {
            background-color: var(--secondary);
            border-color: var(--primary);
            color: var(--primary);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
        }
    </style>
</head>
<body>
    @include('layouts.partials.navbar')

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="auth-card">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.partials.footer')

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 