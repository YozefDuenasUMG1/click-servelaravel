<?php

namespace Database\Seeders;

use App\Models\RegistroPedido;
use Illuminate\Database\Seeder;

class RegistroPedidosTableSeeder extends Seeder
{
    public function run()
    {
        $registros = [
            [
                'pedido_id' => 1,
                'mesa' => '8',
                'pedido' => '- Pizza de Birria Personal/Grande x2\n',
                'detalle' => '',
                'estado' => 'pendiente',
                'total' => 98.00,
                'fecha_hora_pedido' => '2025-05-02 05:04:56',
                'items_json' => json_encode([[
                    'nombre' => 'Pizza de Birria Personal/Grande',
                    'descripcion' => 'El sabor de nuestro puerto. Masa artesanal, birria, queso mozzarella, cilantro y cebolla.',
                    'precio' => 49,
                    'cantidad' => 2,
                    'ingredientes_removidos' => []
                ]])
            ],
            // Agrega los demás registros según el script SQL
        ];

        foreach ($registros as $registro) {
            RegistroPedido::create($registro);
        }
    }
} 