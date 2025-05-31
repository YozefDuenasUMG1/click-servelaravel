<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrarUsuariosAUsersSeeder extends Seeder
{
    public function run()
    {
        $usuarios = DB::table('usuarios')->get();

        foreach ($usuarios as $usuario) {
            // Evitar duplicados por email
            $email = $usuario->usuario . '@fake.com';
            if (DB::table('users')->where('email', $email)->exists()) {
                continue;
            }
            DB::table('users')->insert([
                'name' => $usuario->usuario,
                'email' => $email,
                'password' => $usuario->password,
                'rol' => $usuario->rol,
                'estado' => $usuario->estado,
                'created_at' => $usuario->created_at,
                'updated_at' => $usuario->updated_at,
            ]);
        }
    }
} 