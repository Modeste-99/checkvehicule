<nav class="bg-gray-900 text-white w-64 min-h-screen p-4 hidden md:block">
    <h2 class="text-2xl font-bold mb-6">Mon App</h2>

    <ul class="space-y-4">
        <li><a href="{{ route('dashboard') }}" class="block hover:text-gray-300">Dashboard</a></li>
        <li><a href="{{ route('vehicules.index') }}" class="block hover:text-gray-300">Véhicules</a></li>
        <li><a href="{{ route('entretiens.index') }}" class="block hover:text-gray-300">Entretiens</a></li>
        <li><a href="{{ route('cours.index') }}" class="block hover:text-gray-300">Cours</a></li>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="mt-6 bg-red-600 px-4 py-2 rounded hover:bg-red-700">
                Déconnexion
            </button>
        </form>
    </ul>
</nav>
