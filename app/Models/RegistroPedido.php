<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroPedido extends Model
{
    use HasFactory;

    protected $table = 'registropedidos';
    protected $fillable = ['pedido_id', 'mesa', 'pedido', 'detalle', 'estado', 'total', 'fecha_hora_pedido', 'items_json'];
    protected $casts = [
        'fecha_hora_pedido' => 'datetime',
        'fecha_hora_registro' => 'datetime',
        'items_json' => 'array',
    ];
    
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }
} 