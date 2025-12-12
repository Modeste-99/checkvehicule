<div x-data="{ open: false }" class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
    <!-- Bouton du menu hamburger -->
    <button @click="open = !open" class="fixed bottom-4 right-4 w-14 h-14 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 transition-colors duration-200 z-50">
        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
        <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <!-- Menu mobile -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200 transform"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150 transform"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed inset-0 bg-white z-40 pt-16 px-4 pb-24 overflow-y-auto"
         @click.away="open = false">
        
        <div class="space-y-6 py-6">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 rounded-lg {{ request()->is('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                <span>📊</span>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{ route('vehicules.index') }}" class="flex items-center gap-3 p-3 rounded-lg {{ request()->is('vehicules*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                <span>🚙</span>
                <span class="font-medium">Véhicules</span>
            </a>

            <a href="{{ route('entretiens.index') }}" class="flex items-center gap-3 p-3 rounded-lg {{ request()->is('entretiens*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                <span>🔧</span>
                <span class="font-medium">Entretiens</span>
            </a>

            <a href="{{ route('garages.index') }}" class="flex items-center gap-3 p-3 rounded-lg {{ request()->is('garages*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                <span>🏢</span>
                <span class="font-medium">Garages</span>
            </a>

            <a href="{{ route('cours.index') }}" class="flex items-center gap-3 p-3 rounded-lg {{ request()->is('cours*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                <span>📚</span>
                <span class="font-medium">Cours</span>
            </a>

            <a href="{{ route('carte') }}" class="flex items-center gap-3 p-3 rounded-lg {{ request()->is('carte') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                <span>🗺️</span>
                <span class="font-medium">Carte</span>
            </a>

            <a href="{{ route('profile.show') }}" class="flex items-center gap-3 p-3 rounded-lg {{ request()->is('profile*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                <span>👤</span>
                <span class="font-medium">Mon profil</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="pt-4 border-t border-gray-200">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 p-3 text-red-600 hover:bg-red-50 rounded-lg">
                    <span>🚪</span>
                    <span class="font-medium">Déconnexion</span>
                </button>
            </form>
        </div>
    </div>
</div>
