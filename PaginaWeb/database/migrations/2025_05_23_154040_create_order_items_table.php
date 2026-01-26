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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');

            $table->integer('cantidad');
            $table->decimal('precio_unitario', 8, 2); // precio al momento de la compra

            // Graduación ojo derecho
            $table->string('od_esfera')->nullable();
            $table->string('od_cilindro')->nullable();
            $table->string('od_eje')->nullable();

            // Graduación ojo izquierdo
            $table->string('oi_esfera')->nullable();
            $table->string('oi_cilindro')->nullable();
            $table->string('oi_eje')->nullable();

            // Para lentes progresivas
            $table->string('adicion')->nullable();
            $table->string('ojo_dominante')->nullable();

            // Personalización lente
            $table->string('tipo_cristal')->nullable(); // antirreflejante, filtro azul, etc.
            $table->string('indice_lente')->nullable(); // 1.5, 1.6, etc.
            $table->string('color_cristal')->nullable(); // solo si es sol o filtro solar
            $table->string('tipo_lentilla')->nullable(); // esférica, tórica, multifocal, etc.

            $table->timestamps();

            // Claves foráneas
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
