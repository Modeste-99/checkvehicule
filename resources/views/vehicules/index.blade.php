@extends('layouts.app')

@section('title', 'Liste des véhicules')

@section('content')

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Véhicules</h1>
        <p class="text-gray-600">Gérez votre flotte de véhicules</p>
    </div>
    <a href="{{ route('vehicules.create') }}" class="mt-4 md:mt-0 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
        <span>➕</span>
        <span>Ajouter un véhicule</span>
    </a>
</div>

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
        @forelse($vehicules as $v)
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-200">
                <!-- Photo du véhicule -->
                <div class="relative w-full h-28 bg-gray-200 overflow-hidden">
                    @if($v->photo)
                        <img src="{{ asset('storage/' . $v->photo) }}" alt="{{ $v->marque }} {{ $v->modele }}" class="w-full h-full object-cover object-center">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Informations du véhicule -->
                <div class="p-4">
                    <div class="mb-3">
                        <h3 class="text-lg font-bold text-gray-900">{{ $v->marque }} {{ $v->modele }}</h3>
                        <span class="inline-block mt-1 px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                            {{ $v->immatriculation }}
                        </span>
                    </div>

                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex justify-between">
                            <span>Année:</span>
                            <span class="font-semibold">{{ $v->annee }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Kilométrage:</span>
                            <span class="font-semibold">{{ number_format($v->kilometrage, 0, ',', ' ') }} km</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-4 flex items-center gap-2">
                        <a href="{{ route('vehicules.edit', $v) }}" class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-3 rounded-lg transition-colors text-sm">
                            ✏️ Modifier
                        </a>
                        <form action="{{ route('vehicules.destroy', $v) }}" method="POST" class="flex-1" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-3 rounded-lg transition-colors text-sm">
                                🗑️ Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-16 bg-gray-50 rounded-lg">
                    <span class="text-6xl block mb-4">🚗</span>
                    <p class="text-lg font-bold text-gray-900">Aucun véhicule enregistré</p>
                    <p class="text-gray-600 mt-2">Commencez par ajouter votre premier véhicule</p>
                    <a href="{{ route('vehicules.create') }}" class="mt-4 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                        <span>➕</span>
                        <span>Ajouter un véhicule</span>
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

@endsection
