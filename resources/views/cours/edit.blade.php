@extends('layouts.app')

@section('title', 'Modifier le cours')

@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Modifier le cours</h1>
    <p class="text-gray-600">Mettez à jour les informations du cours</p>
</div>

<div class="bg-white rounded-xl shadow-lg p-6 md:p-8 max-w-2xl">
    <form method="POST" action="{{ route('cours.update', $cour) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Titre du cours <span class="text-red-500">*</span>
            </label>
            <input type="text" name="titre" value="{{ old('titre', $cour->titre) }}" 
                class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('titre') border-red-500 @enderror" 
                required>
            @error('titre')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Catégorie
            </label>
            <input type="text" name="categorie" value="{{ old('categorie', $cour->categorie) }}" 
                class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('categorie') border-red-500 @enderror" 
                placeholder="Ex: Code de la route, Conduite, Sécurité routière...">
            @error('categorie')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Description
            </label>
            <textarea name="description" rows="4" 
                class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('description') border-red-500 @enderror">{{ old('description', $cour->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Fichier PDF
            </label>
            @if($cour->fichier_pdf)
            <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">📄</span>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Fichier actuel</p>
                            <p class="text-xs text-gray-500">{{ $cour->fichier_pdf }}</p>
                        </div>
                    </div>
                    <a href="{{ route('cours.download', $cour) }}" 
                       class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                        Télécharger
                    </a>
                </div>
            </div>
            <p class="text-xs text-gray-500 mb-2">Laissez vide pour conserver le fichier actuel, ou téléchargez un nouveau fichier pour le remplacer.</p>
            @endif
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition-colors">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="fichier_pdf" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                            <span>Télécharger un nouveau fichier</span>
                            <input id="fichier_pdf" name="fichier_pdf" type="file" accept=".pdf" class="sr-only">
                        </label>
                        <p class="pl-1">ou glissez-déposez</p>
                    </div>
                    <p class="text-xs text-gray-500">PDF jusqu'à 10MB</p>
                </div>
            </div>
            @error('fichier_pdf')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="flex-1 bg-black hover:bg-gray-800 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                ✓ Mettre à jour
            </button>
            <a href="{{ route('cours.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors duration-200">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection

