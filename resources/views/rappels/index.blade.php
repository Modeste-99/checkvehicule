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
                        <div class="mt-1 text-sm text-gray-500">
                            <span>Le {{ $rappel->date_rappel->format('d/m/Y à H:i') }}</span>
                            @if($rappel->notes)
                                <span class="ml-2">• {{ Str::limit($rappel->notes, 50) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <form action="{{ route('rappels.destroy', $rappel) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rappel ?')">
                                Supprimer
                            </button>
                        </form>
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
