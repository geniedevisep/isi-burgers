@extends('layouts.client')

@section('content')
<div class="container">
    <h1>Nos Burgers</h1>

    <div class="row mb-4">
        <div class="col-md-6">
            <form action="{{ route('catalogue') }}" method="GET" class="d-flex gap-2">
                <input type="text" 
                       name="search" 
                       class="form-control" 
                       placeholder="Rechercher un burger..."
                       value="{{ request('search') }}">
                <select name="prix" class="form-select">
                    <option value="">Prix</option>
                    <option value="asc" {{ request('prix') == 'asc' ? 'selected' : '' }}>
                        Prix croissant
                    </option>
                    <option value="desc" {{ request('prix') == 'desc' ? 'selected' : '' }}>
                        Prix décroissant
                    </option>
                </select>
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </form>
        </div>
    </div>

    <div class="row">
        @foreach($burgers as $burger)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="{{ Storage::url($burger->image) }}" 
                     class="card-img-top" 
                     alt="{{ $burger->nom }}"
                     style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $burger->nom }}</h5>
                    <p class="card-text">{{ Str::limit($burger->description, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">{{ number_format($burger->prix, 2) }} €</span>
                        @if($burger->stock > 0)
                            <form action="{{ route('client.commandes.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="burger_id" value="{{ $burger->id }}">
                                <input type="number" 
                                       name="quantite" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $burger->stock }}" 
                                       class="form-control form-control-sm d-inline-block" 
                                       style="width: 60px;">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Commander
                                </button>
                            </form>
                        @else
                            <span class="badge bg-danger">Rupture de stock</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Commentons temporairement la pagination jusqu'à ce qu'elle soit correctement configurée --}}
    {{-- {{ $burgers->links() }} --}}
</div>
@endsection 