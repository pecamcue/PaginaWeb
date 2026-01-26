<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'path', 'color_lentilla']; 

    public $timestamps = true;

    // Relación: una imagen pertenece a un producto
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}