@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    # Rappel : {{ ucfirst($rappel->type) }} pour votre véhicule

    Bonjour {{ $rappel->user->name }},

    Vous avez programmé un rappel pour :

    - **Type** : {{ ucfirst($rappel->type) }}
    - **Véhicule** : {{ $rappel->vehicule->marque }} {{ $rappel->vehicule->modele }} ({{ $rappel->vehicule->immatriculation }})
    - **Date prévue** : {{ $rappel->date_rappel->format('d/m/Y à H:i') }}
    
    @if($rappel->notes)
    - **Notes** : {{ $rappel->notes }}
    @endif

    @component('mail::button', ['url' => route('dashboard')])
        Voir le tableau de bord
    @endcomponent

    Cordialement,  
    L'équipe {{ config('app.name') }}

    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
        @endcomponent
    @endslot
@endcomponent
