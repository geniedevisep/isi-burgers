<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue - ISI BURGER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #FF6B35;
            --secondary: #2D3436;
        }

        .burger-card {
            height: 100%;
            transition: transform 0.3s;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .burger-card:hover {
            transform: translateY(-5px);
        }

        .burger-image {
            height: 200px;
            object-fit: cover;
        }

        .card-price {
            font-size: 1.25rem;
            color: var(--primary);
            font-weight: bold;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row g-4">
            @foreach($burgers as $burger)
            <div class="col-md-4 col-lg-3">
                <div class="burger-card card">
                    @php
                        $imageUrl = str_replace('public/', '', $burger->image);
                    @endphp
                    
                    <img src="{{ asset('storage/' . $imageUrl) }}" 
                         alt="{{ $burger->nom }}" 
                         class="burger-image card-img-top"
                         onerror="this.src='{{ asset('template/img/default-burger.jpg') }}'">
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $burger->nom }}</h5>
                        <p class="card-price mb-2">{{ number_format($burger->prix, 2) }} €</p>
                        <p class="card-text">{{ Str::limit($burger->description, 100) }}</p>
                        
                        @if($burger->stock > 0)
                            <form action="{{ route('catalogue.ajouterAuPanier', $burger) }}" method="POST" class="mb-2">
                                @csrf
                                <div class="input-group">
                                    <input type="number" 
                                           name="quantite" 
                                           value="1" 
                                           min="1" 
                                           max="{{ $burger->stock }}" 
                                           class="form-control">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Stock: {{ $burger->stock }}</small>
                            </form>
                        @else
                            <p class="text-danger">Rupture de stock</p>
                        @endif
                        
                        <a href="{{ route('catalogue.show', $burger) }}" class="btn btn-link text-primary p-0">
                            Voir les détails →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 