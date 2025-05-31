<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductosTableSeeder extends Seeder
{
    public function run()
    {
        $productos = [
            [
                'categoria_id' => 1,
                'nombre' => 'Desayuno Chapín',
                'descripcion' => 'desayuno típico guatemalteco',
                'precio' => 50.00,
                'imagen_url' => 'https://aprende.guatemala.com/wp-content/uploads/2016/10/C%C3%B3mo-preparar-un-desayuno-t%C3%ADpico-chap%C3%ADn2.jpg'
            ],
            [
                'categoria_id' => 1,
                'nombre' => 'Desayuno Tradicional',
                'descripcion' => 'Disfruta de la perfecta combinación de huevos frescos preparados a tu gusto, acompañados de crujiente tocino dorado, salchichas artesanales y pan casero tostado. Servido con frijoles caseros y rodajas de tomate asado. Una explosión de sabores que revitalizan tus mañanas.',
                'precio' => 45.00,
                'imagen_url' => 'https://mcdonalds.com.gt/storage/menu-products/1640713435_19_DesayunoTradicional_1624550705.png'
            ],
            [
                'categoria_id' => 1,
                'nombre' => 'Huevos Rancheros',
                'descripcion' => 'Huevos estrellados sobre tortilla con salsa ranchera.',
                'precio' => 32.00,
                'imagen_url' => 'https://cdn7.kiwilimon.com/recetaimagen/37041/640x640/37041.jpg'
            ],
            [
                'categoria_id' => 1,
                'nombre' => 'Chilaquiles',
                'descripcion' => 'Totopos bañados en salsa, queso y crema.',
                'precio' => 28.00,
                'imagen_url' => 'https://assets.unileversolutions.com/recipes-v2/230012.jpg'
            ],
            [
                'categoria_id' => 1,
                'nombre' => 'Panqueques con Frutas',
                'descripcion' => 'Panqueques esponjosos con frutas frescas y miel.',
                'precio' => 30.00,
                'imagen_url' => 'https://www.pequerecetas.com/wp-content/uploads/2015/03/panqueques-de-frutas.jpg'
            ],
            [
                'categoria_id' => 1,
                'nombre' => 'Avena con Leche y Semillas',
                'descripcion' => 'Avena cocida en leche con semillas y frutas.',
                'precio' => 22.00,
                'imagen_url' => 'https://www.cocinavital.mx/wp-content/uploads/2017/01/avena-con-leche-y-fruta.jpg'
            ],
            [
                'categoria_id' => 1,
                'nombre' => 'Gallo Pinto',
                'descripcion' => 'Mezcla de arroz y frijoles típica centroamericana.',
                'precio' => 25.00,
                'imagen_url' => 'https://www.recetasnestlecam.com/sites/default/files/srh_recipes/7e2e2e2e2e2e2e2e2e2e2e2e2e2e2e2e.jpg'
            ],
            // Platos Principales
            [
                'categoria_id' => 2,
                'nombre' => 'Pepián de Pollo',
                'descripcion' => 'Estofado guatemalteco de pollo con especias.',
                'precio' => 45.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Pepian-de-pollo-885x500.jpg'
            ],
            [
                'categoria_id' => 2,
                'nombre' => 'Carne Asada con Chimichurri',
                'descripcion' => 'Carne de res a la parrilla con salsa chimichurri.',
                'precio' => 55.00,
                'imagen_url' => 'https://cdn7.kiwilimon.com/recetaimagen/37041/640x640/37041.jpg'
            ],
            [
                'categoria_id' => 2,
                'nombre' => 'Tamales de Maíz',
                'descripcion' => 'Tamales tradicionales de maíz rellenos.',
                'precio' => 20.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Tamales-885x500.jpg'
            ],
            [
                'categoria_id' => 2,
                'nombre' => 'Revolcado de Cerdo',
                'descripcion' => 'Guiso de cerdo con salsa de tomate y especias.',
                'precio' => 48.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Revolcado-885x500.jpg'
            ],
            [
                'categoria_id' => 2,
                'nombre' => 'Enchiladas Suizas',
                'descripcion' => 'Tortillas rellenas de pollo y bañadas en salsa verde.',
                'precio' => 38.00,
                'imagen_url' => 'https://cdn7.kiwilimon.com/recetaimagen/37041/640x640/37041.jpg'
            ],
            // Antojos
            [
                'categoria_id' => 3,
                'nombre' => 'Pupusas',
                'descripcion' => 'Tortillas rellenas de queso y chicharrón.',
                'precio' => 18.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Pupusas-885x500.jpg'
            ],
            [
                'categoria_id' => 3,
                'nombre' => 'Elotes Locos',
                'descripcion' => 'Elotes cubiertos con mayonesa, queso y chile.',
                'precio' => 15.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Elotes-locos-885x500.jpg'
            ],
            [
                'categoria_id' => 3,
                'nombre' => 'Tostadas con Guacamol',
                'descripcion' => 'Tostadas crujientes con guacamole fresco.',
                'precio' => 12.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Tostadas-885x500.jpg'
            ],
            [
                'categoria_id' => 3,
                'nombre' => 'Buñuelos con Miel',
                'descripcion' => 'Bolas de masa frita bañadas en miel.',
                'precio' => 16.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Bunuelos-885x500.jpg'
            ],
            [
                'categoria_id' => 3,
                'nombre' => 'Empanadas de Plátano',
                'descripcion' => 'Empanadas dulces de plátano rellenas de frijol.',
                'precio' => 14.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Empanadas-885x500.jpg'
            ],
            // Entradas
            [
                'categoria_id' => 4,
                'nombre' => 'Guacamol con Totopos',
                'descripcion' => 'Guacamole fresco acompañado de totopos.',
                'precio' => 20.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Guacamol-885x500.jpg'
            ],
            [
                'categoria_id' => 4,
                'nombre' => 'Ceviche de Pescado',
                'descripcion' => 'Pescado marinado en jugo de limón con vegetales.',
                'precio' => 35.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Ceviche-885x500.jpg'
            ],
            [
                'categoria_id' => 4,
                'nombre' => 'Caldo de Res',
                'descripcion' => 'Sopa tradicional de res con verduras.',
                'precio' => 28.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Caldo-de-res-885x500.jpg'
            ],
            [
                'categoria_id' => 4,
                'nombre' => 'Sopa de Frijol',
                'descripcion' => 'Sopa cremosa de frijol negro.',
                'precio' => 22.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Sopa-de-frijol-885x500.jpg'
            ],
            [
                'categoria_id' => 4,
                'nombre' => 'Ensalada de Nopalitos',
                'descripcion' => 'Ensalada fresca de nopalitos con jitomate y cebolla.',
                'precio' => 18.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Ensalada-de-nopalitos-885x500.jpg'
            ],
            // Bebidas (Batidos)
            [
                'categoria_id' => 5,
                'nombre' => 'Horchata de Arroz',
                'descripcion' => 'Bebida refrescante de arroz y canela.',
                'precio' => 10.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Horchata-885x500.jpg'
            ],
            [
                'categoria_id' => 5,
                'nombre' => 'Agua de Jamaica',
                'descripcion' => 'Bebida de flor de jamaica natural.',
                'precio' => 10.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Jamaica-885x500.jpg'
            ],
            [
                'categoria_id' => 5,
                'nombre' => 'Limonada con Chía',
                'descripcion' => 'Limonada fresca con semillas de chía.',
                'precio' => 12.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Limonada-885x500.jpg'
            ],
            [
                'categoria_id' => 5,
                'nombre' => 'Atol de Elote',
                'descripcion' => 'Bebida caliente de elote dulce.',
                'precio' => 14.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Atol-885x500.jpg'
            ],
            [
                'categoria_id' => 5,
                'nombre' => 'Refresco de Tamarindo',
                'descripcion' => 'Bebida refrescante de tamarindo.',
                'precio' => 10.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Tamarindo-885x500.jpg'
            ],
            // Postres
            [
                'categoria_id' => 6,
                'nombre' => 'Arroz con Leche',
                'descripcion' => 'Postre cremoso de arroz con leche y canela.',
                'precio' => 15.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Arroz-con-leche-885x500.jpg'
            ],
            [
                'categoria_id' => 6,
                'nombre' => 'Plátanos en Gloria',
                'descripcion' => 'Plátanos cocidos en miel y canela.',
                'precio' => 16.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Platanos-en-gloria-885x500.jpg'
            ],
            [
                'categoria_id' => 6,
                'nombre' => 'Buñuelos',
                'descripcion' => 'Bolas de masa frita bañadas en miel.',
                'precio' => 14.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Bunuelos-885x500.jpg'
            ],
            [
                'categoria_id' => 6,
                'nombre' => 'Torrejas',
                'descripcion' => 'Pan remojado en leche y huevo, frito y bañado en miel.',
                'precio' => 15.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Torrejas-885x500.jpg'
            ],
            [
                'categoria_id' => 6,
                'nombre' => 'Flan Casero',
                'descripcion' => 'Flan tradicional hecho en casa.',
                'precio' => 18.00,
                'imagen_url' => 'https://www.guatemala.com/fotos/201610/Flan-885x500.jpg'
            ],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
} 