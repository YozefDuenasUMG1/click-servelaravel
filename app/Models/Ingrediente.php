<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;

    protected $table = 'ingredientes';
    protected $fillable = ['nombre'];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_ingredientes', 'ingrediente_id', 'producto_id');
    }
} 