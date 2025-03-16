<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER - Détails de la Commande #{{ $commande->id }}</title>
    
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

        .order-details {
            background: white;
            border-radius: 8px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .burger-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
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
                <a class="nav-link active" href="{{ route('gestionnaire.commandes.index') }}">
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
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Commande #{{ $commande->id }}</h1>
                <a href="{{ route('gestionnaire.commandes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
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

            <div class="row">
                <!-- Informations de la commande -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Informations de la commande</h5>
                            <hr>
                            <p><strong>Date :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Client :</strong> {{ $commande->user->name }}</p>
                            <p><strong>Email :</strong> {{ $commande->user->email }}</p>
                            <p><strong>Statut actuel :</strong> 
                                <span class="badge bg-{{ $commande->status_color }}">
                                    {{ $commande->status_fr }}
                                </span>
                            </p>
                            <p><strong>Total :</strong> {{ number_format($commande->total, 2) }} €</p>
                            
                            {{-- Formulaire de mise à jour du statut --}}
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Mettre à jour le statut</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('gestionnaire.commandes.status.update', $commande->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Nouveau statut</label>
                                            <select name="status" id="status" class="form-select">
                                                <option value="en_attente" {{ $commande->status === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                                <option value="en_preparation" {{ $commande->status === 'en_preparation' ? 'selected' : '' }}>En préparation</option>
                                                <option value="pret" {{ $commande->status === 'pret' ? 'selected' : '' }}>Prêt</option>
                                                <option value="livre" {{ $commande->status === 'livre' ? 'selected' : '' }}>Livré</option>
                                                <option value="annule" {{ $commande->status === 'annule' ? 'selected' : '' }}>Annulé</option>
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Mettre à jour
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Afficher les messages d'erreur --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Ajouter après le formulaire de mise à jour du statut --}}
                            @if($commande->status === 'pret' && !$commande->paiement)
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Enregistrer le paiement</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('gestionnaire.paiements.store', $commande) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="commande_id" value="{{ $commande->id }}">
                                            <input type="hidden" name="montant" value="{{ $commande->total }}">
                                            
                                            <div class="mb-3">
                                                <label for="mode_paiement" class="form-label">Mode de paiement</label>
                                                <select name="mode_paiement" id="mode_paiement" class="form-select" required>
                                                    <option value="especes">Espèces</option>
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-money-bill-wave"></i> Enregistrer le paiement
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Détails des burgers -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Burgers commandés</h5>
                            <hr>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Burger</th>
                                            <th>Prix unitaire</th>
                                            <th>Quantité</th>
                                            <th>Sous-total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($commande->burgers as $burger)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/' . $burger->image) }}" 
                                                         alt="{{ $burger->nom }}" 
                                                         class="burger-image me-2">
                                                    {{ $burger->nom }}
                                                </div>
                                            </td>
                                            <td>{{ number_format($burger->pivot->prix_unitaire, 2) }} €</td>
                                            <td>{{ $burger->pivot->quantite }}</td>
                                            <td>{{ number_format($burger->pivot->prix_unitaire * $burger->pivot->quantite, 2) }} €</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Total</strong></td>
                                            <td><strong>{{ number_format($commande->total, 2) }} €</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
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