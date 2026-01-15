@extends('layouts.app')

@section('title', 'Politique de Confidentialité')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900">CheckVéhicule</h1>
                <p class="text-gray-600 mt-2">Politique de Confidentialité</p>
                <p class="text-sm text-gray-500 mt-1">Dernière mise à jour : 15 janvier 2026</p>
            </div>

            <div class="prose prose-sm max-w-none">
                <h2>1. Introduction</h2>
                <p>CheckVéhicule ("nous", "notre", "l'Application") s'engage à protéger votre vie privée. Cette Politique de Confidentialité explique comment nous collectons, utilisons, divulguons et sauvegardons vos informations.</p>

                <h2>2. Informations que Nous Collectons</h2>
                <h3>2.1 Informations Fournies Directement</h3>
                <ul>
                    <li>Nom complet</li>
                    <li>Adresse email</li>
                    <li>Mot de passe (chiffré)</li>
                    <li>Photo de profil (optionnel)</li>
                    <li>Numéro de téléphone (optionnel)</li>
                    <li>Données des véhicules</li>
                    <li>Données d'entretien</li>
                </ul>

                <h3>2.2 Informations Collectées Automatiquement</h3>
                <ul>
                    <li>Adresse IP</li>
                    <li>Type et version du navigateur</li>
                    <li>Pages visitées et durée des visites</li>
                    <li>Données d'utilisation</li>
                    <li>Cookies et technologies similaires</li>
                </ul>

                <h2>3. Utilisation des Informations</h2>
                <p>Nous utilisons vos informations pour :</p>
                <ul>
                    <li>Créer et gérer votre compte</li>
                    <li>Fournir les services de l'Application</li>
                    <li>Envoyer les rappels d'entretien</li>
                    <li>Améliorer l'Application</li>
                    <li>Communiquer avec vous</li>
                    <li>Assurer la sécurité et la conformité légale</li>
                </ul>

                <h2>4. Partage des Informations</h2>
                <p>Nous ne vendons pas vos données personnelles. Nous pouvons partager vos informations avec :</p>
                <ul>
                    <li>Nos prestataires de services (hébergement, email, etc.)</li>
                    <li>Les autorités légales si requis par la loi</li>
                    <li>Autres utilisateurs (selon vos paramètres)</li>
                </ul>

                <h2>5. Sécurité des Données</h2>
                <p>Nous mettons en place des mesures de sécurité techniques et organisationnelles pour protéger vos données contre l'accès non autorisé, la modification ou la destruction.</p>

                <h2>6. Cookies et Suivi</h2>
                <p>L'Application utilise des cookies pour :</p>
                <ul>
                    <li>Maintenir votre session</li>
                    <li>Mémoriser vos préférences</li>
                    <li>Analyser l'utilisation</li>
                </ul>
                <p>Vous pouvez désactiver les cookies dans les paramètres de votre navigateur.</p>

                <h2>7. Droits de l'Utilisateur</h2>
                <p>Vous avez le droit de :</p>
                <ul>
                    <li>Accéder à vos données personnelles</li>
                    <li>Corriger vos données</li>
                    <li>Supprimer votre compte et vos données</li>
                    <li>Refuser le traitement de vos données</li>
                    <li>Recevoir une copie de vos données</li>
                </ul>

                <h2>8. Conservation des Données</h2>
                <p>Nous conservons vos données aussi longtemps que votre compte est actif. Une fois votre compte supprimé, vos données seront effacées dans les 30 jours, sauf si la loi nous oblige à les conserver plus longtemps.</p>

                <h2>9. Modifications de cette Politique</h2>
                <p>Nous pouvons modifier cette Politique de Confidentialité à tout moment. Les modifications importantes seront communiquées via email ou un avis dans l'Application.</p>

                <h2>10. Conformité RGPD</h2>
                <p>L'Application est conforme au Règlement Général sur la Protection des Données (RGPD) de l'Union Européenne.</p>

                <h2>11. Contact</h2>
                <p>Pour des questions concernant cette Politique de Confidentialité, contactez-nous à :</p>
                <ul>
                    <li><strong>Email</strong> : privacy@checkvehicule.com</li>
                    <li><strong>Support</strong> : support@checkvehicule.com</li>
                </ul>

                <p class="mt-8 pt-8 border-t border-gray-300 text-sm text-gray-600 text-center">
                    Votre confidentialité est importante pour nous.
                </p>
            </div>

            <div class="mt-8 flex gap-4">
                <a href="{{ route('register') }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg text-center shadow-md hover:shadow-lg transition-all duration-200">
                    Retour à l'inscription
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
