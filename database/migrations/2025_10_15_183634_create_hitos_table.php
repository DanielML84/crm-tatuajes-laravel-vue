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
    Schema::create('hitos', function (Blueprint $table) {
        $table->id();

        // Relación con la tabla 'citas'
        $table->foreignId('cita_id')
              ->constrained('citas')
              ->onDelete('cascade'); // Si se borra una cita, se borran sus hitos

        // Relación con la tabla 'estados_hitos'
        $table->foreignId('estado_hito_id')
              ->constrained('estados_hitos');

        $table->string('titulo');
        $table->text('descripcion')->nullable(); // nullable() porque es opcional
        $table->date('fecha_limite')->nullable(); // nullable() porque es opcional

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hitos');
    }
};
