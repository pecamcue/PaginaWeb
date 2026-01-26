<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterConfirmationMail extends Mailable
{
    use SerializesModels;

    public $subscription;

    public function __construct($subscription)
    {
        $this->subscription = $subscription;
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

        return $this->subject('Confirmación de Suscripción a nuestra Newsletter')
                    ->view('emails.newsletter_confirmation')
                    ->with([
                        'subscription' => $this->subscription,
                        'logoBase64' => $logoBase64
                    ]);
    }
}