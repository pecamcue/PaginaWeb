<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'name',
        'value',
        'price',
    ];

    public function orderItem()
    {
        return $this->belongsTo(Order_item::class);
    }
}