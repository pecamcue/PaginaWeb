<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('resenyas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuario que reseña
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Producto reseñado
            $table->integer('rating')->unsigned()->check('rating >= 1 AND rating <= 5'); // Valoración 1-5 estrellas
            $table->text('comentario')->nullable(); // Comentario opcional (cambiado de 'comment')
            $table->unique(['user_id', 'product_id']); // Evita reseñas duplicadas
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resenyas');
    }
};