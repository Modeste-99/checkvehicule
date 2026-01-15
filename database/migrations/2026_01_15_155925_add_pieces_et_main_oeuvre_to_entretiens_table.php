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
        Schema::table('entretiens', function (Blueprint $table) {
            $table->decimal('prix_pieces', 10, 2)->nullable()->after('prix');
            $table->decimal('prix_main_oeuvre', 10, 2)->nullable()->after('prix_pieces');
            // Le champ prix devient calculé (prix_pieces + prix_main_oeuvre)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entretiens', function (Blueprint $table) {
            $table->dropColumn(['prix_pieces', 'prix_main_oeuvre']);
        });
    }
};
