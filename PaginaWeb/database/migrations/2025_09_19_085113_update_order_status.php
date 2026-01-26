<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Actualizar valores existentes
        DB::statement("
            UPDATE orders SET 
                payment_status = CASE 
                    WHEN payment_status = 'pending' THEN 'pendiente'
                    WHEN payment_status = 'succeeded' THEN 'pagado'
                    WHEN payment_status = 'failed' THEN 'cancelado'
                    WHEN payment_status = 'refunded' THEN 'reembolsado'
                    ELSE 'pendiente'
                END,
                status = CASE 
                    WHEN status = 'pending' THEN 'pendiente'
                    WHEN status = 'processing' THEN 'enviado'
                    WHEN status = 'completed' THEN 'completado'
                    WHEN status = 'cancelled' THEN 'cancelado'
                    ELSE 'pendiente'
                END
        ");

        // 2. Cambiar payment_status a ENUM con los nuevos valores
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_status', ['pendiente', 'pagado', 'cancelado', 'reembolsado'])
                  ->default('pendiente')
                  ->change();
        });

        // 3. Cambiar status a ENUM con los nuevos valores
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['pendiente', 'enviado', 'completado', 'cancelado'])
                  ->default('pendiente')
                  ->change();
        });

        // 4. Log de la migración ejecutada
        \Log::info('Migración de estados de pedidos completada. Total de pedidos: ' . DB::table('orders')->count());
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir a string para permitir cualquier valor
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_status', 50)->default('pendiente')->change();
            $table->string('status', 50)->default('pendiente')->change();
        });

        // Revertir valores a los originales en inglés
        DB::statement("
            UPDATE orders SET 
                payment_status = CASE 
                    WHEN payment_status = 'pendiente' THEN 'pending'
                    WHEN payment_status = 'pagado' THEN 'succeeded'
                    WHEN payment_status = 'cancelado' THEN 'failed'
                    WHEN payment_status = 'reembolsado' THEN 'refunded'
                    ELSE 'pending'
                END,
                status = CASE 
                    WHEN status = 'pendiente' THEN 'pending'
                    WHEN status = 'enviado' THEN 'processing'
                    WHEN status = 'completado' THEN 'completed'
                    WHEN status = 'cancelado' THEN 'cancelled'
                    ELSE 'pending'
                END
        ");
    }
};