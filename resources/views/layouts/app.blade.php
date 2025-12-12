<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CheckVehicule')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
</head>
<body class="bg-gray-50">

    <div class="flex min-h-screen">

        {{-- Sidebar (uniquement si connecté) --}}
        @if(auth()->check())
        <aside class="hidden md:flex flex-col w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white shadow-xl">

            <div class="p-6 border-b border-gray-700">

                {{-- Profil utilisateur --}}
                <div class="flex items-center gap-3 mb-4">

                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/profiles/' . auth()->user()->photo) }}" 
                             alt="Photo de profil" 
                             class="w-12 h-12 rounded-full object-cover border-2 border-gray-600">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 
                                    flex items-center justify-center text-white text-lg font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="flex-1 min-w-0">
                        <h2 class="text-xl font-bold text-white truncate">{{ auth()->user()->name }}</h2>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <h2 class="text-2xl font-bold text-white">🚗 CheckVehicule</h2>
                <p class="text-sm text-gray-400 mt-1">Gestion de véhicules</p>
            </div>

            {{-- Menu --}}
            <nav class="flex-1 p-4 space-y-2">
                <a href="/dashboard" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-gray-700 
                    transition-colors duration-200 {{ request()->is('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300' }}">
                    <span>📊</span>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="/vehicules" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-gray-700 
                    transition-colors duration-200 {{ request()->is('vehicules*') ? 'bg-blue-600 text-white' : 'text-gray-300' }}">
                    <span>🚙</span>
                    <span class="font-medium">Véhicules</span>
                </a>

                <a href="/entretiens" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-gray-700 
                    transition-colors duration-200 {{ request()->is('entretiens*') ? 'bg-blue-600 text-white' : 'text-gray-300' }}">
                    <span>🔧</span>
                    <span class="font-medium">Entretiens</span>
                </a>

                <a href="/garages" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-gray-700
                    transition-colors duration-200 {{ request()->is('garages*') ? 'bg-blue-600 text-white' : 'text-gray-300' }}">
                    <span>🏢</span>
                    <span class="font-medium">Garages</span>
                </a>

                <a href="/cours" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-gray-700
                    transition-colors duration-200 {{ request()->is('cours*') ? 'bg-blue-600 text-white' : 'text-gray-300' }}">
                    <span>📚</span>
                    <span class="font-medium">Cours</span>
                </a>

                <a href="/carte" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-gray-700
                    transition-colors duration-200 {{ request()->is('carte') ? 'bg-blue-600 text-white' : 'text-gray-300' }}">
                    <span>🗺️</span>
                    <span class="font-medium">Carte</span>
                </a>

                <a href="/profile" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-gray-700
                    transition-colors duration-200 {{ request()->is('profile*') ? 'bg-blue-600 text-white' : 'text-gray-300' }}">
                    <span>👤</span>
                    <span class="font-medium">Mon profil</span>
                </a>
            </nav>

            {{-- Déconnexion --}}
            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-red-600 
                                   transition-colors duration-200 text-gray-300 hover:text-white">
                        <span>🚪</span>
                        <span class="font-medium">Déconnexion</span>
                    </button>
                </form>
            </div>

        </aside>
        @endif

        {{-- Contenu principal --}}
        <main class="flex-1 p-6 md:p-8 lg:p-10 pb-24 md:pb-10">

            {{-- Alertes --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <span class="text-xl mr-3">✓</span>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <span class="text-xl mr-3">✗</span>
                        <p class="font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    @auth
        @include('components.mobile-nav')
    @endauth

</body>
</html>
