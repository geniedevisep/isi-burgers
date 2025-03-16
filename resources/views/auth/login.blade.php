@extends('layouts.app')

@section('content')
<div class="text-center mb-4">
    <h1 class="text-primary">Connexion</h1>
</div>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
        <label for="email">Adresse email</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
               name="password" required autocomplete="current-password">
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="remember" 
                   id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="custom-control-label" for="remember">Se souvenir de moi</label>
        </div>
    </div>

    <div class="form-group mb-0">
        <button type="submit" class="btn btn-primary btn-block">
            Se connecter
        </button>

        @if (Route::has('password.request'))
            <div class="text-center mt-3">
                <a class="text-primary" href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            </div>
        @endif
    </div>
</form>
@endsection
