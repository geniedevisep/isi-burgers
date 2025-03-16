<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER - Statistiques</title>
    
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
                <a class="nav-link" href="{{ route('gestionnaire.paiements.index') }}">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Paiements</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('gestionnaire.statistiques.index') }}">
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
            <h1 class="h3 mb-4">Statistiques</h1>

            <!-- Cartes de statistiques journalières -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stats-card p-4">
                        <h5 class="text-primary">Commandes en cours</h5>
                        <h2>{{ $commandesEnCours }}</h2>
                        <p class="text-muted mb-0">Aujourd'hui</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card p-4">
                        <h5 class="text-success">Commandes validées</h5>
                        <h2>{{ $commandesValidees }}</h2>
                        <p class="text-muted mb-0">Aujourd'hui</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card p-4">
                        <h5 class="text-info">Recettes</h5>
                        <h2>{{ number_format($recettesJour, 2) }} €</h2>
                        <p class="text-muted mb-0">Aujourd'hui</p>
                    </div>
                </div>
            </div>

            <!-- Graphiques -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Commandes par mois</h5>
                            <canvas id="commandesChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Produits par catégorie</h5>
                            <canvas id="produitsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Données pour le graphique des commandes
        const commandesData = @json($commandesParMois);
        const mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
                     'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        
        new Chart(document.getElementById('commandesChart'), {
            type: 'line',
            data: {
                labels: commandesData.map(d => mois[d.mois - 1]),
                datasets: [{
                    label: 'Nombre de commandes',
                    data: commandesData.map(d => d.total),
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Évolution des commandes'
                    }
                }
            }
        });

        // Données pour le graphique des produits par catégorie
        const produitsData = @json($produitsParCategorie);
        const categories = [...new Set(produitsData.map(d => d.categorie))];
        
        new Chart(document.getElementById('produitsChart'), {
            type: 'bar',
            data: {
                labels: mois,
                datasets: categories.map(cat => ({
                    label: cat,
                    data: mois.map((_, index) => {
                        const monthData = produitsData.find(d => d.categorie === cat && d.mois === index + 1);
                        return monthData ? monthData.total : 0;
                    }),
                    backgroundColor: cat === 'classic' ? 'rgba(255, 99, 132, 0.5)' :
                                   cat === 'signature' ? 'rgba(54, 162, 235, 0.5)' :
                                   'rgba(75, 192, 192, 0.5)'
                }))
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Produits par catégorie et par mois'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html> 