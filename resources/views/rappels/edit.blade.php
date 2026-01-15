@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-6">Modifier le rappel</h1>
    
    <form action="{{ route('rappels.update', $rappel) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Véhicule</label>
            <select name="vehicule_id" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                <option value="">Sélectionner un véhicule</option>
                @foreach($vehicules as $vehicule)
                    <option value="{{ $vehicule->id }}" 
                        @selected($rappel->vehicule_id === $vehicule->id)>
                        {{ $vehicule->marque }} {{ $vehicule->modele }} ({{ $vehicule->immatriculation }})
                    </option>
                @endforeach
            </select>
            @error('vehicule_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Type de rappel</label>
            <select name="type" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                <option value="entretien" @selected($rappel->type === 'entretien')>Entretien</option>
                <option value="revision" @selected($rappel->type === 'revision')>Révision</option>
            </select>
            @error('type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Date et heure du rappel</label>
            <input type="datetime-local" name="date_rappel" required
                value="{{ $rappel->date_rappel->format('Y-m-d\TH:i') }}"
                min="{{ now()->format('Y-m-d\TH:i') }}"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
            @error('date_rappel')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Notes (optionnel)</label>
            <textarea name="notes" rows="3"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"
                placeholder="Détails supplémentaires...">{{ $rappel->notes }}</textarea>
            @error('notes')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('rappels.index') }}"
                class="px-6 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                Annuler
            </a>
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Mettre à jour le rappel
            </button>
        </div>
    </form>
</div>
@endsection
