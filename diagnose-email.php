<?php

use App\Models\Rappel;
use App\Models\User;

// Script de diagnostic - Mettre dans routes/console.php ou exécuter en tinker

echo "\n";
echo "═══════════════════════════════════════════════════════\n";
echo "  🔍 DIAGNOSTIC - SYSTÈME D'EMAILS POUR RAPPELS\n";
echo "═══════════════════════════════════════════════════════\n";
echo "\n";

// 1. Vérifier la configuration mail
echo "1️⃣  CONFIGURATION MAIL\n";
echo "   MAIL_MAILER: " . env('MAIL_MAILER') . "\n";
echo "   MAIL_FROM_ADDRESS: " . env('MAIL_FROM_ADDRESS') . "\n";
echo "   QUEUE_CONNECTION: " . env('QUEUE_CONNECTION') . "\n";
echo "\n";

// 2. Vérifier les rappels en base de données
echo "2️⃣  VÉRIFICATION DES RAPPELS EN BASE DE DONNÉES\n";
$allRappels = Rappel::all();
echo "   Total rappels: " . count($allRappels) . "\n";
echo "   - Envoyés: " . Rappel::where('envoye', true)->count() . "\n";
echo "   - En attente: " . Rappel::where('envoye', false)->count() . "\n";

// 3. Rappels à envoyer
echo "\n3️⃣  RAPPELS À ENVOYER MAINTENANT (date_rappel <= now())\n";
$toSend = Rappel::where('envoye', false)
    ->where('date_rappel', '<=', now())
    ->get();

if ($toSend->isEmpty()) {
    echo "   ⚠️  AUCUN RAPPEL À ENVOYER\n";
    echo "   Raisons possibles :\n";
    echo "   - Les rappels n'ont pas encore atteint leur date\n";
    echo "   - Les rappels sont déjà marqués comme envoyés (envoye=true)\n";
} else {
    echo "   ✅ " . count($toSend) . " rappel(s) à envoyer\n";
    foreach($toSend as $r) {
        echo "     - Rappel #{$r->id}\n";
        echo "       User: {$r->user->name} ({$r->user->email})\n";
        echo "       Véhicule: {$r->vehicule->marque} {$r->vehicule->modele}\n";
        echo "       Date: {$r->date_rappel}\n";
        echo "       Type: {$r->type}\n";
    }
}

// 4. Détails du dernier rappel créé
echo "\n4️⃣  DERNIER RAPPEL CRÉÉ\n";
$lastRappel = Rappel::latest('created_at')->first();
if ($lastRappel) {
    echo "   ID: {$lastRappel->id}\n";
    echo "   User: {$lastRappel->user->name} ({$lastRappel->user->email})\n";
    echo "   Date rappel: {$lastRappel->date_rappel}\n";
    echo "   Créé le: {$lastRappel->created_at}\n";
    echo "   Envoyé: " . ($lastRappel->envoye ? "OUI" : "NON") . "\n";
    
    // Vérifier si c'est dans le passé
    if ($lastRappel->date_rappel <= now()) {
        echo "   ⏰ Status: Dans le passé - DEVRAIT ÊTRE ENVOYÉ\n";
    } else {
        echo "   ⏰ Status: Dans le futur - N'SERA ENVOYÉ QUE PLUS TARD\n";
        echo "   Temps avant envoi: " . $lastRappel->date_rappel->diffForHumans() . "\n";
    }
} else {
    echo "   Aucun rappel trouvé\n";
}

// 5. Vérifier les logs
echo "\n5️⃣  VÉRIFIER LES LOGS\n";
echo "   Fichier: storage/logs/laravel.log\n";
echo "   Commande pour voir les logs:\n";
echo "   tail -f storage/logs/laravel.log\n";

echo "\n═══════════════════════════════════════════════════════\n";
echo "  ✅ DIAGNOSTIC TERMINÉ\n";
echo "═══════════════════════════════════════════════════════\n\n";
