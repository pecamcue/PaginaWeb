<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpcionProducto extends Model
{
    use HasFactory;

    protected $table = 'opciones_producto';


    protected $fillable = [
        'producto_id',
        'tipo_lente',
        'color_sol',
        'indice_lente',
        'esfera_derecho',
        'cilindro_derecho',
        'eje_derecho',
        'esfera_izquierdo',
        'cilindro_izquierdo',
        'eje_izquierdo',
        'adicion_derecho',
        'ojo_dominante_derecho',
        'adicion_izquierdo',
        'ojo_dominante_izquierdo',
    ];

    public function producto() {
        return $this->belongsTo(Product::class, 'producto_id');
    }

}