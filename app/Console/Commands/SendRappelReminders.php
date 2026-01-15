<?php

namespace App\Console\Commands;

use App\Jobs\SendRappelEmail;
use App\Models\Rappel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendRappelReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rappels:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoyer les emails de rappels programmés';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Récupérer tous les rappels dont la date est passée et non envoyés
        $rappels = Rappel::where('envoye', false)
            ->where('date_rappel', '<=', now())
            ->get();

        if ($rappels->isEmpty()) {
            $this->info('Aucun rappel à envoyer.');
            return;
        }

        // Dispatcher le job pour chaque rappel
        foreach ($rappels as $rappel) {
            try {
                SendRappelEmail::dispatch($rappel);
                $this->info("Rappel envoyé à {$rappel->user->email} pour le véhicule {$rappel->vehicule->marque} {$rappel->vehicule->modele}");
                Log::info("Rappel envoyé", ['rappel_id' => $rappel->id, 'user_id' => $rappel->user_id]);
            } catch (\Exception $e) {
                $this->error("Erreur lors de l'envoi du rappel ID {$rappel->id}: " . $e->getMessage());
                Log::error("Erreur envoi rappel", ['rappel_id' => $rappel->id, 'error' => $e->getMessage()]);
            }
        }

        $this->info(count($rappels) . ' rappel(s) envoyé(s) avec succès.');
    }
}
