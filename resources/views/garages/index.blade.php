@extends('layouts.app')

@section('title', 'Liste des garages')

@section('content')

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Garages</h1>
        <p class="text-gray-600">Gérez vos garages partenaires</p>
    </div>
    <div class="mt-4 md:mt-0 flex items-center gap-3">
        <a href="{{ route('carte') }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
            <span>🗺️</span>
            <span>Voir sur la carte</span>
        </a>
        <a href="{{ route('garages.create') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
            <span>➕</span>
            <span>Ajouter un garage</span>
        </a>
    </div>
</div>

@if($garages->whereNotNull('latitude')->whereNotNull('longitude')->count() > 0)
<div class="bg-white rounded-xl shadow-lg p-4 mb-6">
    <div id="map" class="w-full h-96 rounded-lg"></div>
</div>
@endif

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Adresse</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Coordonnées</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($garages as $g)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">{{ $g->nom }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $g->adresse }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        @if($g->latitude && $g->longitude)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                ✓ Localisé
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600">
                                Non localisé
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('garages.edit', $g) }}" class="text-blue-600 hover:text-blue-900 font-medium px-3 py-1 rounded hover:bg-blue-50 transition-colors">
                                ✏️ Modifier
                            </a>
                            <form action="{{ route('garages.destroy', $g) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce garage ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium px-3 py-1 rounded hover:bg-red-50 transition-colors">
                                    🗑️ Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="text-gray-400">
                            <span class="text-4xl block mb-2">🏢</span>
                            <p class="text-lg font-medium">Aucun garage enregistré</p>
                            <p class="text-sm mt-1">Commencez par ajouter votre premier garage</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($garages->whereNotNull('latitude')->whereNotNull('longitude')->count() > 0)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var map = L.map('map').setView([48.85, 2.35], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    @foreach($garages->whereNotNull('latitude')->whereNotNull('longitude') as $g)
    L.marker([{{ $g->latitude }}, {{ $g->longitude }}])
        .addTo(map)
        .bindPopup("<b>{{ $g->nom }}</b><br>{{ $g->adresse }}");
    @endforeach
});
</script>
@endif

@endsection
