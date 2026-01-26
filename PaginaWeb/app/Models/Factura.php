<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_factura',
        'order_id',
        'user_id',
        'fecha_emision',
        'subtotal',
        'impuestos',
        'total',
        'notas',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'subtotal' => 'decimal:2',
        'impuestos' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Relación con el pedido.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relación con el usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generar número de factura correlativo por año.
     */
    public static function generarNumeroFactura($year = null)
    {
        $year = $year ?? now()->year;
        $ultimaFactura = self::whereYear('fecha_emision', $year)
            ->orderBy('id', 'desc')
            ->first();

        $correlativo = $ultimaFactura ? (int) substr($ultimaFactura->numero_factura, 5) + 1 : 1;

        return "{$year}-" . str_pad($correlativo, 4, '0', STR_PAD_LEFT);
    }
}