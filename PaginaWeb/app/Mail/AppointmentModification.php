<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentModification extends Mailable
{
    use Queueable, SerializesModels;

    public $oldAppointment;
    public $newAppointment;

    public function __construct(Appointment $oldAppointment, Appointment $newAppointment)
    {
        $this->oldAppointment = $oldAppointment;
        $this->newAppointment = $newAppointment;
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

        return $this->subject('Modificación de tu cita')
                    ->view('emails.appointment_modification')
                    ->with([
                        'oldAppointment' => $this->oldAppointment,
                        'newAppointment' => $this->newAppointment,
                        'logoBase64' => $logoBase64
                    ]);
    }
}