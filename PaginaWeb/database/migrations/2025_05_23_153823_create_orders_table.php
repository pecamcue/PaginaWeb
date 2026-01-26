<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('status'); // Estado del pedido (pendiente, completado, cancelado)
            $table->decimal('total_amount', 10, 2); // Total del pedido
            $table->timestamp('order_date')->useCurrent(); // Fecha del pedido
            $table->timestamps(); // Campos created_at y updated_at

            // foreign key

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con el usuario

        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
