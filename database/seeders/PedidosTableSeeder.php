<?php

namespace Database\Seeders;

use App\Models\Pedido;
use Illuminate\Database\Seeder;

class PedidosTableSeeder extends Seeder
{
    public function run()
    {
        $pedidos = [
            [
                'mesa' => '8',
                'pedido' => '- Pizza de Birria Personal/Grande x2\n',
                'detalle' => '',
                'estado' => 'completado',
                'total' => 98.00,
                'fecha_hora' => '2025-05-02 05:04:56',
                'items_json' => json_encode([[
                    'nombre' => 'Pizza de Birria Personal/Grande',
                    'descripcion' => 'El sabor de nuestro puerto. Masa artesanal, birria, queso mozzarella, cilantro y cebolla.',
                    'precio' => 49,
                    'cantidad' => 2,
                    'ingredientes_removidos' => []
                ]])
            ],
            // Agrega los demás pedidos según el script SQL
        ];

        foreach ($pedidos as $pedido) {
            Pedido::create($pedido);
        }
    }
} 