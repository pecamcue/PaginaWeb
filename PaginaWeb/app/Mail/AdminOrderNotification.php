<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $order; // Cambié de $factura a $order para que coincida con tu vista

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Nuevo pedido realizado')
                    ->view('emails.AvisoAdminPedido'); // tu vista Blade
    }
}
