<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use App\Models\Factura;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class ConfirmacionPedido extends Mailable
{
    use SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        Log::info('Iniciando build() para order_id: ' . $this->order->id);

        // Cargar relaciones
        $this->order->load(['orderItems.product.categoria', 'user']); 

        $itemsWithIVA = [];
        $impuestosTotal = 0;
        $subtotalTotal = $this->order->subtotal;

        foreach ($this->order->orderItems as $item) {
            $categoria = $item->product->categoria ?? null;
            $ivaRate = $categoria ? $categoria->iva_rate : 0.21;

            // Override a 10% si hay graduación (consistencia con portal)
            if (!empty($item->od_esfera) || !empty($item->oi_esfera) || 
                !empty($item->tipo_lentilla) || !empty($item->adicion) || 
                !empty($item->ojo_dominante) || !empty($item->od_cilindro) || 
                !empty($item->oi_cilindro) || !empty($item->od_eje) || 
                !empty($item->oi_eje)) {
                $ivaRate = 0.10;
                Log::info('Graduación detectada en ítem ' . $item->id . ': IVA al 10%');
            }

            $subtotalItem = $item->precio_unitario * $item->cantidad;
            $impuestoItem = $subtotalItem * $ivaRate;

            $itemsWithIVA[] = [
                'marca' => $item->product->marca ?? '',
                'modelo' => $item->product->modelo ?? '',
                'cantidad' => $item->cantidad,
                'precio_unitario' => $item->precio_unitario,
                'od_esfera' => $item->od_esfera,
                'od_cilindro' => $item->od_cilindro,
                'od_eje' => $item->od_eje,
                'oi_esfera' => $item->oi_esfera,
                'oi_cilindro' => $item->oi_cilindro,
                'oi_eje' => $item->oi_eje,
                'adicion' => $item->adicion,
                'ojo_dominante' => $item->ojo_dominante,
                'tipo_cristal' => $item->tipo_cristal,
                'indice_lente' => $item->indice_lente,
                'color_cristal' => $item->color_cristal,
                'categoria' => $categoria ? $categoria->nombre : 'General',
                'iva_rate' => $ivaRate,
            ];

            $impuestosTotal += $impuestoItem;
        }

        if ($this->order->shipping_cost > 0) {
            $impuestosTotal += $this->order->shipping_cost * 0.21;
        }

        $factura = Factura::firstOrCreate(
            ['order_id' => $this->order->id],
            [
                'numero_factura' => Factura::generarNumeroFactura(),
                'user_id' => $this->order->user_id,
                'fecha_emision' => now(),
                'subtotal' => $subtotalTotal,
                'impuestos' => $impuestosTotal,
                'total' => $subtotalTotal + $impuestosTotal,
            ]
        );

        $factura->load(['order.orderItems.product.categoria', 'user']);

        // Cargar logo como base64 para emails y PDF
        $logoPath = public_path('img/Logo.jpg');
        $logoBase64 = null;
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/jpeg;base64,' . base64_encode($logoData);
            Log::info('Logo base64 cargado para order_id: ' . $this->order->id);
        } else {
            Log::warning('Logo no encontrado para order_id: ' . $this->order->id . ' en ' . $logoPath);
        }

        // Generar PDF con logo pasado (FIX para "Undefined variable")
        $pdfContent = null;
        try {
            $pdf = Pdf::loadView('emails.factura', [
                'factura' => $factura,
                'itemsWithIVA' => $itemsWithIVA,
                'logoBase64' => $logoBase64  // ← FIX: Pasar logo a PDF
            ]);
            $pdfContent = $pdf->output();
            Log::info('PDF generado para order_id: ' . $this->order->id . ' (tamaño: ' . strlen($pdfContent) . ' bytes)');
        } catch (\Exception $e) {
            Log::error('Error generando PDF para order_id: ' . $this->order->id . ': ' . $e->getMessage());
            $pdfContent = null;
        }

        return $this->subject('Confirmación de tu Pedido #' . $this->order->id)
                    ->view('emails.confirmacion_pedido')
                    ->with([
                        'order' => $this->order,
                        'logoBase64' => $logoBase64
                    ])
                    ->attachData($pdfContent ?? '', 'factura_' . $factura->numero_factura . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}