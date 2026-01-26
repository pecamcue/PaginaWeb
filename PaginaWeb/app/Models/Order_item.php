<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'cantidad',
        'precio_unitario',
        'od_esfera',
        'od_cilindro',
        'od_eje',
        'oi_esfera',
        'oi_cilindro',
        'oi_eje',
        'adicion',
        'ojo_dominante',
        'tipo_cristal',
        'indice_lente',
        'color_cristal',
        'tipo_lentilla',
        'color_lentilla',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function options()
    {
        return $this->hasMany(OrderItemOption::class);
    }

    // Calcular precio total de este ítem (producto + extras) * cantidad
    
    public function totalPrice()
    {
        return ($this->precio_unitario + $this->options->sum('price')) * $this->cantidad;
    }
}
