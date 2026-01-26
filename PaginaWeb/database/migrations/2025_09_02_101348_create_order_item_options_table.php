<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_item_options', function (Blueprint $table) {
            $table->id();

            // Relación -> cada opción pertenece a un order_item
            $table->foreignId('order_item_id')
                  ->constrained('order_items')
                  ->onDelete('cascade');

            // Nombre del extra y su valor mostrado (ej: "Tipo Lente" / "Antirreflejante")
            $table->string('name', 100);
            $table->string('value', 255)->nullable();

            // Precio del extra (positivo o cero)
            $table->decimal('price', 10, 2)->default(0);

            $table->timestamps();

            $table->index('order_item_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_item_options');
    }
};
