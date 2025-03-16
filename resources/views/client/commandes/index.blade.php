@extends('layouts.client')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Mes Commandes</h2>

    @if($commandes->isEmpty())
        <div class="alert alert-info text-center">
            Vous n'avez pas encore passé de commande.
            <a href="{{ route('catalogue.index') }}" class="btn btn-primary mt-3 d-block">Voir le catalogue</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="bg-primary text-dark">
                    <tr>
                        <th>N° Commande</th>
                        <th>Date</th>
                        <th>Contenu</th>
                        <th>Total</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commandes as $commande)
                        <tr>
                            <td>#{{ $commande->id }}</td>
                            <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <ul class="list-unstyled">
                                    @foreach($commande->burgers as $burger)
                                        <li>
                                            {{ $burger->pivot->quantite }}x {{ $burger->nom }}
                                            ({{ number_format($burger->pivot->prix_unitaire, 2) }} €)
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ number_format($commande->total, 2) }} €</td>
                            <td>
                                <span class="badge bg-{{ $commande->statut_color }}">
                                    {{ $commande->statut_label }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('catalogue.index') }}" class="btn btn-primary">
                Commander à nouveau
            </a>
        </div>
    @endif
</div>

<style>
    .badge {
        padding: 8px 12px;
        font-size: 0.9em;
    }
    
    .badge-warning {
        background-color: #ffc107;
        color: #000;
    }
    
    .badge-info {
        background-color: #17a2b8;
        color: #fff;
    }
    
    .badge-success {
        background-color: #28a745;
        color: #fff;
    }
    
    .table th {
        background-color: var(--primary);
        color: var(--secondary);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(255, 215, 0, 0.1);
    }
</style>
@endsection 