<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'status', 
        'subtotal',
        'shipping_cost',
        'shipping_method',
        'total_amount',
        'payment_method',
        'payment_status',
        'order_date',
        'payment_id'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(Order_item::class);
    }

    // Calcular subtotal sumando productos y sus opciones
    public function calculateSubtotal()
    {
        return $this->orderItems->sum(function ($item) {
            return ($item->precio_unitario + $item->options->sum('price')) * $item->cantidad;
        });
    }

    // Calcular total incluyendo gastos de envío 
    public function calculateTotal()
    {
        return $this->calculateSubtotal() + $this->shipping_cost;
    }

    // ========== MÉTODOS HELPER PARA ESTADOS ==========

    /**
     * Obtener la etiqueta legible del estado del pago
     */
    public function getPaymentStatusLabelAttribute()
    {
        $labels = [
            'pendiente' => 'Pendiente',
            'pagado' => 'Pagado', 
            'cancelado' => 'Cancelado',
            'reembolsado' => 'Reembolsado'
        ];
        
        return $labels[$this->payment_status] ?? ucfirst($this->payment_status);
    }

    /**
     * Obtener la etiqueta legible del estado del pedido
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pendiente' => 'Pendiente',
            'preparacion' => 'Preparación',
            'enviado' => 'Enviado',
            'completado' => 'Completado',
            'cancelado' => 'Cancelado'
        ];
        
        return $labels[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Obtener la clase CSS para el badge del estado del pedido
     */
    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'completado' => 'bg-success',
            'enviado' => 'bg-info', 
            'preparacion' => 'bg-warning text-dark',
            'pendiente' => 'bg-warning text-dark',
            'cancelado' => 'bg-danger'
        ];
        
        return $classes[$this->status] ?? 'bg-secondary';
    }

    /**
     * Obtener la clase CSS para el badge del estado del pago
     */
    public function getPaymentStatusBadgeClassAttribute()
    {
        $classes = [
            'pagado' => 'bg-success',
            'pendiente' => 'bg-warning text-dark',
            'reembolsado' => 'bg-info',
            'cancelado' => 'bg-danger'
        ];
        
        return $classes[$this->payment_status] ?? 'bg-secondary';
    }

    /**
     * Verificar si el pedido está pendiente de pago
     */
    public function getIsPaymentPendingAttribute()
    {
        return $this->payment_status === 'pendiente';
    }

    /**
     * Verificar si el pedido está pagado
     */
    public function getIsPaidAttribute()
    {
        return $this->payment_status === 'pagado';
    }

    /**
     * Verificar si el pedido está cancelado
     */
    public function getIsCancelledAttribute()
    {
        return $this->status === 'cancelado';
    }

    /**
     * Verificar si el pedido está completado
     */
    public function getIsCompletedAttribute()
    {
        return $this->status === 'completado';
    }
}