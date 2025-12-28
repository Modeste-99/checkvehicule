<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enregistrement des politiques d'autorisation
        Gate::before(function ($user, $ability) {
            if ($user->is_admin) {
                return true;
            }
        });
        
        // Enregistrement de la politique pour les rappels
        Gate::policy(\App\Models\Rappel::class, \App\Policies\RappelPolicy::class);
    }
}
