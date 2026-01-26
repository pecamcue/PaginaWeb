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
        Schema::create('opciones_producto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');

            $table->string('tipo_lente')->nullable(); // antirreflejante, filtro azul, etc.
            $table->string('color_sol')->nullable(); // si elige "sol"
            $table->string('indice_lente')->nullable(); // 1.5, 1.6, 1.67...

            // Graduación por ojo
            $table->string('esfera_derecho')->nullable();
            $table->string('cilindro_derecho')->nullable();
            $table->string('eje_derecho')->nullable();

            $table->string('esfera_izquierdo')->nullable();
            $table->string('cilindro_izquierdo')->nullable();
            $table->string('eje_izquierdo')->nullable();

            // Lentillas especiales
            $table->string('adicion_derecho')->nullable();
            $table->string('ojo_dominante_derecho')->nullable();
            $table->string('adicion_izquierdo')->nullable();
            $table->string('ojo_dominante_izquierdo')->nullable();

            $table->timestamps();

            $table->foreign('producto_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opciones_producto');
    }
};
