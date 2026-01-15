<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TermsAcceptanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que la page d'inscription affiche le formulaire avec les termes
     */
    public function test_register_page_contains_terms_checkbox(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('accept_terms');
        $response->assertSee('J\'accepte les conditions d\'utilisation');
    }

    /**
     * Test que l'acceptation des termes est obligatoire
     */
    public function test_registration_fails_without_terms_acceptance(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'accept_terms' => false, // N'accepte pas les termes
        ]);

        $response->assertSessionHasErrors('accept_terms');
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }

    /**
     * Test que l'inscription réussit avec acceptation des termes
     */
    public function test_registration_succeeds_with_terms_acceptance(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'accept_terms' => true, // Accepte les termes
        ]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        
        $user = User::where('email', 'test@example.com')->first();
        $this->assertNotNull($user->accepted_terms_at);
        $this->assertEquals('1.0', $user->terms_version);
    }

    /**
     * Test que la page des termes est accessible
     */
    public function test_terms_page_is_accessible(): void
    {
        $response = $this->get('/terms');

        $response->assertStatus(200);
        $response->assertSee('Termes et Conditions');
    }

    /**
     * Test que la page de confidentialité est accessible
     */
    public function test_privacy_page_is_accessible(): void
    {
        $response = $this->get('/privacy');

        $response->assertStatus(200);
        $response->assertSee('Politique de Confidentialité');
    }

    /**
     * Test que la date d'acceptation est enregistrée correctement
     */
    public function test_acceptance_timestamp_is_recorded(): void
    {
        $now = now();
        
        $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'accept_terms' => true,
        ]);

        $user = User::where('email', 'test@example.com')->first();
        
        $this->assertNotNull($user->accepted_terms_at);
        $this->assertTrue($user->accepted_terms_at->between(
            $now->subSecond(),
            $now->addSecond()
        ));
    }

    /**
     * Test que la version des termes est enregistrée
     */
    public function test_terms_version_is_recorded(): void
    {
        $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'accept_terms' => true,
        ]);

        $user = User::where('email', 'test@example.com')->first();
        $this->assertEquals('1.0', $user->terms_version);
    }
}
