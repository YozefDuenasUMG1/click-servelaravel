<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriasTableSeeder extends Seeder
{
    public function run()
    {
        $nombres = [
            'Desayunos',
            'Huevos Rancheros',
            'Chilaquiles',
            'Panqueques con Frutas',
            'Avena con Leche y Semillas',
            'Gallo Pinto',
            'Platos Principales',
            'Pepián de Pollo',
            'Carne Asada con Chimichurri',
            'Tamales de Maíz',
            'Revolcado de Cerdo',
            'Enchiladas Suizas',
            'Antojos',
            'Pupusas',
            'Elotes Locos',
            'Tostadas con Guacamol',
            'Buñuelos con Miel',
            'Empanadas de Plátano',
            'Entradas',
            'Guacamol con Totopos',
            'Ceviche de Pescado',
            'Caldo de Res',
            'Sopa de Frijol',
            'Ensalada de Nopalitos',
            'Bebidas',
            'Horchata de Arroz',
            'Agua de Jamaica',
            'Limonada con Chía',
            'Atol de Elote',
            'Refresco de Tamarindo',
            'Postres',
            'Arroz con Leche',
            'Plátanos en Gloria',
            'Buñuelos',
            'Torrejas',
            'Flan Casero',
        ];

        foreach ($nombres as $nombre) {
            Categoria::firstOrCreate(
                ['nombre' => $nombre],
                [
                    'descripcion' => 'Sin descripción',
                    'archivo' => str_replace(' ', '', $nombre) . '.html',
                ]
            );
        }
    }
} 