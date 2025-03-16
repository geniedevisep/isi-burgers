<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER - Espace Client</title>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('template/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('template/css/style.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary: #FFD700;     /* Jaune doré */
            --secondary: #212529;   /* Noir soft */
            --light: rgba(255, 255, 255, 0.9);
            --dark: rgba(33, 37, 41, 0.9);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(45deg, rgba(33, 37, 41, 0.95), rgba(33, 37, 41, 0.8)),
                        url('{{ asset('template/img/OIP.jpg') }}') center/cover fixed;
            color: #333;
        }

        .bg-primary { background-color: var(--primary) !important; }
        .text-primary { color: var(--primary) !important; }
        
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

        main {
            min-height: calc(100vh - 300px);
            padding: 2rem 0;
        }

        .content-wrapper {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .card {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            border: none;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
        }

        .nav-link {
            color: var(--secondary) !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        /* Style pour les formulaires */
        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 0.75rem 1rem;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
        }

        /* Style pour les alertes */
        .alert {
            border-radius: 10px;
            border: none;
        }

        /* Style pour la pagination */
        .pagination {
            margin-top: 2rem;
        }

        .page-link {
            color: var(--secondary);
            border: 1px solid var(--primary);
        }

        .page-link:hover {
            background-color: var(--primary);
            color: var(--secondary);
            border-color: var(--primary);
        }

        .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
            color: var(--secondary);
        }
    </style>
</head>
<body>
    <!-- Topbar Start -->
    <div class="container-fluid bg-light pt-3 d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left mb-2 mb-lg-0">
                    <div class="d-inline-flex align-items-center">
                        <p><i class="fa fa-envelope mr-2"></i>info@isiburger.com</p>
                        <p class="text-body px-3">|</p>
                        <p><i class="fa fa-phone-alt mr-2"></i>+221 77 123 45 67</p>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-right">
                    <div class="d-inline-flex align-items-center">
                        @auth
                            <x-notifications />
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="text-primary px-3 btn btn-link">
                                    <i class="fa fa-sign-out-alt"></i> Déconnexion
                                </button>
                            </form>
                        @else
                            <a class="text-primary px-3" href="{{ route('login') }}">
                                <i class="fa fa-user"></i> Connexion
                            </a>
                            <a class="text-primary px-3" href="{{ route('register') }}">
                                <i class="fa fa-user-plus"></i> Inscription
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid position-relative nav-bar p-0">
        <div class="container-lg position-relative p-0 px-lg-3" style="z-index: 9;">
            <nav class="navbar navbar-expand-lg navbar-light shadow-lg py-3 py-lg-0 pl-3 pl-lg-5">
                <a href="{{ route('welcome') }}" class="navbar-brand">
                    <h1 class="m-0"><span class="text-primary">ISI</span>BURGER</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                    <div class="navbar-nav ml-auto py-0">
                        <a href="{{ route('welcome') }}" class="nav-item nav-link">Accueil</a>
                        <a href="{{ route('catalogue.index') }}" class="nav-item nav-link">Menu</a>
                        @auth
                            <a href="{{ route('client.commandes.index') }}" class="nav-item nav-link">Mes Commandes</a>
                            <a href="{{ route('profil') }}" class="nav-item nav-link">Mon Profil</a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-item nav-link">Déconnexion</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

    <main>
        <div class="container">
            <div class="content-wrapper">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </main>

    <!-- Footer Start -->
    <div class="container-fluid text-white-50 py-5 px-sm-3 px-lg-5" style="background-color: rgba(33, 37, 41, 0.9);">
        <div class="row pt-5">
            <div class="col-lg-4 col-md-6 mb-5">
                <a href="{{ route('welcome') }}" class="navbar-brand">
                    <h1 class="text-primary"><span class="text-white">ISI</span>BURGER</h1>
                </a>
                <p>Le meilleur burger de la ville</p>
            </div>
            <div class="col-lg-4 col-md-6 mb-5">
                <h5 class="text-white text-uppercase mb-4" style="letter-spacing: 5px;">Nos Contacts</h5>
                <p><i class="fa fa-map-marker-alt mr-2"></i>Dakar, Sénégal</p>
                <p><i class="fa fa-phone-alt mr-2"></i>+221 77 123 45 67</p>
                <p><i class="fa fa-envelope mr-2"></i>info@isiburger.com</p>
            </div>
            <div class="col-lg-4 col-md-6 mb-5">
                <h5 class="text-white text-uppercase mb-4" style="letter-spacing: 5px;">Suivez-nous</h5>
                <div class="d-flex justify-content-start">
                    <a class="btn btn-outline-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark text-white border-top py-4 px-sm-3 px-md-5" style="border-color: rgba(256, 256, 256, .1) !important;">
        <div class="row">
            <div class="col-lg-6 text-center text-md-left mb-3 mb-md-0">
                <p class="m-0 text-white-50">Copyright &copy; <a href="#">ISI BURGER</a>. Tous droits réservés.</p>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('template/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('template/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('template/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('template/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('template/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
</body>
</html> 