<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rappels', function (Blueprint $table) {
            // Ajouter des index pour optimiser les requêtes
            $table->index(['envoye', 'date_rappel']);
            $table->index('user_id');
            $table->index('vehicule_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rappels', function (Blueprint $table) {
            $table->dropIndex(['envoye', 'date_rappel']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['vehicule_id']);
        });
    }
};
