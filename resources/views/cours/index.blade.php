@extends('layouts.app')

@section('title', 'Cours d\'auto-école')

@section('content')

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Cours d'auto-école</h1>
        <p class="text-gray-600">Documents PDF téléchargeables pour votre formation</p>
    </div>
    <a href="{{ route('cours.create') }}" class="mt-4 md:mt-0 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
        <span>➕</span>
        <span>Ajouter un cours</span>
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($cours as $cour)
    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
        <div class="p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $cour->titre }}</h3>
                    @if($cour->categorie)
                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800 mb-2">
                        {{ $cour->categorie }}
                    </span>
                    @endif
                </div>
                <div class="bg-indigo-100 p-3 rounded-full">
                    <span class="text-2xl">📚</span>
                </div>
            </div>

            @if($cour->description)
            <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $cour->description }}</p>
            @endif

            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <div class="text-xs text-gray-500">
                    <span>Ajouté le {{ \Carbon\Carbon::parse($cour->created_at)->format('d/m/Y') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    @if($cour->fichier)
                    <div class="flex items-center gap-2">
                        <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ strtoupper($cour->type_fichier) }}</span>
                        <a href="{{ route('cours.download', $cour) }}" 
                           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition-colors duration-200">
                            <span>⬇️</span>
                            <span>Télécharger</span>
                        </a>
                    </div>
                    @else
                    <span class="text-xs text-gray-400">Fichier non disponible</span>
                    @endif
                </div>
            </div>

            <div class="mt-4 flex items-center gap-2">
                <a href="{{ route('cours.show', $cour) }}" 
                   class="flex-1 text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium py-2 px-3 rounded hover:bg-indigo-50 transition-colors">
                    👁️ Voir détails
                </a>
                <a href="{{ route('cours.edit', $cour) }}" 
                   class="text-sm text-blue-600 hover:text-blue-800 font-medium py-2 px-3 rounded hover:bg-blue-50 transition-colors">
                    ✏️ Modifier
                </a>
                <form action="{{ route('cours.destroy', $cour) }}" method="POST" class="inline" 
                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium py-2 px-3 rounded hover:bg-red-50 transition-colors">
                        🗑️
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full">
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <div class="text-gray-400">
                <span class="text-6xl block mb-4">📚</span>
                <p class="text-xl font-medium text-gray-600 mb-2">Aucun cours disponible</p>
                <p class="text-sm text-gray-500 mb-6">Commencez par ajouter votre premier cours PDF</p>
                <a href="{{ route('cours.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <span>➕</span>
                    <span>Ajouter un cours</span>
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>

@endsection

