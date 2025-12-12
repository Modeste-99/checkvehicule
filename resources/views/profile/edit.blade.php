@extends('layouts.app')

@section('title', 'Modifier mon profil')

@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Modifier mon profil</h1>
    <p class="text-gray-600">Mettez à jour vos informations personnelles</p>
</div>

<div class="bg-white rounded-xl shadow-lg p-6 md:p-8 max-w-3xl">
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="text-center mb-6">
            <div class="inline-block relative">
                @if($user->photo)
                    <img src="{{ asset('storage/profiles/' . $user->photo) }}" 
                         alt="Photo de profil actuelle" 
                         id="photoPreview"
                         class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-gray-200">
                @else
                    <div id="photoPreview" class="w-32 h-32 rounded-full mx-auto bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-4xl font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <label for="photo" class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full cursor-pointer hover:bg-blue-700 transition-colors shadow-lg">
                    <span class="text-xl">📷</span>
                    <input type="file" id="photo" name="photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                </label>
            </div>
            <p class="text-sm text-gray-500 mt-2">Cliquez sur l'icône pour changer votre photo</p>
            @error('photo')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Nom complet <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror" 
                required>
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Email <span class="text-red-500">*</span>
            </label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror" 
                required>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Changer le mot de passe</h3>
            <p class="text-sm text-gray-600 mb-4">Laissez vide si vous ne souhaitez pas changer votre mot de passe</p>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nouveau mot de passe
                    </label>
                    <input type="password" name="password" 
                        class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror" 
                        placeholder="Laissez vide pour ne pas changer">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Confirmer le nouveau mot de passe
                    </label>
                    <input type="password" name="password_confirmation" 
                        class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                        placeholder="Confirmez le nouveau mot de passe">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                ✓ Enregistrer les modifications
            </button>
            <a href="{{ route('profile.show') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors duration-200">
                Annuler
            </a>
        </div>
    </form>
</div>

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                // Remplacer la div par une image
                const img = document.createElement('img');
                img.id = 'photoPreview';
                img.src = e.target.result;
                img.className = 'w-32 h-32 rounded-full mx-auto object-cover border-4 border-gray-200';
                preview.parentNode.replaceChild(img, preview);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection

