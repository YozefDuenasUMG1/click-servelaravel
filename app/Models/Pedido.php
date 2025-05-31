<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    protected $fillable = ['mesa', 'pedido', 'detalle', 'estado', 'total', 'fecha_hora', 'items_json', 'user_id'];
    protected $casts = [
        'fecha_hora' => 'datetime',
        'items_json' => 'array',
    ];
    
    public function registros()
    {
        return $this->hasMany(RegistroPedido::class, 'pedido_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 