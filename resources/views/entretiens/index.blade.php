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
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Coûts (FCFA)</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($entretiens as $e)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                @if($e->vehicule->photo)
                                    <img src="{{ asset('storage/' . $e->vehicule->photo) }}" 
                                         alt="{{ $e->vehicule->marque }} {{ $e->vehicule->modele }}" 
                                         class="object-cover rounded-lg"
                                         style="width: 3cm; height: 3cm; object-fit: cover;">
                                @else
                                    <div class="rounded-lg bg-gray-200 flex items-center justify-center" 
                                         style="width: 3cm; height: 3cm;">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900">
                                    {{ $e->vehicule->marque }} {{ $e->vehicule->modele }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $e->vehicule->immatriculation }}
                                </div>
                            </div>
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
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($e->prix_pieces || $e->prix_main_oeuvre)
                            <div class="text-gray-700">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Pièces :</span>
                                    <span class="font-medium">{{ $e->prix_pieces ? number_format($e->prix_pieces, 0, ',', ' ') : '0' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Main d'œuvre :</span>
                                    <span class="font-medium">{{ $e->prix_main_oeuvre ? number_format($e->prix_main_oeuvre, 0, ',', ' ') : '0' }}</span>
                                </div>
                                <div class="flex justify-between mt-1 pt-1 border-t border-gray-100">
                                    <span class="font-semibold">Total :</span>
                                    <span class="font-bold">{{ number_format($e->prix, 0, ',', ' ') }}</span>
                                </div>
                            </div>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('entretiens.edit', $e) }}" class="text-blue-600 hover:text-blue-900 font-medium px-3 py-1 rounded hover:bg-blue-50 transition-colors" title="Modifier">
                                ✏️
                            </a>
                            <form action="{{ route('entretiens.destroy', $e) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet entretien ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium px-3 py-1 rounded hover:bg-red-50 transition-colors" title="Supprimer">
                                    🗑️
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
