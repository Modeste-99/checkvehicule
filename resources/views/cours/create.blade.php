@extends('layouts.app')

@section('title', 'Ajouter un cours')

@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-black mb-2">Ajouter un cours</h1>
    <p class="text-gray-600">Téléchargez un document PDF pour votre auto-école</p>
</div>

<div class="bg-white rounded-xl shadow-lg p-6 md:p-8 max-w-2xl">
    <form method="POST" action="{{ route('cours.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Titre du cours <span class="text-red-500">*</span>
            </label>
            <input type="text" name="titre" value="{{ old('titre') }}" 
                class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('titre') border-red-500 @enderror" 
                placeholder="Ex: Code de la route - Panneaux de signalisation" required>
            @error('titre')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Description
            </label>
            <textarea name="description" rows="3" 
                class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('description') border-red-500 @enderror" 
                placeholder="Décrivez le contenu de ce cours...">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Fichier <span class="text-red-500">*</span>
            </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition-colors">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="fichier" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                            <span>Télécharger un fichier</span>
                            <input id="fichier" name="fichier" type="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt" class="sr-only" required>
                        </label>
                        <p class="pl-1">ou glissez-déposez</p>
                    </div>
                    <p class="text-xs text-gray-500">Fichiers acceptés : PDF, DOC, DOCX, PPT, PPTX, TXT (max 10MB)</p>
                </div>
            </div>
            @error('fichier')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="flex-1 bg-black hover:bg-gray-800 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                ✓ Enregistrer le cours
            </button>
            <a href="{{ route('cours.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors duration-200">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection

