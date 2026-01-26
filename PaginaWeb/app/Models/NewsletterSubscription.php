<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsletterSubscription extends Model {

    use HasFactory;

    // Los atributos que son asignables en masa.

    protected $fillable = ['email', 
                           'name',
                           'subscribed_at',
                           'unsubscribe_token',
                            'is_active',
                        ];

     // Los atributos que deberían ser convertidos a un tipo específico.

    protected $casts = [
        'subscribed_at' => 'datetime',
    ];

     /**
     * Scope para obtener solo las suscripciones activas.
     *
     * Uso: NewsletterSubscription::active()->get();
     */
    public function scopeActive($query) {
        return $query->where('is_active', true);
    }
    
}