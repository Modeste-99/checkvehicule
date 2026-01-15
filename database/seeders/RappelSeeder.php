<?php

namespace Database\Seeders;

use App\Models\Rappel;
use App\Models\Vehicule;
use App\Models\User;
use Illuminate\Database\Seeder;

class RappelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des rappels de test
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->info('Aucun utilisateur trouvé. Créez d\'abord un utilisateur.');
            return;
        }

        foreach ($users as $user) {
            $vehicules = $user->vehicules;
            
            if ($vehicules->isEmpty()) {
                $this->command->info("Aucun véhicule pour {$user->name}. Créez un véhicule d'abord.");
                continue;
            }

            // Créer plusieurs rappels
            foreach ($vehicules->take(2) as $vehicule) {
                // Rappel passé (pour test d'envoi)
                Rappel::create([
                    'user_id' => $user->id,
                    'vehicule_id' => $vehicule->id,
                    'type' => fake()->randomElement(['entretien', 'revision']),
                    'date_rappel' => now()->subHours(1),
                    'notes' => 'Rappel de test - ' . fake()->sentence(),
                    'envoye' => false,
                ]);

                // Rappel futur
                Rappel::create([
                    'user_id' => $user->id,
                    'vehicule_id' => $vehicule->id,
                    'type' => fake()->randomElement(['entretien', 'revision']),
                    'date_rappel' => now()->addDays(fake()->numberBetween(1, 30)),
                    'notes' => 'Rappel futur - ' . fake()->sentence(),
                    'envoye' => false,
                ]);
            }
        }

        $this->command->info('Rappels de test créés avec succès!');
    }
}
