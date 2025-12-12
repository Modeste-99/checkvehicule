@extends('layouts.app')

@section('title', 'Inscription')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-emerald-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">🚗 CheckVehicule</h1>
            <p class="text-gray-600">Inscrivez-vous pour accéder à votre compte</p>
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
                    <input type="password" name="password" 
                        class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror" 
                        placeholder="••••••••" required>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Confirmer le mot de passe
                    </label>
                    <input type="password" name="password_confirmation" 
                        class="w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" 
                        placeholder="••••••••" required>
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
    </div>
</div>

@endsection
