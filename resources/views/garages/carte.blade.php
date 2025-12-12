@extends('layouts.app')

@section('title', 'Carte des garages')

@section('content')

<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">📍 Carte des garages</h1>
            <p class="text-gray-600">Visualisez l'emplacement de tous vos garages partenaires</p>
        </div>
        <div class="mt-4 md:mt-0 flex items-center gap-3">
            <a href="{{ route('garages.index') }}" 
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors duration-200">
                ← Liste des garages
            </a>
            <a href="{{ route('garages.create') }}" 
               class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                ➕ Ajouter un garage
            </a>
        </div>
    </div>
</div>

@if($garages->count() > 0)
<div class="bg-white rounded-xl shadow-lg p-4 mb-6">
    <div id="map" class="w-full h-[600px] rounded-lg"></div>
</div>

<div class="bg-white rounded-xl shadow-lg p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">Garages sur la carte</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($garages as $garage)
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200" data-lat="{{ $garage->latitude }}" data-lng="{{ $garage->longitude }}">
            <div class="flex items-start justify-between mb-2">
                <h3 class="font-bold text-gray-900">{{ $garage->nom }}</h3>
                <span class="text-xl">📍</span>
            </div>
            <p class="text-sm text-gray-600 mb-3">{{ $garage->adresse }}</p>
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-500">Coordonnées:</span>
                <span class="text-xs font-mono text-gray-700">{{ number_format($garage->latitude, 6) }}, {{ number_format($garage->longitude, 6) }}</span>
            </div>
            <div class="mt-3 flex items-center gap-2">
                <button onclick="focusOnGarage({{ $garage->latitude }}, {{ $garage->longitude }}, '{{ $garage->nom }}')" 
                        class="text-xs text-indigo-600 hover:text-indigo-800 font-medium px-3 py-1 rounded hover:bg-indigo-50 transition-colors">
                    🎯 Centrer sur la carte
                </button>
                <a href="{{ route('garages.edit', $garage) }}" 
                   class="text-xs text-blue-600 hover:text-blue-800 font-medium px-3 py-1 rounded hover:bg-blue-50 transition-colors">
                    ✏️ Modifier
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@else
<div class="bg-white rounded-xl shadow-lg p-12 text-center">
    <div class="text-gray-400">
        <span class="text-6xl block mb-4">🗺️</span>
        <p class="text-xl font-medium text-gray-600 mb-2">Aucun garage localisé</p>
        <p class="text-sm text-gray-500 mb-6">Ajoutez des garages avec leurs coordonnées GPS pour les voir sur la carte</p>
        <a href="{{ route('garages.create') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
            <span>➕</span>
            <span>Ajouter un garage</span>
        </a>
    </div>
</div>
@endif

@if($garages->count() > 0)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let map;
let markers = [];
let bounds = [];

document.addEventListener('DOMContentLoaded', function() {
    // Initialiser la carte
    @if($garages->count() > 0)
    // Centrer sur le premier garage ou moyenne des coordonnées
    const firstGarage = @json($garages->first());
    map = L.map('map').setView([firstGarage.latitude, firstGarage.longitude], 10);
    @else
    map = L.map('map').setView([48.8566, 2.3522], 6); // Paris par défaut
    @endif

    // Ajouter la couche de tuiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Ajouter les marqueurs pour chaque garage
    @foreach($garages as $garage)
    const marker{{ $garage->id }} = L.marker([{{ $garage->latitude }}, {{ $garage->longitude }}])
        .addTo(map)
        .bindPopup(`
            <div style="min-width: 200px;">
                <h3 style="font-weight: bold; margin-bottom: 8px; font-size: 16px;">{{ $garage->nom }}</h3>
                <p style="margin-bottom: 8px; color: #666; font-size: 14px;">{{ $garage->adresse }}</p>
                <div style="margin-top: 10px;">
                    <a href="{{ route('garages.edit', $garage) }}" 
                       style="display: inline-block; background: #4F46E5; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; margin-right: 5px;">
                        ✏️ Modifier
                    </a>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $garage->latitude }},{{ $garage->longitude }}" 
                       target="_blank"
                       style="display: inline-block; background: #10B981; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px;">
                        🧭 Itinéraire
                    </a>
                </div>
            </div>
        `);
    
    markers.push(marker{{ $garage->id }});
    bounds.push([{{ $garage->latitude }}, {{ $garage->longitude }}]);
    @endforeach

    // Ajuster la vue pour afficher tous les marqueurs
    if (bounds.length > 0) {
        map.fitBounds(bounds, { padding: [50, 50] });
    }
});

// Fonction pour centrer la carte sur un garage spécifique
function focusOnGarage(lat, lng, nom) {
    map.setView([lat, lng], 15);
    
    // Ouvrir le popup du marqueur correspondant
    markers.forEach(marker => {
        const markerLat = marker.getLatLng().lat;
        const markerLng = marker.getLatLng().lng;
        if (Math.abs(markerLat - lat) < 0.0001 && Math.abs(markerLng - lng) < 0.0001) {
            marker.openPopup();
        }
    });
}
</script>
@endif

@endsection

