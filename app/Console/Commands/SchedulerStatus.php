<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SchedulerStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:status';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Affiche le statut du scheduler Laravel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("\n");
        $this->info("═══════════════════════════════════════════════════════");
        $this->info("  📅 STATUT DU SCHEDULER LARAVEL");
        $this->info("═══════════════════════════════════════════════════════");
        $this->info("");

        $this->warn("Le Scheduler Laravel doit fonctionner en continu.");
        $this->line("");

        $this->line("Pour démarrer le scheduler, exécutez:");
        $this->info("  php artisan schedule:run");
        $this->line("");

        $this->line("Ou, pour un fonctionnement continu en arrière-plan:");
        $this->info("  php artisan schedule:work");
        $this->line("");

        $this->line("📌 Important:");
        $this->line("  - schedule:work surveille le scheduler toutes les minutes");
        $this->line("  - schedule:run exécute une fois et se termine");
        $this->line("  - Pour production, utilisez cron: */1 * * * * php /chemin/artisan schedule:run");
        $this->line("");

        $this->info("Tâche programmée:");
        $this->line("  ✓ Envoi des rappels toutes les minutes");
        $this->line("  ✓ Évite les doublons avec withoutOverlapping()");
        $this->line("  ✓ S'exécute en arrière-plan");
        $this->line("");

        $this->info("═══════════════════════════════════════════════════════");
        $this->info("");
    }
}
