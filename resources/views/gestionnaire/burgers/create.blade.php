<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER - Ajouter un Burger</title>
    
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

        .form-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .preview-image {
            max-width: 200px;
            margin-top: 10px;
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
                <a class="nav-link active" href="{{ route('gestionnaire.burgers.index') }}">
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
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Ajouter un nouveau burger</h1>
                <a href="{{ route('gestionnaire.burgers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>

            <div class="form-card p-4">
                <form action="{{ route('gestionnaire.burgers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom du burger</label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" name="nom" value="{{ old('nom') }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="prix" class="form-label">Prix</label>
                                <input type="number" step="0.01" class="form-control @error('prix') is-invalid @enderror" 
                                       id="prix" name="prix" value="{{ old('prix') }}" required>
                                @error('prix')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                       id="stock" name="stock" value="{{ old('stock') }}" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="categorie" class="form-label">Catégorie</label>
                                <select name="categorie" id="categorie" class="form-control @error('categorie') is-invalid @enderror" required>
                                    <option value="">Sélectionner une catégorie</option>
                                    <option value="classic">Classic</option>
                                    <option value="signature">Signature</option>
                                    <option value="veggie">Veggie</option>
                                </select>
                                @error('categorie')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*" required>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="imagePreview" class="preview-image mt-2"></div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Ajouter le burger
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preview de l'image
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            const file = e.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="img-fluid preview-image">`;
            }

            if(file) {
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html> 