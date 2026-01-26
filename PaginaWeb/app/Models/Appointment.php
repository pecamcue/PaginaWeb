<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Appointment extends Model
{
    use HasFactory;

    // Los atributos que son asignables en masa.
    protected $fillable = [
        'appointment_date',
        'appointment_time',
        'status',
        'service_type',
        'guest_name',
        'guest_email',
        'guest_phone',
        'confirmation_token',
        'user_id', // Este campo es para los usuarios registrados
    ];

    // Los atributos que deberían ser convertidos a un tipo específico.
    protected $casts = [
        'appointment_date' => 'datetime', // Convertimos la fecha de la cita a tipo datetime
        'appointment_time' => 'datetime:H:i', // Convertimos la hora de la cita a formato 24h
    ];

    // Relación con el modelo User (si el usuario está registrado)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Genera un token de confirmación único para la cita
    public function generateConfirmationToken()
    {
       $this->confirmation_token = bin2hex(random_bytes(16)); // Generamos un token aleatorio
        $this->save(); // Guardamos el modelo con el nuevo token
    }

    // Método para verificar si la cita está pendiente
    public function isPending()
    {
        return $this->status === 'pendiente';
    }

    // Método para verificar si la cita está confirmada
    public function isConfirmed()
    {
        return $this->status === 'confirmada';
    }

    // Método para verificar si la cita está cancelada
    public function isCancelled()
    {
        return $this->status === 'cancelada';
    }
}
