<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Ingrediente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoIngredientesTableSeeder extends Seeder
{
    public function run()
    {
        // Limpiar la tabla antes de insertar
        DB::table('producto_ingredientes')->truncate();
        // Ejemplo de relación entre productos e ingredientes
        $producto = Producto::find(1);
        $ingredientes = Ingrediente::whereIn('id', [1, 2, 3])->get();
        $producto->ingredientes()->attach($ingredientes);
        
        // Agrega las demás relaciones según el script SQL
    }
} 