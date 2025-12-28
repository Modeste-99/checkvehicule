@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')

<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-900 mb-2">Tableau de bord</h1>
    <p class="text-gray-600">Vue d'ensemble de votre gestion de véhicules</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Véhicules</p>
                <p class="text-4xl font-bold text-gray-900">{{ auth()->user()->vehicules()->count() }}</p>
            </div>
            <div class="bg-blue-100 p-4 rounded-full">
                <span class="text-3xl">🚙</span>
            </div>
        </div>
        <a href="{{ route('vehicules.index') }}" class="mt-4 inline-block text-sm text-blue-600 hover:text-blue-800 font-medium">
            Voir tous les véhicules →
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Entretiens</p>
                <p class="text-4xl font-bold text-gray-900">{{ auth()->user()->entretiens()->count() }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-full">
                <span class="text-3xl">🔧</span>
            </div>
        </div>
        <a href="{{ route('entretiens.index') }}" class="mt-4 inline-block text-sm text-green-600 hover:text-green-800 font-medium">
            Voir tous les entretiens →
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Garages</p>
                <p class="text-4xl font-bold text-gray-900">{{ auth()->user()->garages()->count() }}</p>
            </div>
            <div class="bg-purple-100 p-4 rounded-full">
                <span class="text-3xl">🏢</span>
            </div>
        </div>
        <a href="{{ route('garages.index') }}" class="mt-4 inline-block text-sm text-purple-600 hover:text-purple-800 font-medium">
            Voir tous les garages →
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-indigo-500 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Cours</p>
                <p class="text-4xl font-bold text-gray-900">{{ auth()->user()->cours()->count() }}</p>
            </div>
            <div class="bg-indigo-100 p-4 rounded-full">
                <span class="text-3xl">📚</span>
            </div>
        </div>
        <a href="{{ route('cours.index') }}" class="mt-4 inline-block text-sm text-indigo-600 hover:text-indigo-800 font-medium">
            Voir tous les cours →
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">Actions rapides</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('vehicules.create') }}" class="flex items-center gap-3 p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
            <span class="text-2xl">➕</span>
            <div>
                <p class="font-semibold text-gray-900">Ajouter un véhicule</p>
                <p class="text-sm text-gray-600">Enregistrer un nouveau véhicule</p>
            </div>
        </a>
        <a href="{{ route('entretiens.create') }}" class="flex items-center gap-3 p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200">
            <span class="text-2xl">🔧</span>
            <div>
                <p class="font-semibold text-gray-900">Planifier un entretien</p>
                <p class="text-sm text-gray-600">Enregistrer un entretien</p>
            </div>
        </a>
        <a href="{{ route('garages.create') }}" class="flex items-center gap-3 p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors duration-200">
            <span class="text-2xl">🏢</span>
            <div>
                <p class="font-semibold text-gray-900">Ajouter un garage</p>
                <p class="text-sm text-gray-600">Enregistrer un nouveau garage</p>
            </div>
        </a>
        <a href="{{ route('cours.create') }}" class="flex items-center gap-3 p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
            <span class="text-2xl">📚</span>
            <div>
                <p class="font-semibold text-gray-900">Ajouter un cours</p>
                <p class="text-sm text-gray-600">Télécharger un document PDF</p>
            </div>
        </a>
    </div>
</div>

@if(auth()->user()->garages()->whereNotNull('latitude')->whereNotNull('longitude')->count() > 0)
<div class="bg-white rounded-xl shadow-lg p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">Carte des garages</h2>
    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Visualisez vos garages sur la carte</h3>
                <p class="text-sm text-gray-600 mb-4">Consultez l'emplacement de tous vos garages partenaires avec leurs coordonnées GPS</p>
                <a href="{{ route('carte') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <span>🗺️</span>
                    <span>Ouvrir la carte</span>
                </a>
            </div>
            <div class="hidden md:block">
                <span class="text-6xl">🗺️</span>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
