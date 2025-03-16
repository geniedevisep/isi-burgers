<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
    <a href="{{ route('welcome') }}" class="navbar-brand p-0">
        <h1 class="text-primary m-0">ISI BURGER</h1>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0 pe-4">
            <a href="{{ route('welcome') }}" class="nav-item nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}">Accueil</a>
            <a href="{{ route('catalogue.index') }}" class="nav-item nav-link {{ request()->routeIs('catalogue.*') ? 'active' : '' }}">Menu</a>
            @auth
                @if(auth()->user()->role === 'gestionnaire')
                    <a href="{{ route('gestionnaire.dashboard') }}" class="nav-item nav-link {{ request()->routeIs('gestionnaire.dashboard') ? 'active' : '' }}">Administration</a>
                @else
                    <a href="{{ route('client.dashboard') }}" class="nav-item nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">Mon Compte</a>
                @endif
            @endauth
        </div>
        @guest
            <a href="{{ route('login') }}" class="btn btn-primary py-2 px-4">Connexion</a>
        @else
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary py-2 px-4">Déconnexion</button>
            </form>
        @endguest
    </div>
</nav> 