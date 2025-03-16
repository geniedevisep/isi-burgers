<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER - Mon Compte</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #4e73df;
        }
        .navbar-brand {
            color: white !important;
        }
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
        }
        .nav-link:hover {
            color: white !important;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 20px;
        }
        .order-status {
            padding: 0.25em 0.6em;
            border-radius: 20px;
            font-size: 0.85em;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-hamburger"></i> ISI BURGER
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catalogue.index') }}">Catalogue</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('client.dashboard') }}">Mes Commandes</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link border-0 bg-transparent">
                                <i class="fas fa-sign-out-alt"></i> Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h1 class="h3">Mon Tableau de Bord</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Mes dernières commandes</h5>
                        
                        @if($dernieresCommandes->isEmpty())
                            <p class="text-muted">Vous n'avez pas encore de commandes.</p>
                        @else
                            @foreach($dernieresCommandes as $commande)
                                <div class="d-flex align-items-center justify-content-between mb-3 p-3 bg-light rounded">
                                    <div>
                                        <h6 class="mb-1">Commande #{{ $commande->id }}</h6>
                                        <p class="mb-1 text-muted">
                                            {{ $commande->created_at->format('d/m/Y H:i') }}
                                        </p>
                                        <span class="order-status bg-{{ $commande->status_color }}">
                                            {{ $commande->status_fr }}
                                        </span>
                                    </div>
                                    <div class="text-end">
                                        <h6 class="mb-1">{{ number_format($commande->total, 2) }} €</h6>
                                        <a href="{{ route('client.commandes.show', $commande) }}" 
                                           class="btn btn-sm btn-primary">
                                            Voir les détails
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Actions rapides</h5>
                        <a href="{{ route('catalogue.index') }}" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-shopping-cart"></i> Commander des burgers
                        </a>
                        <a href="{{ route('client.commandes.index') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-list"></i> Voir toutes mes commandes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 