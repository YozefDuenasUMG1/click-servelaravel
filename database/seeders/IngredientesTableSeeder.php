<?php

namespace Database\Seeders;

use App\Models\Ingrediente;
use Illuminate\Database\Seeder;

class IngredientesTableSeeder extends Seeder
{
    public function run()
    {
        $ingredientes = [
            ['nombre' => 'Tomate'],
            ['nombre' => 'Cebolla'],
            ['nombre' => 'Queso'],
            ['nombre' => 'Huevos'],
            ['nombre' => 'Pan'],
            ['nombre' => 'Tocino'],
            ['nombre' => 'Plátanos'],
            ['nombre' => 'Frijoles'],
            ['nombre' => 'Tortillas'],
            ['nombre' => 'Crema'],
        ];

        foreach ($ingredientes as $ingrediente) {
            Ingrediente::create($ingrediente);
        }
    }
} 