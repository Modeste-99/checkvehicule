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
    // database/migrations/YYYY_MM_DD_create_rappels_table.php

{
    Schema::create('rappels', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('vehicule_id')->constrained()->onDelete('cascade');
        $table->string('type'); // 'entretien' ou 'revision'
        $table->dateTime('date_rappel');
        $table->text('notes')->nullable();
        $table->boolean('envoye')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rappels');
    }
};
