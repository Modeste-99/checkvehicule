<?php

namespace App\Console\Commands;

use App\Models\Rappel;
use App\Models\User;
use App\Models\Vehicule;
use Illuminate\Console\Command;

class TestRappelEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rappels:test {--user-id=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer un rappel de test et l\'envoyer immédiatement';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user-id');
        
        $user = User::find($userId);
        if (!$user) {
            $this->error("❌ Utilisateur avec l'ID $userId non trouvé");
            return;
        }

        $vehicule = $user->vehicules()->first();
        if (!$vehicule) {
            $this->error("❌ {$user->name} n'a pas de véhicule");
            return;
        }

        // Créer un rappel pour maintenant
        $rappel = Rappel::create([
            'user_id' => $user->id,
            'vehicule_id' => $vehicule->id,
            'type' => fake()->randomElement(['entretien', 'revision']),
            'date_rappel' => now()->subMinutes(1),
            'notes' => 'Rappel de test créé ' . now()->format('d/m/Y H:i:s'),
            'envoye' => false,
        ]);

        $this->info('✅ Rappel de test créé :');
        $this->info("   ID: {$rappel->id}");
        $this->info("   User: {$user->email}");
        $this->info("   Véhicule: {$vehicule->marque} {$vehicule->modele}");
        $this->info("   Type: {$rappel->type}");
        $this->info("   Date: {$rappel->date_rappel->format('d/m/Y H:i')}");
        $this->newLine();

        // Envoyer le rappel
        $this->info('📧 Envoi du rappel...');
        \Illuminate\Support\Facades\Artisan::call('rappels:send');
        
        $this->newLine();
        if ($rappel->refresh()->envoye) {
            $this->info('✅ Email envoyé avec succès !');
            $this->info('💡 Vérifiez votre email ou les logs :');
            $this->info('   tail -f storage/logs/laravel.log');
        } else {
            $this->warn('⚠️  Email non envoyé. Vérifiez la configuration mail.');
        }
    }
}
