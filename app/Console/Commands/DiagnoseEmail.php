<?php

namespace App\Console\Commands;

use App\Models\Rappel;
use Illuminate\Console\Command;

class DiagnoseEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diagnose:email';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Diagnostic système d\'emails pour rappels';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("\n");
        $this->info("═══════════════════════════════════════════════════════");
        $this->info("  🔍 DIAGNOSTIC - SYSTÈME D'EMAILS POUR RAPPELS");
        $this->info("═══════════════════════════════════════════════════════");
        $this->info("");

        // 1. Configuration
        $this->line("1️⃣  CONFIGURATION MAIL");
        $this->line("   MAIL_MAILER: " . env('MAIL_MAILER'));
        $this->line("   MAIL_FROM_ADDRESS: " . env('MAIL_FROM_ADDRESS'));
        $this->line("   QUEUE_CONNECTION: " . env('QUEUE_CONNECTION'));
        $this->line("");

        // 2. Rappels en base
        $this->line("2️⃣  VÉRIFICATION DES RAPPELS EN BASE DE DONNÉES");
        $totalRappels = Rappel::count();
        $sent = Rappel::where('envoye', true)->count();
        $pending = Rappel::where('envoye', false)->count();
        
        $this->line("   Total rappels: $totalRappels");
        $this->line("   - Envoyés: $sent");
        $this->line("   - En attente: $pending");

        // 3. Rappels à envoyer
        $this->line("");
        $this->line("3️⃣  RAPPELS À ENVOYER MAINTENANT (date_rappel <= now())");
        $toSend = Rappel::where('envoye', false)
            ->where('date_rappel', '<=', now())
            ->get();

        if ($toSend->isEmpty()) {
            $this->warn("   ⚠️  AUCUN RAPPEL À ENVOYER");
            $this->line("   Raisons possibles:");
            $this->line("   - Les rappels n'ont pas encore atteint leur date");
            $this->line("   - Les rappels sont déjà marqués comme envoyés");
        } else {
            $this->info("   ✅ " . count($toSend) . " rappel(s) à envoyer");
            foreach($toSend as $r) {
                $this->line("     - Rappel #{$r->id}");
                $this->line("       User: {$r->user->name} ({$r->user->email})");
                $this->line("       Date: {$r->date_rappel}");
                $this->line("       Type: {$r->type}");
            }
        }

        // 4. Dernier rappel
        $this->line("");
        $this->line("4️⃣  DERNIER RAPPEL CRÉÉ");
        $lastRappel = Rappel::latest('created_at')->first();
        
        if ($lastRappel) {
            $this->line("   ID: {$lastRappel->id}");
            $this->line("   User: {$lastRappel->user->name} ({$lastRappel->user->email})");
            $this->line("   Date rappel: {$lastRappel->date_rappel}");
            $this->line("   Créé le: {$lastRappel->created_at}");
            $this->line("   Envoyé: " . ($lastRappel->envoye ? "OUI" : "NON"));
            
            if ($lastRappel->date_rappel <= now()) {
                $this->info("   ⏰ Status: Dans le passé - DEVRAIT ÊTRE ENVOYÉ");
            } else {
                $this->warn("   ⏰ Status: Dans le futur - Sera envoyé plus tard");
                $this->line("   Temps avant envoi: " . $lastRappel->date_rappel->diffForHumans());
            }
        } else {
            $this->line("   Aucun rappel trouvé");
        }

        $this->line("");
        $this->info("═══════════════════════════════════════════════════════");
        $this->info("  ✅ DIAGNOSTIC TERMINÉ");
        $this->info("═══════════════════════════════════════════════════════");
        $this->line("");
        
        $this->line("Pour envoyer les rappels maintenant:");
        $this->line("  php artisan rappels:send");
        $this->line("");
        $this->line("Pour vérifier les logs:");
        $this->line("  tail -f storage/logs/laravel.log");
        $this->line("");
    }
}
