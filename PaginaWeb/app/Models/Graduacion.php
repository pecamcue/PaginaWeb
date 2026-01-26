<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Graduacion extends Model
{
    use HasFactory;

    protected $table = 'graduaciones';

    protected $fillable = [
        'user_id',
        'nombre',
        'od_esfera',
        'od_cilindro',
        'od_eje',
        'od_adicion',
        'os_esfera',
        'os_cilindro',
        'os_eje',
        'os_adicion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}