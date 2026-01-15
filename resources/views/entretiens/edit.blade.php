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
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('kilometrage') border-red-500 @enderror"
                    placeholder="Ex: 50000">
                @error('kilometrage')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Coûts de l'entretien (FCFA)</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pièces de rechange</label>
                        <input type="number" step="1" name="prix_pieces" value="{{ old('prix_pieces', $entretien->prix_pieces) }}" min="0" 
                            class="w-full px-4 py-2 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('prix_pieces') border-red-500 @enderror" 
                            placeholder="0">
                        @error('prix_pieces')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Main d'œuvre</label>
                        <input type="number" step="1" name="prix_main_oeuvre" value="{{ old('prix_main_oeuvre', $entretien->prix_main_oeuvre) }}" min="0" 
                            class="w-full px-4 py-2 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('prix_main_oeuvre') border-red-500 @enderror" 
                            placeholder="0">
                        @error('prix_main_oeuvre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-sm font-medium text-gray-500">Total</div>
                        <div class="text-xl font-semibold text-gray-900" id="prix-total">
                            {{ number_format(($entretien->prix_pieces + $entretien->prix_main_oeuvre), 0, ',', ' ') }} FCFA
                        </div>
                    </div>
                </div>
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

@push('scripts')
<script>
    // Calcul dynamique du prix total
    function updateTotal() {
        const pieces = parseFloat(document.querySelector('input[name="prix_pieces"]').value) || 0;
        const mainOeuvre = parseFloat(document.querySelector('input[name="prix_main_oeuvre"]').value) || 0;
        const total = pieces + mainOeuvre;
        document.getElementById('prix-total').textContent = total.toLocaleString('fr-FR') + ' FCFA';
    }

    // Écouteurs d'événements pour les champs de prix
    document.querySelector('input[name="prix_pieces"]').addEventListener('input', updateTotal);
    document.querySelector('input[name="prix_main_oeuvre"]').addEventListener('input', updateTotal);

    // Calcul initial
    updateTotal();
</script>
@endpush

@endsection
