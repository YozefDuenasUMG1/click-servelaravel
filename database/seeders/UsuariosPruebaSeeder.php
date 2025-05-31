<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosPruebaSeeder extends Seeder
{
    public function run()
    {
        $usuarios = [
            [
                'name' => 'admin1',
                'email' => 'admin1@fake.com',
                'password' => Hash::make('password123'),
                'rol' => 'admin',
                'estado' => 'activo',
            ],
            [
                'name' => 'cocinero1',
                'email' => 'cocinero1@fake.com',
                'password' => Hash::make('password123'),
                'rol' => 'cocinero',
                'estado' => 'activo',
            ],
            [
                'name' => 'cajero1',
                'email' => 'cajero1@fake.com',
                'password' => Hash::make('password123'),
                'rol' => 'cajero',
                'estado' => 'activo',
            ],
            [
                'name' => 'cliente1',
                'email' => 'cliente1@fake.com',
                'password' => Hash::make('password123'),
                'rol' => 'cliente',
                'estado' => 'activo',
            ],
        ];

        foreach ($usuarios as $usuario) {
            if (!DB::table('users')->where('email', $usuario['email'])->exists()) {
                DB::table('users')->insert(array_merge($usuario, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
} 