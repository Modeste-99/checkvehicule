<?php

namespace Tests\Feature;

use App\Jobs\SendRappelEmail;
use App\Mail\RappelEmail;
use App\Models\Rappel;
use App\Models\User;
use App\Models\Vehicule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RappelEmailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test d'envoi d'email pour un rappel
     */
    public function test_email_sent_for_rappel(): void
    {
        Mail::fake();

        // Créer un utilisateur et un véhicule
        $user = User::factory()->create();
        $vehicule = Vehicule::factory()->create(['user_id' => $user->id]);

        // Créer un rappel
        $rappel = Rappel::create([
            'user_id' => $user->id,
            'vehicule_id' => $vehicule->id,
            'type' => 'entretien',
            'date_rappel' => now()->subHours(1),
            'notes' => 'Test email',
            'envoye' => false,
        ]);

        // Dispatcher le job
        SendRappelEmail::dispatch($rappel);

        // Vérifier que l'email a été envoyé
        Mail::assertSent(RappelEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        // Vérifier que le rappel est marqué comme envoyé
        $this->assertTrue($rappel->refresh()->envoye);
    }

    /**
     * Test de la commande d'envoi de rappels
     */
    public function test_send_rappel_reminders_command(): void
    {
        Mail::fake();

        // Créer des utilisateurs et véhicules
        $user = User::factory()->create();
        $vehicule = Vehicule::factory()->create(['user_id' => $user->id]);

        // Créer des rappels
        $pastRappel = Rappel::create([
            'user_id' => $user->id,
            'vehicule_id' => $vehicule->id,
            'type' => 'entretien',
            'date_rappel' => now()->subHours(1),
            'notes' => 'Rappel passé',
            'envoye' => false,
        ]);

        $futureRappel = Rappel::create([
            'user_id' => $user->id,
            'vehicule_id' => $vehicule->id,
            'type' => 'revision',
            'date_rappel' => now()->addDays(5),
            'notes' => 'Rappel futur',
            'envoye' => false,
        ]);

        // Exécuter la commande
        $this->artisan('rappels:send')
            ->expectsOutput('1 rappel(s) envoyé(s) avec succès.');

        // Vérifier que seul le rappel passé a été envoyé
        $this->assertTrue($pastRappel->refresh()->envoye);
        $this->assertFalse($futureRappel->refresh()->envoye);

        // Vérifier que l'email a été envoyé
        Mail::assertSent(RappelEmail::class);
    }

    /**
     * Test qu'aucun email n'est envoyé pour les rappels déjà envoyés
     */
    public function test_no_duplicate_email_sent(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $vehicule = Vehicule::factory()->create(['user_id' => $user->id]);

        $rappel = Rappel::create([
            'user_id' => $user->id,
            'vehicule_id' => $vehicule->id,
            'type' => 'entretien',
            'date_rappel' => now()->subHours(1),
            'envoye' => true, // Déjà envoyé
        ]);

        // Exécuter la commande
        $this->artisan('rappels:send')
            ->expectsOutput('Aucun rappel à envoyer.');

        // Vérifier qu'aucun email n'a été envoyé
        Mail::assertNothingSent();
    }
}
