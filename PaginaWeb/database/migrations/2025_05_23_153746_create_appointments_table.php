<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->date('appointment_date'); // Fecha de la cita
            $table->time('appointment_time'); // Hora de la cita
            $table->enum('status', ['pendiente', 'confirmada', 'cancelada'])->default('pendiente'); // Estado de la cita
            $table->enum('service_type', ['Examen_Visual', 'Examen_Audiologico', 'Revision_Lentillas']); // Tipo de servicio
            $table->string('guest_name')->nullable(); // Nombre del invitado
            $table->string('guest_email')->nullable(); // Email del invitado
            $table->string('guest_phone')->nullable(); // Teléfono del invitado
            $table->string('confirmation_token')->nullable(); // Token para la confirmación y cancelación
            $table->timestamps();

            // foreing key
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Relación con el usuario (si está registrado)
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
