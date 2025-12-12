@extends('layouts.app')

@section('title', 'Ajouter un véhicule')

@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Ajouter un véhicule</h1>
    <p class="text-gray-600">Remplissez les informations de votre véhicule</p>
</div>

<div class="bg-white rounded-xl shadow-lg p-6 md:p-8 max-w-2xl">
    <form action="{{ route('vehicules.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Marque <span class="text-red-500">*</span>
                </label>
                <input type="text" name="marque" value="{{ old('marque') }}" 
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('marque') border-red-500 @enderror" 
                    placeholder="Ex: Peugeot" required>
                @error('marque')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Modèle <span class="text-red-500">*</span>
                </label>
                <input type="text" name="modele" value="{{ old('modele') }}" 
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('modele') border-red-500 @enderror" 
                    placeholder="Ex: 308" required>
                @error('modele')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Immatriculation <span class="text-red-500">*</span>
            </label>
            <input type="text" name="immatriculation" value="{{ old('immatriculation') }}" 
                class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('immatriculation') border-red-500 @enderror" 
                placeholder="Ex: AB-123-CD" required>
            @error('immatriculation')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Année <span class="text-red-500">*</span>
                </label>
                <input type="number" name="annee" value="{{ old('annee') }}" min="1900" max="{{ date('Y') + 1 }}" 
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('annee') border-red-500 @enderror" 
                    placeholder="Ex: 2020" required>
                @error('annee')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kilométrage <span class="text-red-500">*</span>
                </label>
                <input type="number" name="kilometrage" value="{{ old('kilometrage') }}" min="0" 
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('kilometrage') border-red-500 @enderror" 
                    placeholder="Ex: 50000" required>
                @error('kilometrage')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                ✓ Enregistrer le véhicule
            </button>
            <a href="{{ route('vehicules.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors duration-200">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection
