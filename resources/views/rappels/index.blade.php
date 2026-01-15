@extends('layouts.app')

@section('title', 'Mes rappels')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Mes rappels programmés</h1>
        <a href="{{ route('rappels.create') }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            + Nouveau rappel
        </a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <ul class="divide-y divide-gray-200">
            @forelse($rappels as $rappel)
            <li class="p-6 hover:bg-gray-50">
                <div class="flex items-center gap-6">
                    <!-- Photo du véhicule -->
                    <div class="flex-shrink-0">
                        <div class="h-20 w-20 rounded-lg overflow-hidden bg-gray-200 flex-shrink-0" style="width: 5cm; height: 5cm;">
                            @if($rappel->vehicule->photo)
                                <img src="{{ asset('storage/' . $rappel->vehicule->photo) }}" alt="{{ $rappel->vehicule->marque }} {{ $rappel->vehicule->modele }}" class="h-full w-full object-cover object-center">
                            @else
                                <div class="h-full w-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Informations -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="flex items-center">
                                    <span class="text-lg font-medium text-gray-900">
                                        {{ ucfirst($rappel->type) }} - {{ $rappel->vehicule->marque }} {{ $rappel->vehicule->modele }}
                                    </span>
                                    @if($rappel->envoye)
                                        <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Envoyé
                                        </span>
                                    @else
                                        <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            En attente
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-2 flex items-center gap-4 text-sm text-gray-500">
                                    <span class="font-semibold text-gray-700">{{ $rappel->vehicule->immatriculation }}</span>
                                    <span>Le {{ $rappel->date_rappel->format('d/m/Y à H:i') }}</span>
                                    @if($rappel->notes)
                                        <span>• {{ Str::limit($rappel->notes, 50) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('rappels.edit', $rappel) }}"
                                   class="text-blue-600 hover:text-blue-900 font-medium px-3 py-1 rounded hover:bg-blue-50 transition-colors">
                                    ✏️ Modifier
                                </a>
                                <form action="{{ route('rappels.destroy', $rappel) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900 font-medium px-3 py-1 rounded hover:bg-red-50 transition-colors"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rappel ?')">
                                        🗑️ Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @empty
            <li class="px-6 py-12 text-center text-gray-500">
                Aucun rappel programmé pour le moment.
            </li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
