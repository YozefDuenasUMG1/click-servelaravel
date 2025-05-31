<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosTableSeeder extends Seeder
{
    public function run()
    {
        $usuarios = [
            [
                'usuario' => 'admin',
                'password' => Hash::make('password'), // Cambia esto por una contraseña segura
                'rol' => 'admin',
                'estado' => 'activo'
            ],
            // Agrega los demás usuarios según el script SQL
        ];

        foreach ($usuarios as $usuario) {
            Usuario::firstOrCreate(
                ['usuario' => $usuario['usuario']], // Campos únicos
                $usuario // Valores a insertar si no existe
            );
        }
    }
} 