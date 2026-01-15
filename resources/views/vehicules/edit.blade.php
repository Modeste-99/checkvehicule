@extends('layouts.app')

@section('title', 'Modifier un véhicule')

@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Modifier un véhicule</h1>
    <p class="text-gray-600">Mettez à jour les informations de votre véhicule</p>
</div>

<div class="bg-white rounded-xl shadow-lg p-6 md:p-8 max-w-2xl">
    <form action="{{ route('vehicules.update', $vehicule) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Marque <span class="text-red-500">*</span>
                </label>
                <input type="text" name="marque" value="{{ old('marque', $vehicule->marque) }}" 
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('marque') border-red-500 @enderror" 
                    required>
                @error('marque')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Modèle <span class="text-red-500">*</span>
                </label>
                <input type="text" name="modele" value="{{ old('modele', $vehicule->modele) }}" 
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('modele') border-red-500 @enderror" 
                    required>
                @error('modele')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Immatriculation
            </label>
            <input type="text" value="{{ $vehicule->immatriculation }}" 
                class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" 
                disabled>
            <p class="mt-1 text-xs text-gray-500">L'immatriculation ne peut pas être modifiée</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Année <span class="text-red-500">*</span>
                </label>
                <input type="number" name="annee" value="{{ old('annee', $vehicule->annee) }}" min="1900" max="{{ date('Y') + 1 }}" 
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('annee') border-red-500 @enderror" 
                    required>
                @error('annee')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kilométrage <span class="text-red-500">*</span>
                </label>
                <input type="number" name="kilometrage" value="{{ old('kilometrage', $vehicule->kilometrage) }}" min="0" 
                    class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('kilometrage') border-red-500 @enderror" 
                    required>
                @error('kilometrage')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Photo du véhicule
            </label>
            @if($vehicule->photo)
                <div class="mb-4 p-4 bg-gray-100 rounded-lg text-center">
                    <img src="{{ asset('storage/' . $vehicule->photo) }}" alt="Photo du véhicule" class="h-28 rounded-lg object-cover object-center mx-auto">
                    <p class="text-xs text-gray-600 mt-2">Photo actuelle</p>
                </div>
            @endif
            <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition-colors duration-200 cursor-pointer" id="photoDropZone">
                <input type="file" name="photo" id="photoInput" accept="image/*" 
                    class="hidden"
                    onchange="updatePhotoPreview(this)">
                <div id="photoPreview" class="hidden mb-4">
                    <img id="previewImage" src="" alt="Aperçu" class="h-40 mx-auto rounded-lg object-cover">
                </div>
                <div id="photoPlaceholder">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V20m-22-8v8m-4-4h8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-600">
                        <span class="font-semibold text-blue-600">Cliquez pour ajouter</span> ou glissez une image
                    </p>
                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF jusqu'à 2MB</p>
                </div>
            </div>
            @error('photo')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                ✓ Mettre à jour
            </button>
            <a href="{{ route('vehicules.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors duration-200">
                Annuler
            </a>
        </div>
    </form>
</div>

<script>
    const photoDropZone = document.getElementById('photoDropZone');
    const photoInput = document.getElementById('photoInput');

    // Click to upload
    photoDropZone.addEventListener('click', () => photoInput.click());

    // Drag and drop
    photoDropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        photoDropZone.classList.add('border-blue-500', 'bg-blue-50');
    });

    photoDropZone.addEventListener('dragleave', () => {
        photoDropZone.classList.remove('border-blue-500', 'bg-blue-50');
    });

    photoDropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        photoDropZone.classList.remove('border-blue-500', 'bg-blue-50');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            photoInput.files = files;
            updatePhotoPreview(photoInput);
        }
    });

    function updatePhotoPreview(input) {
        const photoPreview = document.getElementById('photoPreview');
        const photoPlaceholder = document.getElementById('photoPlaceholder');
        const previewImage = document.getElementById('previewImage');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                photoPreview.classList.remove('hidden');
                photoPlaceholder.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
