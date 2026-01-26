<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaGraduaciones extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla graduaciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graduaciones', function (Blueprint $table) {
            $table->id(); // Identificador único
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID del usuario, elimina en cascada
            $table->string('nombre')->nullable(); // Nombre opcional de la graduación (ej. "Gafas de cerca")
            $table->decimal('od_esfera', 5, 2)->nullable(); // Ojo derecho: Esfera
            $table->decimal('od_cilindro', 5, 2)->nullable(); // Ojo derecho: Cilindro
            $table->integer('od_eje')->nullable(); // Ojo derecho: Eje (0-180)
            $table->decimal('od_adicion', 5, 2)->nullable(); // Ojo derecho: Adición
            $table->decimal('os_esfera', 5, 2)->nullable(); // Ojo izquierdo: Esfera
            $table->decimal('os_cilindro', 5, 2)->nullable(); // Ojo izquierdo: Cilindro
            $table->integer('os_eje')->nullable(); // Ojo izquierdo: Eje (0-180)
            $table->decimal('os_adicion', 5, 2)->nullable(); // Ojo izquierdo: Adición
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    /**
     * Revierte la migración eliminando la tabla graduaciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('graduaciones');
    }
}