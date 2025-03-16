<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $burger->nom }} - ISI BURGER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #FF6B35;
            --secondary: #2D3436;
        }

        .burger-image {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: darken(var(--primary), 10%);
            border-color: darken(var(--primary), 10%);
        }

        .quantity-input {
            max-width: 100px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="burger-detail-card">
            <div class="row">
                <div class="col-md-6">
                    @php
                        $imageUrl = str_replace('public/', '', $burger->image);
                    @endphp
                    
                    <img src="{{ asset('storage/' . $imageUrl) }}" 
                         alt="{{ $burger->nom }}" 
                         class="burger-image w-100"
                         onerror="this.src='{{ asset('template/img/default-burger.jpg') }}'">
                </div>
                <div class="col-md-6">
                    <h1 class="mb-3">{{ $burger->nom }}</h1>
                    <p class="h2 text-primary mb-4">{{ number_format($burger->prix, 2) }} €</p>
                    <p class="mb-4">{{ $burger->description }}</p>
                    
                    @if($burger->stock > 0)
                        <form action="{{ route('catalogue.ajouterAuPanier', $burger) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="quantite" class="form-label">Quantité :</label>
                                <div class="d-flex gap-3 align-items-center">
                                    <input type="number" 
                                           id="quantite"
                                           name="quantite" 
                                           value="1" 
                                           min="1" 
                                           max="{{ $burger->stock }}" 
                                           class="form-control quantity-input">
                                    
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-cart-plus me-2"></i>
                                        Commander
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    Stock disponible : {{ $burger->stock }} unités
                                </small>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Rupture de stock
                        </div>
                    @endif
                    
                    <hr class="my-4">
                    
                    <a href="{{ route('catalogue.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Retour au catalogue
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 