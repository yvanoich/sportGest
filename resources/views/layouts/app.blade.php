<!-- resources/views/layout/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SportGest')</title>
    @yield('styles') <!-- Inclusion des styles spécifiques à la vue -->

    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ asset('js/app-script.js') }}" defer></script>

</head>

<body>
    <div id="app">
        <!-- Barre de navigation -->
        <div class="wrapper navbar">
            <nav>
                <ul>
                    <!-- Affiche le nom et prénom de l'utilisateur connecté + bouton de deconnexion -->
                    @auth
                    <li><a href="{{ url('/dashboard') }}" class="logo">SportGest</a></li>
                    <!-- Liens à gauche de la barre de navigation -->
                    <li class="{{ request()->is('dashboard') ? 'active' : '' }}"><a href="{{ route('home') }}">Accueil</a></li>
                    <li class="{{ request()->is('statistiques/profile/'. Auth::user()->ident) ? 'active' : '' }}"><a href="{{ route('stats-profile-get', ['ident' => Auth::user()->ident]) }}">{{ Auth::user()->name }}</a></li>
                    <li class="{{ request()->is('settings/profile') ? 'active' : '' }}"><a href="{{ route('settings-profile') }}">Paramètres</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Se déconnecter</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    @else
                    <li><a href="{{ url('/') }}" class="logo">SportGest</a></li>
                    <li class="{{ request()->is('login') ? 'active' : '' }}"><a href="{{ url('/login') }}">Se connecter</a></li>
                    <li class="{{ request()->is('inscription') ? 'active' : '' }}"><a href="{{ url('/inscription') }}">S'inscrire</a></li>
                    @endauth
                </ul>
            </nav>
            @auth
            <a class="add-activity" href="{{ route('activity-edit') }}">+ Ajouter une activités</a>
            @endauth
        </div>

        <!-- Contenu principal -->
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>