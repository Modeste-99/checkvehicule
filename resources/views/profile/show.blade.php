@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Mon profil</h1>
            <p class="text-gray-600">Gérez vos informations personnelles</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
            ✏️ Modifier le profil
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-lg p-6 text-center">
            <div class="mb-4">
                @if($user->photo)
                    <img src="{{ asset('storage/profiles/' . $user->photo) }}" 
                         alt="Photo de profil" 
                         class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-gray-200">
                @else
                    <div class="w-32 h-32 rounded-full mx-auto bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-4xl font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $user->name }}</h2>
            <p class="text-gray-600 mb-4">{{ $user->email }}</p>
            <div class="text-sm text-gray-500">
                <p>Membre depuis {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Informations personnelles</h3>
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nom complet</label>
                    <div class="px-4 py-3 bg-gray-50 rounded-lg border border-gray-200 text-gray-900">
                        {{ $user->name }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <div class="px-4 py-3 bg-gray-50 rounded-lg border border-gray-200 text-gray-900">
                        {{ $user->email }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Date d'inscription</label>
                    <div class="px-4 py-3 bg-gray-50 rounded-lg border border-gray-200 text-gray-900">
                        {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y à H:i') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mt-6">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Statistiques</h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <p class="text-3xl font-bold text-blue-600">{{ $user->vehicules()->count() }}</p>
                    <p class="text-sm text-gray-600 mt-1">Véhicules</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-3xl font-bold text-green-600">{{ $user->entretiens()->count() }}</p>
                    <p class="text-sm text-gray-600 mt-1">Entretiens</p>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <p class="text-3xl font-bold text-purple-600">{{ $user->garages()->count() }}</p>
                    <p class="text-sm text-gray-600 mt-1">Garages</p>
                </div>
                <div class="text-center p-4 bg-indigo-50 rounded-lg">
                    <p class="text-3xl font-bold text-indigo-600">{{ $user->cours()->count() }}</p>
                    <p class="text-sm text-gray-600 mt-1">Cours</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

