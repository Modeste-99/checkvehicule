@extends('layouts.app')

@section('title', 'Inscription')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-emerald-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">
        
        <!-- Images côté gauche (hidden sur mobile) -->
        <div class="hidden lg:flex flex-col gap-6 justify-start pt-12">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <img src="{{ asset('images/vehicles/truck-green.svg') }}" alt="Suivi entretien" class="w-full h-auto">
            </div>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <img src="{{ asset('images/vehicles/car-blue.svg') }}" alt="Gestion de véhicules" class="w-full h-auto">
            </div>
        </div>

        <!-- Formulaire d'inscription -->
        <div class="space-y-8">
            <div class="text-center lg:text-left">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2">CheckVehicule</h1>
                <p class="text-gray-600 text-lg">Inscrivez-vous pour accéder à votre compte</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 text-center mb-6">Créer un compte</h2>

                <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nom complet
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                            class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror" 
                            placeholder="votre nom complet" required autofocus>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                            class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror" 
                            placeholder="votre@email.com" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Mot de passe
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password-register"
                                class="w-full px-4 py-3 pr-12 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror" 
                                placeholder="••••••••" required>
                            <button type="button" onclick="togglePasswordVisibility('password-register')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors duration-200">
                                <svg id="password-register-eye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirmer le mot de passe
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password-confirmation-register"
                                class="w-full px-4 py-3 pr-12 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" 
                                placeholder="••••••••" required>
                            <button type="button" onclick="togglePasswordVisibility('password-confirmation-register')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors duration-200">
                                <svg id="password-confirmation-register-eye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <label class="flex items-start cursor-pointer">
                            <input type="checkbox" name="accept_terms" 
                                class="mt-1 w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 @error('accept_terms') border-red-500 @enderror" 
                                {{ old('accept_terms') ? 'checked' : '' }}>
                            <span class="ml-3 text-sm text-gray-700">
                                J'accepte les <a href="{{ route('terms') }}" target="_blank" class="font-semibold text-green-600 hover:text-green-800 underline">conditions d'utilisation</a> et la <a href="{{ route('privacy') }}" target="_blank" class="font-semibold text-green-600 hover:text-green-800 underline">politique de confidentialité</a>
                            </span>
                        </label>
                        @error('accept_terms')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        S'inscrire
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Déjà un compte ? 
                        <a href="{{ route('login') }}" class="font-semibold text-green-600 hover:text-green-800 transition-colors">
                            Se connecter
                        </a>
                    </p>
                </div>
            </div>

            <!-- Info cards sur mobile -->
            <div class="lg:hidden grid grid-cols-1 gap-4">
                <div class="bg-white/80 backdrop-blur rounded-lg p-4 flex items-center gap-4">
                    <svg class="w-8 h-8 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-700">Gérez vos véhicules</p>
                </div>
                <div class="bg-white/80 backdrop-blur rounded-lg p-4 flex items-center gap-4">
                    <svg class="w-8 h-8 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-700">Suivez les entretiens</p>
                </div>
                <div class="bg-white/80 backdrop-blur rounded-lg p-4 flex items-center gap-4">
                    <svg class="w-8 h-8 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-700">Recevez des rappels</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
