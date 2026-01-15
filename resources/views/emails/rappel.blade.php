@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    # Rappel d'entretien - {{ ucfirst($rappel->type) }}

    Bonjour {{ $user->name }},

    Ceci est un rappel pour l'entretien programmé de votre véhicule qui arrive à sa date prévue.

    ## Détails du rappel

    - **Type d'entretien** : {{ ucfirst($rappel->type) }}
    - **Véhicule** : {{ $vehicule->marque }} {{ $vehicule->modele }}
    - **Immatriculation** : {{ $vehicule->immatriculation }}
    - **Kilométrage** : {{ number_format($vehicule->kilometrage, 0, ',', ' ') }} km
    - **Date prévue** : {{ $rappel->date_rappel->format('d/m/Y à H:i') }}
    
    @if($rappel->notes)
    **Notes** : {{ $rappel->notes }}
    @endif

    ## Action requise

    Veuillez prendre rendez-vous avec un garage pour effectuer cet entretien dès que possible afin de maintenir votre véhicule en bon état.

    @component('mail::button', ['url' => route('vehicules.index')])
        Voir mes véhicules
    @endcomponent

    Cordialement,  
    L'équipe {{ config('app.name') }}

    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
        @endcomponent
    @endslot
@endcomponent
