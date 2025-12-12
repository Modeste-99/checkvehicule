@extends('layouts.app')

@section('title', 'Modifier l\'entretien')

@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Modifier l'entretien</h1>
    <p class="text-gray-600">Mettez à jour les informations de l'entretien</p>
</div>

<div class="bg-white rounded-xl shadow-lg p-6 md:p-8 max-w-2xl">
    <form method="POST" action="{{ route('entretiens.update', $entretien) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Véhicule <span class="text-red-500">*</span>
            </label>
            <select name="vehicule_id" 
                class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('vehicule_id') border-red-500 @enderror" 
                required>
                @foreach($vehicules as $v)
                <option value="{{ $v->id }}" {{ old('vehicule_id', $entretien->vehicule_id) == $v->id ? 'selected' : '' }}>
                    {{ $v->marque }} {{ $v->modele }} - {{ $v->immatriculation }}
                </option>
                @endforeach
            </select>
            @error('vehicule_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Type d'entretien <span class="text-red-500">*</span>
            </label>
            <input type="text" name="type" value="{{ old('type', $entretien->type) }}" 
                class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('type') border-red-500 @enderror" 
                required>
            @error('type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Date de l'entretien <span class="text-red-500">*</span>
            </label>
            <input type="date" name="date_entretien" value="{{ old('date_entretien', $entretien->date_entretien) }}" 
                class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('date_entretien') border-red-500 @enderror" 
                required>
            @error('date_entretien')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kilométrage
                </label>
                <input type="number" name="kilometrage" value="{{ old('kilometrage', $entretien->kilometrage) }}" min="0" 
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('kilometrage') border-red-500 @enderror">
                @error('kilometrage')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Prix (FCFA)
                </label>
                <input type="number" step="1" name="prix" value="{{ old('prix', $entretien->prix) }}" min="0" 
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('prix') border-red-500 @enderror">
                @error('prix')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Notes (optionnel)
            </label>
            <textarea name="note" rows="4" 
                class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('note') border-red-500 @enderror">{{ old('note', $entretien->note) }}</textarea>
            @error('note')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                ✓ Mettre à jour
            </button>
            <a href="{{ route('entretiens.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors duration-200">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection
