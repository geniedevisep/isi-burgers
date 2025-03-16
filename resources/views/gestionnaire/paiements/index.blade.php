<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER - Gestion des Paiements</title>
    
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

        .stats-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            transition: transform 0.3s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

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
                <a class="nav-link" href="{{ route('gestionnaire.dashboard') }}">
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
                <a class="nav-link active" href="{{ route('gestionnaire.paiements.index') }}">
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
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Gestion des Paiements</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>N° Commande</th>
                                    <th>Client</th>
                                    <th>Date de paiement</th>
                                    <th>Montant</th>
                                    <th>Mode de paiement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paiements as $paiement)
                                <tr>
                                    <td>#{{ $paiement->commande->id }}</td>
                                    <td>{{ $paiement->commande->user->name }}</td>
                                    <td>{{ $paiement->date_paiement->format('d/m/Y H:i') }}</td>
                                    <td>{{ number_format($paiement->montant, 2) }} €</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ ucfirst($paiement->mode_paiement) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $paiements->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 