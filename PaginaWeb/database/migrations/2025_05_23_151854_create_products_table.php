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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('modelo');
            $table->string('marca');
            $table->decimal('precio', 8, 2);

            $table->enum('genero', ['Hombre', 'Mujer', 'Unisex', 'Infantil'])->nullable();
            $table->string('tamano')->nullable(); // S, M, L o medidas
            $table->string('color_montura')->nullable();
            $table->string('color_cristal')->nullable();
            $table->string('tipo_cristal')->nullable(); // Polarizada, Espejada, etc.
            $table->string('material_montura')->nullable();
            $table->string('imagen')->nullable();

            $table->enum('tipo_lentilla', ['esferica', 'torica', 'multifocal'])->nullable(); // Campo adicional

            $table->text('descripcion')->nullable();
            $table->text('informacion_adicional')->nullable();
            $table->integer('stock')->default(0);
            $table->boolean('activo')->default(true);
            $table->boolean('oferta')->default(false);
            $table->decimal('precio_oferta', 8, 2)->nullable();
            $table->string('slug')->unique();

            $table->timestamps();

            // Foreign key
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
