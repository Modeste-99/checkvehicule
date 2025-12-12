@extends('layouts.app')

@section('title', $cour->titre)

@section('content')

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $cour->titre }}</h1>
            @if($cour->categorie)
            <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-indigo-100 text-indigo-800 mb-2">
                {{ $cour->categorie }}
            </span>
            @endif
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('cours.edit', $cour) }}" 
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                ✏️ Modifier
            </a>
            <a href="{{ route('cours.index') }}" 
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors duration-200">
                ← Retour
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Description</h2>
            @if($cour->description)
            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $cour->description }}</p>
            @else
            <p class="text-gray-400 italic">Aucune description disponible</p>
            @endif
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Informations</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Date d'ajout</p>
                    <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($cour->created_at)->format('d/m/Y à H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Dernière modification</p>
                    <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($cour->updated_at)->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl shadow-lg p-6">
            <div class="text-center">
                <div class="bg-indigo-600 p-4 rounded-full inline-block mb-4">
                    <span class="text-4xl">📚</span>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Document PDF</h3>
                @if($cour->fichier_pdf)
                <p class="text-sm text-gray-600 mb-4">Téléchargez le document PDF de ce cours</p>
                <a href="{{ route('cours.download', $cour) }}" 
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 w-full justify-center">
                    <span>⬇️</span>
                    <span>Télécharger le PDF</span>
                </a>
                @else
                <p class="text-sm text-red-600 mb-4">Aucun fichier PDF disponible</p>
                <a href="{{ route('cours.edit', $cour) }}" 
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 w-full justify-center">
                    <span>➕</span>
                    <span>Ajouter un PDF</span>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

