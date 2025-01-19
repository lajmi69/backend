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
    Schema::create('reservations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('transport_id')->constrained()->onDelete('cascade'); // Clé étrangère vers transport
        $table->foreignId('hotel_id')->constrained()->onDelete('cascade'); // Clé étrangère vers hôtel
        $table->decimal('prix_transport', 8, 2); // Prix de la réservation du transport
        $table->decimal('prix_hotel', 8, 2); // Prix de la réservation de l'hôtel
        $table->decimal('prix_total', 8, 2); // Prix total de la réservation
        $table->date('date_reservation'); // Date de la réservation
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
