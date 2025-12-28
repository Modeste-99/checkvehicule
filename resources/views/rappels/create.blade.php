
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-6">Programmer un rappel</h1>
    
    <form action="{{ route('rappels.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Véhicule</label>
            <select name="vehicule_id" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                <option value="">Sélectionner un véhicule</option>
                @foreach($vehicules as $vehicule)
                    <option value="{{ $vehicule->id }}">
                        {{ $vehicule->marque }} {{ $vehicule->modele }} ({{ $vehicule->immatriculation }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Type de rappel</label>
            <select name="type" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                <option value="entretien">Entretien</option>
                <option value="revision">Révision</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Date et heure du rappel</label>
            <input type="datetime-local" name="date_rappel" required
                min="{{ now()->format('Y-m-d\TH:i') }}"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Notes (optionnel)</label>
            <textarea name="notes" rows="3"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"
                placeholder="Détails supplémentaires..."></textarea>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('dashboard') }}"
                class="px-6 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                Annuler
            </a>
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Enregistrer le rappel
            </button>
        </div>
    </form>
</div>
@endsection