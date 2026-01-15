@extends('layouts.app')

@section('title', 'Connexion')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
        
        <!-- Images côté gauche (hidden sur mobile) -->
        <div class="hidden lg:flex flex-col gap-6 justify-center">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <img src="{{ asset('images/vehicles/car-blue.svg') }}" alt="Gestion de véhicules" class="w-full h-auto">
            </div>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <img src="{{ asset('images/vehicles/car-orange.svg') }}" alt="Rappels d'entretien" class="w-full h-auto">
            </div>
        </div>

        <!-- Formulaire de connexion -->
        <div class="space-y-8">
            <div class="text-center lg:text-left">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2">CheckVehicule</h1>
                <p class="text-gray-600 text-lg">Connectez-vous pour accéder à votre compte</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 text-center mb-6">Connexion</h2>

                <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                            class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror" 
                            placeholder="votre@email.com" required autofocus>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Mot de passe
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password-login"
                                class="w-full px-4 py-3 pr-12 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror" 
                                placeholder="••••••••" required>
                            <button type="button" onclick="togglePasswordVisibility('password-login')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors duration-200">
                                <svg id="password-login-eye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" 
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Se souvenir de moi
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        Se connecter
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Pas encore de compte ? 
                        <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                            Créer un compte
                        </a>
                    </p>
                </div>
            </div>

            <!-- Info cards sur mobile -->
            <div class="lg:hidden grid grid-cols-1 gap-4">
                <div class="bg-white/80 backdrop-blur rounded-lg p-4 flex items-center gap-4">
                    <svg class="w-8 h-8 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-700">Gérez vos véhicules facilement</p>
                </div>
                <div class="bg-white/80 backdrop-blur rounded-lg p-4 flex items-center gap-4">
                    <svg class="w-8 h-8 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-700">Recevez des rappels d'entretien</p>
                </div>
                <div class="bg-white/80 backdrop-blur rounded-lg p-4 flex items-center gap-4">
                    <svg class="w-8 h-8 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-700">Suivez l'historique complet</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
