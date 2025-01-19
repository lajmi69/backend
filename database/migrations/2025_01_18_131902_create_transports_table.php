<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['avion', 'train']); // Le type de transport : avion ou train
            $table->decimal('prix_billet', 8, 2); // Prix du billet avec 2 décimales
            $table->dateTime('date_depart')->nullable(); // Date et heure de départ nullable
            $table->dateTime('date_arrivee')->nullable(); // Date et heure d'arrivée nullable
            $table->string('compagnie'); // Nom de la compagnie
            $table->integer('places_disponibles'); // Nombre de places disponibles
            $table->timestamps(); // Pour created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
