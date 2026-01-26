<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'modelo',
        'marca',
        'precio',
        'genero',
        'tamano',
        'color_montura',
        'color_cristal',
        'tipo_cristal',
        'material_montura',
        'imagen',
        'descripcion',
        'informacion_adicional',
        'stock',
        'activo',
        'oferta',
        'precio_oferta',
        'slug',
        'categoria_id',
        'tipo_lentilla',
        'frecuencia',
        'subtipo',
    ];

    protected $appends = ['colors']; 

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function opciones()
    {
        return $this->hasMany(OpcionProducto::class, 'producto_id');
    }

    public function orderItems()
    {
        return $this->hasMany(Order_item::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function resenyas()
    {
        return $this->hasMany(Resenya::class);
    }

    public function averageRating()
    {
        return $this->resenyas()->avg('rating') ?? 0;
    }

    // NUEVO: Accessor para colores de lentillas (solo para IDs 48 y 49, en categoría 'lentes de contacto')
    public function getColorsAttribute()
    {
        // Solo activa para productos de color (IDs hardcodeados - cámbialos si hace falta)
        $isColorLens = in_array($this->id, [66, 49]);
        if (!$isColorLens) {
            return collect(); // Array vacío si no aplica
        }

        // Verifica categoría (ajusta 'lentes de contacto' al nombre exacto en BBDD, ej: 'Lentes de Contacto')
        if (!$this->categoria || strtolower($this->categoria->nombre) !== 'lentes de contacto') {
            return collect();
        }

        // Carga imágenes con color_lentilla no nulo/vacío y agrupa por color
        $colorImages = $this->images()
            ->whereNotNull('color_lentilla')
            ->where('color_lentilla', '!=', '')
            ->get()
            ->groupBy('color_lentilla')
            ->map(function ($group) {
                // Toma la primera imagen por color (puedes ajustar si quieres todas)
                $image = $group->first();
                return [
                    'name' => $image->color_lentilla, 
                    'image' => $image->path 
                ];
            })->values(); 
        return $colorImages;
    }
}