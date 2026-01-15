@extends('layouts.app')

@section('title', 'Termes et Conditions')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900">CheckVéhicule</h1>
                <p class="text-gray-600 mt-2">Termes et Conditions d'Utilisation</p>
                <p class="text-sm text-gray-500 mt-1">Dernière mise à jour : 15 janvier 2026</p>
            </div>

            <div class="prose prose-sm max-w-none">
                <h2>1. Acceptation des Termes</h2>
                <p>En accédant et en utilisant CheckVéhicule (ci-après "l'Application"), vous acceptez sans réserve l'intégralité de ces termes et conditions d'utilisation. Si vous n'êtes pas d'accord avec l'un quelconque de ces termes, veuillez cesser d'utiliser immédiatement l'Application.</p>

                <h2>2. Description du Service</h2>
                <p>CheckVéhicule est une application de gestion de véhicules et d'entretien qui permet aux utilisateurs de :</p>
                <ul>
                    <li>Enregistrer et gérer leurs véhicules</li>
                    <li>Planifier et suivre les entretiens</li>
                    <li>Recevoir des rappels d'entretien</li>
                    <li>Gérer les garages et prestataires</li>
                    <li>Consulter l'historique d'entretien</li>
                </ul>

                <h2>3. Conditions d'Accès</h2>
                <h3>3.1 Âge et Capacité Juridique</h3>
                <p>Vous devez être majeur (18 ans ou plus) pour utiliser cette Application. En utilisant l'Application, vous certifiez que vous avez l'âge légal requis et que vous disposez de la capacité juridique pour conclure des contrats.</p>

                <h3>3.2 Création de Compte</h3>
                <p>Pour accéder à certaines fonctionnalités, vous devez créer un compte utilisateur. Vous vous engagez à :</p>
                <ul>
                    <li>Fournir des informations exactes et à jour</li>
                    <li>Maintenir la confidentialité de votre mot de passe</li>
                    <li>Accepter toute responsabilité concernant les activités sous votre compte</li>
                    <li>Notifier immédiatement tout accès non autorisé</li>
                </ul>

                <h3>3.3 Restriction d'Utilisation</h3>
                <p>Vous acceptez de ne pas :</p>
                <ul>
                    <li>Utiliser l'Application de manière illégale ou non autorisée</li>
                    <li>Violer les droits d'autres utilisateurs</li>
                    <li>Transmettre des virus ou codes malveillants</li>
                    <li>Tenter d'accéder à des parties non autorisées</li>
                    <li>Automatiser l'accès sans permission (scraping, bots)</li>
                </ul>

                <h2>4. Propriété Intellectuelle</h2>
                <h3>4.1 Contenus de l'Application</h3>
                <p>Tous les contenus, designs, logos, textes et codes de l'Application sont la propriété exclusive de CheckVéhicule ou de ses licencieurs. Vous ne pouvez pas les reproduire, modifier ou distribuer sans autorisation écrite préalable.</p>

                <h3>4.2 Contenus de l'Utilisateur</h3>
                <p>Vous conservez la propriété de vos données (véhicules, entretiens, etc.). En utilisant l'Application, vous nous accordez une licence pour stocker, traiter et afficher ces données afin de fournir le service.</p>

                <h2>5. Protection des Données</h2>
                <h3>5.1 Collecte et Utilisation des Données</h3>
                <p>Nous collectons et traitons vos données personnelles conformément à notre Politique de Confidentialité. Les données collectées incluent :</p>
                <ul>
                    <li>Informations personnelles (nom, email, téléphone)</li>
                    <li>Données des véhicules</li>
                    <li>Informations d'entretien</li>
                    <li>Adresses IP et données de navigation</li>
                </ul>

                <h3>5.2 Sécurité des Données</h3>
                <p>Nous mettons en œuvre des mesures de sécurité raisonnables. Cependant, aucun système n'est totalement sécurisé. Vous reconnaissez les risques inhérents à la transmission de données en ligne.</p>

                <h2>6. Responsabilité et Disclaimers</h2>
                <h3>6.1 Limitation de Responsabilité</h3>
                <p>L'Application est fournie "en l'état" sans garanties d'aucune sorte, explicites ou implicites. CheckVéhicule ne garantit pas :</p>
                <ul>
                    <li>La disponibilité ininterrompue du service</li>
                    <li>L'absence d'erreurs ou de bugs</li>
                    <li>Que l'Application répondra à vos besoins spécifiques</li>
                    <li>L'exactitude complète des rappels d'entretien</li>
                </ul>

                <h3>6.2 Dommages Exclus</h3>
                <p>En aucun cas CheckVéhicule ne sera responsable de dommages directs ou indirects, y compris la perte de données ou l'interruption d'activité.</p>

                <h2>7. Rappels d'Entretien</h2>
                <p>Les rappels générés sont basés sur les données que vous avez entrées et les calendriers d'entretien standard. Vous êtes seul responsable de vérifier indépendamment les rappels et de consulter un professionnel pour les décisions d'entretien.</p>

                <h2>8. Modifications du Service</h2>
                <p>CheckVéhicule se réserve le droit de modifier ou discontinuer l'Application ou ses fonctionnalités. Les modifications matérielles seront annoncées avec un préavis raisonnable.</p>

                <h2>9. Fermeture de Compte</h2>
                <h3>9.1 Fermeture par l'Utilisateur</h3>
                <p>Vous pouvez fermer votre compte à tout moment. Vos données seront supprimées selon notre Politique de Confidentialité.</p>

                <h3>9.2 Fermeture par CheckVéhicule</h3>
                <p>Nous pouvons fermer votre compte si vous violez ces termes, vous engagez dans une activité illégale ou abusez du service.</p>

                <h2>10. Communications</h2>
                <h3>10.1 Notifications</h3>
                <p>Vous consentez à recevoir :</p>
                <ul>
                    <li>Rappels d'entretien par email/SMS (selon vos paramètres)</li>
                    <li>Notifications de compte importantes</li>
                    <li>Mises à jour de service</li>
                </ul>

                <h3>10.2 Opt-Out</h3>
                <p>Vous pouvez vous désabonner des communications marketing à tout moment via les paramètres de votre compte.</p>

                <h2>11. Conformité Légale</h2>
                <p>Ces termes sont régis par la loi applicable et tout différend sera soumis à ses tribunaux compétents.</p>

                <h2>12. Contact</h2>
                <p>Pour toute question ou réclamation concernant ces termes, contactez-nous à :</p>
                <ul>
                    <li><strong>Email</strong> : support@checkvehicule.com</li>
                    <li><strong>Formulaire de contact</strong> : Disponible dans l'Application</li>
                </ul>

                <p class="mt-8 pt-8 border-t border-gray-300 text-sm text-gray-600 text-center">
                    En utilisant CheckVéhicule, vous reconnaissez avoir lu, compris et accepté tous ces termes et conditions.
                </p>
            </div>

            <div class="mt-8 flex gap-4">
                <a href="{{ route('register') }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg text-center shadow-md hover:shadow-lg transition-all duration-200">
                    J'accepte et je m'inscris
                </a>
                <a href="javascript:history.back()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg text-center shadow-md hover:shadow-lg transition-all duration-200">
                    Retour
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
