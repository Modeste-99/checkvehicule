@extends('layouts.app')

@section('title', 'Liste des entretiens')

@section('content')

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Entretiens</h1>
        <p class="text-gray-600">Historique des entretiens de vos véhicules</p>
    </div>
    <a href="{{ route('entretiens.create') }}" class="mt-4 md:mt-0 inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
        <span>➕</span>
        <span>Ajouter un entretien</span>
    </a>
</div>

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Véhicule</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kilométrage</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Prix</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($entretiens as $e)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="text-sm font-semibold text-gray-900">
                                {{ $e->vehicule->marque }} {{ $e->vehicule->modele }}
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $e->vehicule->immatriculation }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $e->type }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($e->date_entretien)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        @if($e->kilometrage)
                            {{ number_format($e->kilometrage, 0, ',', ' ') }} km
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                        @if($e->prix)
                            {{ number_format($e->prix, 0, ',', ' ') }} FCFA
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('entretiens.edit', $e) }}" class="text-blue-600 hover:text-blue-900 font-medium px-3 py-1 rounded hover:bg-blue-50 transition-colors">
                                ✏️ Modifier
                            </a>
                            <form action="{{ route('entretiens.destroy', $e) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet entretien ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium px-3 py-1 rounded hover:bg-red-50 transition-colors">
                                    🗑️ Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="text-gray-400">
                            <span class="text-4xl block mb-2">🔧</span>
                            <p class="text-lg font-medium">Aucun entretien enregistré</p>
                            <p class="text-sm mt-1">Commencez par ajouter votre premier entretien</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
