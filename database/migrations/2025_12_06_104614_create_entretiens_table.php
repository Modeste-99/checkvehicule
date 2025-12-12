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
        Schema::create('entretiens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicule_id')->constrained()->onDelete('cascade');
            $table->string('type'); // ex: vidange, pneus, frein...
            $table->date('date_entretien');
            $table->integer('kilometrage')->nullable();
            $table->float('prix')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entretiens');
    }
};
