<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        // Cargar logo como base64 para emails
        $logoPath = public_path('img/Logo.jpg');
        $logoBase64 = null;
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/jpeg;base64,' . base64_encode($logoData);
        }

        return $this->subject('Confirmación de tu cita')
                    ->view('emails.appointment_confirmation')
                    ->with([
                        'appointment' => $this->appointment,
                        'logoBase64' => $logoBase64
                    ]);
    }
}