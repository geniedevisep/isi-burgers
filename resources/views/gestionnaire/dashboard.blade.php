<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER - Dashboard Gestionnaire</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 250px;
        }
        
        body {
            background-color: #f8f9fc;
        }

        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #343a40;
            padding-top: 20px;
            z-index: 1;
        }

        #main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
        }

        .brand-name {
            color: white;
            font-size: 24px;
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 15px 20px;
            transition: all 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }

        .nav-link i {
            width: 25px;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-stats {
            transition: transform 0.3s;
        }

        .card-stats:hover {
            transform: translateY(-3px);
        }

        .border-left-primary { border-left: 4px solid #4e73df; }
        .border-left-success { border-left: 4px solid #1cc88a; }
        .border-left-danger { border-left: 4px solid #e74a3b; }
        .border-left-info { border-left: 4px solid #36b9cc; }

        @media (max-width: 768px) {
            #sidebar {
                width: 70px;
            }
            #main-content {
                margin-left: 70px;
            }
            .brand-name span {
                display: none;
            }
            .nav-link span {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div id="sidebar">
        <div class="brand-name">
            <i class="fas fa-hamburger"></i>
            <span>ISI BURGER</span>
        </div>
        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('gestionnaire.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('gestionnaire.burgers.index') }}">
                    <i class="fas fa-hamburger"></i>
                    <span>Burgers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('gestionnaire.commandes.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Commandes</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('gestionnaire.paiements.index') }}">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Paiements</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('gestionnaire.statistiques.index') }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Statistiques</span>
                </a>
            </li>
            <li class="nav-item mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Contenu principal -->
    <div id="main-content">
        <!-- En-tête -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Tableau de bord</h1>
            <a href="{{ route('gestionnaire.burgers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouveau Burger
            </a>
        </div>

        <!-- Cartes statistiques -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary card-stats h-100 py-2">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Commandes en cours</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $commandesEnCours }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success card-stats h-100 py-2">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Recettes du jour</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($recettesJour, 2) }} €</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-euro-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger card-stats h-100 py-2">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Ruptures de stock</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $burgersEnRupture->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info card-stats h-100 py-2">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Commandes aujourd'hui</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $commandesRecentes->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Autres sections du dashboard -->
        <!-- ... Le reste du contenu ... -->
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 