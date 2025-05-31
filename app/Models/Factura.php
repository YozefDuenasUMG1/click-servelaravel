<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'facturas';
    protected $fillable = ['numero_factura', 'fecha', 'cliente', 'nit', 'subtotal', 'impuesto', 'total', 'items', 'datos_restaurante', 'estado'];
    protected $casts = [
        'fecha' => 'datetime',
        'items' => 'array',
        'datos_restaurante' => 'array',
    ];
} 