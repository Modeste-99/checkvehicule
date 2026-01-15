<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class VerifyTermsAcceptance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'terms:verify {--user_id= : Vérifier un utilisateur spécifique}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifie l\'acceptation des termes et conditions par les utilisateurs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user_id');

        if ($userId) {
            $user = User::find($userId);
            if (!$user) {
                $this->error("Utilisateur avec l'ID {$userId} non trouvé.");
                return 1;
            }

            $this->displayUserTermsStatus($user);
        } else {
            $this->displayAllUsersTermsStatus();
        }

        return 0;
    }

    /**
     * Affiche le statut d'acceptation pour un utilisateur
     */
    private function displayUserTermsStatus(User $user)
    {
        $this->info("=== Acceptation des Termes ===\n");
        $this->line("Utilisateur: {$user->name} ({$user->email})");
        
        if ($user->accepted_terms_at) {
            $this->info("✓ Termes acceptés");
            $this->line("Date: {$user->accepted_terms_at->format('d/m/Y à H:i:s')}");
            $this->line("Version: {$user->terms_version}");
        } else {
            $this->warn("✗ Termes NON acceptés");
        }
    }

    /**
     * Affiche le statut d'acceptation pour tous les utilisateurs
     */
    private function displayAllUsersTermsStatus()
    {
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->warn("Aucun utilisateur trouvé.");
            return;
        }

        $this->info("=== Statut d'Acceptation des Termes ===\n");

        $accepted = [];
        $notAccepted = [];

        foreach ($users as $user) {
            if ($user->accepted_terms_at) {
                $accepted[] = $user;
            } else {
                $notAccepted[] = $user;
            }
        }

        // Afficher les utilisateurs ayant accepté
        if (!empty($accepted)) {
            $this->line("✓ Termes acceptés ({count($accepted)}):");
            foreach ($accepted as $user) {
                $date = $user->accepted_terms_at->format('d/m/Y H:i');
                $this->line("  - {$user->name} ({$user->email}) - {$date} - v{$user->terms_version}");
            }
            $this->line("");
        }

        // Afficher les utilisateurs n'ayant pas accepté
        if (!empty($notAccepted)) {
            $this->warn("✗ Termes NON acceptés ({count($notAccepted)}):");
            foreach ($notAccepted as $user) {
                $this->line("  - {$user->name} ({$user->email})");
            }
        }

        // Résumé
        $this->line("\n=== RÉSUMÉ ===");
        $this->info("Acceptés: " . count($accepted) . "/" . count($users));
        $this->warn("Non acceptés: " . count($notAccepted) . "/" . count($users));
    }
}
