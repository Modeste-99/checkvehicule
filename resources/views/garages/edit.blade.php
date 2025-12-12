@extends('layouts.app')

@section('title', 'Modifier le garage')

@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Modifier le garage</h1>
    <p class="text-gray-600">Mettez à jour les informations du garage</p>
</div>

<div class="bg-white rounded-xl shadow-lg p-6 md:p-8 max-w-2xl">
    <form method="POST" action="{{ route('garages.update', $garage) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Nom du garage <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nom" value="{{ old('nom', $garage->nom) }}" 
                class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('nom') border-red-500 @enderror" 
                required>
            @error('nom')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Adresse <span class="text-red-500">*</span>
            </label>
            <input type="text" name="adresse" value="{{ old('adresse', $garage->adresse) }}" 
                class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('adresse') border-red-500 @enderror" 
                required>
            @error('adresse')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
            <p class="text-sm text-blue-800 font-medium mb-2">📍 Localisation (optionnel)</p>
            <p class="text-xs text-blue-700">Ajoutez les coordonnées GPS pour afficher le garage sur la carte</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Latitude
                </label>
                <input type="number" step="0.000001" name="latitude" value="{{ old('latitude', $garage->latitude) }}" 
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('latitude') border-red-500 @enderror">
                @error('latitude')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Longitude
                </label>
                <input type="number" step="0.000001" name="longitude" value="{{ old('longitude', $garage->longitude) }}" 
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('longitude') border-red-500 @enderror">
                @error('longitude')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                ✓ Mettre à jour
            </button>
            <a href="{{ route('garages.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors duration-200">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection
