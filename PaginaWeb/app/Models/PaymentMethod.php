<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_type',
        'last_four_digits',
        'card_holder',
        'expiry_date',
        'stripe_payment_method_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}