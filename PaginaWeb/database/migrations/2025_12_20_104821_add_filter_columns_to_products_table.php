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
        Schema::table('products', function (Blueprint $table) {
            // Frecuencia: Para lentillas (diaria, mensual, etc.)
            $table->string('frecuencia')->nullable()->after('tipo_lentilla');
            
            // Subtipo: Para Líquidos (gotas, limpieza) y Accesorios (audiologia, colgantes, etc.)
            $table->string('subtipo')->nullable()->after('frecuencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['frecuencia', 'subtipo']);
        });
    }
};