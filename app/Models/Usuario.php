<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $fillable = ['usuario', 'password', 'rol', 'estado'];
    protected $hidden = ['password'];
    
    protected $casts = [
        'creado_en' => 'datetime',
    ];
} 