<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rappel d'entretien</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2>Rappel d'entretien - {{ ucfirst($rappel->type) }}</h2>
        
        <p>Bonjour {{ $user->name }},</p>
        
        <p>Ceci est un rappel pour l'entretien programmé de votre véhicule qui arrive à sa date prévue.</p>
        
        <h3>Détails du rappel</h3>
        <ul>
            <li><strong>Type d'entretien:</strong> {{ ucfirst($rappel->type) }}</li>
            <li><strong>Véhicule:</strong> {{ $vehicule->marque }} {{ $vehicule->modele }}</li>
            <li><strong>Immatriculation:</strong> {{ $vehicule->immatriculation }}</li>
            <li><strong>Kilométrage:</strong> {{ number_format($vehicule->kilometrage, 0, ',', ' ') }} km</li>
            <li><strong>Date prévue:</strong> {{ $rappel->date_rappel->format('d/m/Y à H:i') }}</li>
        </ul>
        
        <p style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; color: #666; font-size: 12px;">
            Cet email a été généré automatiquement par CheckVéhicule.
        </p>
    </div>
</body>
</html>
    
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
