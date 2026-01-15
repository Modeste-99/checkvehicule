#!/bin/bash
# Script helper pour gérer les rappels par email

echo "═════════════════════════════════════════════════════"
echo "  GESTION DES RAPPELS PAR EMAIL - CheckVéhicule"
echo "═════════════════════════════════════════════════════"
echo ""

# Fonction pour afficher le menu
show_menu() {
    echo "1. Tester le système d'emails"
    echo "2. Envoyer les rappels en attente"
    echo "3. Voir les rappels pas encore envoyés"
    echo "4. Voir tous les rappels envoyés"
    echo "5. Voir les logs d'emails"
    echo "6. Exécuter les tests automatisés"
    echo "7. Créer un rappel de test"
    echo "8. Quitter"
    echo ""
}

# Fonction pour tester le système
test_system() {
    echo "🧪 Test du système d'emails..."
    php artisan mail:send \
        --view='emails.rappel' \
        --markdown
    echo "✅ Test terminé. Vérifiez storage/logs/laravel.log"
}

# Fonction pour envoyer les rappels
send_reminders() {
    echo "📧 Envoi des rappels en attente..."
    php artisan rappels:send
}

# Fonction pour voir les rappels pas envoyés
see_pending() {
    echo "⏳ Rappels en attente d'envoi :"
    echo ""
    php artisan tinker << 'EOF'
use App\Models\Rappel;
$rappels = Rappel::where('envoye', false)
    ->where('date_rappel', '<=', now())
    ->with(['user', 'vehicule'])
    ->get();

if ($rappels->isEmpty()) {
    echo "✅ Aucun rappel en attente d'envoi\n";
} else {
    echo count($rappels) . " rappel(s) en attente :\n";
    foreach ($rappels as $r) {
        echo "  - {$r->user->name} : {$r->vehicule->marque} {$r->vehicule->modele} ({$r->type})\n";
        echo "    Date : {$r->date_rappel->format('d/m/Y H:i')}\n";
    }
}
exit
EOF
}

# Fonction pour voir les rappels envoyés
see_sent() {
    echo "📬 Rappels envoyés (50 derniers) :"
    echo ""
    php artisan tinker << 'EOF'
use App\Models\Rappel;
$rappels = Rappel::where('envoye', true)
    ->with(['user', 'vehicule'])
    ->orderBy('updated_at', 'desc')
    ->limit(50)
    ->get();

if ($rappels->isEmpty()) {
    echo "Aucun rappel envoyé\n";
} else {
    foreach ($rappels as $r) {
        echo "✅ {$r->updated_at->format('d/m/Y H:i')} - {$r->user->email} : {$r->vehicule->marque}\n";
    }
}
exit
EOF
}

# Fonction pour voir les logs
see_logs() {
    echo "📋 Derniers logs (Ctrl+C pour quitter) :"
    echo ""
    tail -f storage/logs/laravel.log | grep -i "rappel\|mail\|error" | head -50
}

# Fonction pour exécuter les tests
run_tests() {
    echo "🧪 Exécution des tests automatisés..."
    echo ""
    php artisan test tests/Feature/RappelEmailTest.php
}

# Fonction pour créer un rappel de test
create_test() {
    echo "➕ Création d'un rappel de test..."
    echo ""
    php artisan tinker << 'EOF'
use App\Models\User, App\Models\Vehicule, App\Models\Rappel;

// Récupérer le premier utilisateur
$user = User::first();
if (!$user) {
    echo "❌ Aucun utilisateur trouvé. Créez-en un d'abord.\n";
    exit;
}

// Récupérer un véhicule ou en créer un
$vehicule = $user->vehicules()->first();
if (!$vehicule) {
    $vehicule = Vehicule::factory()->create(['user_id' => $user->id]);
    echo "✅ Véhicule créé : {$vehicule->marque} {$vehicule->modele}\n";
}

// Créer un rappel pour maintenant
$rappel = Rappel::create([
    'user_id' => $user->id,
    'vehicule_id' => $vehicule->id,
    'type' => 'entretien',
    'date_rappel' => now()->subMinutes(1),
    'notes' => 'Rappel de test - créé ' . now()->format('d/m/Y H:i'),
    'envoye' => false
]);

echo "✅ Rappel de test créé :\n";
echo "   ID : {$rappel->id}\n";
echo "   User : {$user->email}\n";
echo "   Véhicule : {$vehicule->marque} {$vehicule->modele}\n";
echo "   Date : {$rappel->date_rappel->format('d/m/Y H:i')}\n";
echo "\n";
echo "🚀 Maintenant exécutez : php artisan rappels:send\n";
exit
EOF
}

# Boucle principale
while true; do
    echo ""
    show_menu
    read -p "Choisissez une option [1-8] : " choice
    
    case $choice in
        1) test_system ;;
        2) send_reminders ;;
        3) see_pending ;;
        4) see_sent ;;
        5) see_logs ;;
        6) run_tests ;;
        7) create_test ;;
        8) echo "Au revoir !"; exit 0 ;;
        *) echo "❌ Option invalide" ;;
    esac
done
