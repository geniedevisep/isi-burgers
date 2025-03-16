@extends('layouts.client')

@section('content')
<div class="container">
    <h1>Mon Profil</h1>
    
    <form action="{{ route('client.profil.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}">
        </div>

        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input type="text" class="form-control" id="telephone" name="telephone" value="{{ auth()->user()->telephone }}">
        </div>

        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <textarea class="form-control" id="adresse" name="adresse">{{ auth()->user()->adresse }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection 