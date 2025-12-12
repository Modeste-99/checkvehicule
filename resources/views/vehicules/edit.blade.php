@extends('layouts.app')

@section('title', 'Modifier un véhicule')

@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Modifier un véhicule</h1>
    <p class="text-gray-600">Mettez à jour les informations de votre véhicule</p>
</div>

<div class="bg-white rounded-xl shadow-lg p-6 md:p-8 max-w-2xl">
    <form action="{{ route('vehicules.update', $vehicule) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Marque <span class="text-red-500">*</span>
                </label>
                <input type="text" name="marque" value="{{ old('marque', $vehicule->marque) }}" 
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('marque') border-red-500 @enderror" 
                    required>
                @error('marque')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Modèle <span class="text-red-500">*</span>
                </label>
                <input type="text" name="modele" value="{{ old('modele', $vehicule->modele) }}" 
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('modele') border-red-500 @enderror" 
                    required>
                @error('modele')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Immatriculation
            </label>
            <input type="text" value="{{ $vehicule->immatriculation }}" 
                class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" 
                disabled>
            <p class="mt-1 text-xs text-gray-500">L'immatriculation ne peut pas être modifiée</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Année <span class="text-red-500">*</span>
                </label>
                <input type="number" name="annee" value="{{ old('annee', $vehicule->annee) }}" min="1900" max="{{ date('Y') + 1 }}" 
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('annee') border-red-500 @enderror" 
                    required>
                @error('annee')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kilométrage <span class="text-red-500">*</span>
                </label>
                <input type="number" name="kilometrage" value="{{ old('kilometrage', $vehicule->kilometrage) }}" min="0" 
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('kilometrage') border-red-500 @enderror" 
                    required>
                @error('kilometrage')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                ✓ Mettre à jour
            </button>
            <a href="{{ route('vehicules.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors duration-200">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection
