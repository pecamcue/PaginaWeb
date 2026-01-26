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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
            $table->string('apellidos')->nullable();
            $table->string('telefono')->nullable();
            $table->string('calle')->nullable();  
            $table->string('numero')->nullable(); 
            $table->string('piso')->nullable();  
            $table->string('ciudad')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->string('pais')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_admin',
                'apellidos',
                'telefono',
                'calle',
                'numero',
                'piso',
                'ciudad',
                'codigo_postal',
                'pais'
            ]);
        });
    }
};
