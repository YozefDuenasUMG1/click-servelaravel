<?php

namespace Database\Seeders;

use App\Models\Factura;
use Illuminate\Database\Seeder;

class FacturasTableSeeder extends Seeder
{
    public function run()
    {
        $facturas = [
            [
                'numero_factura' => 'FACT-2025-00001',
                'fecha' => '2025-05-14 00:06:56',
                'cliente' => 'Consumidor Final',
                'nit' => 'C/F',
                'subtotal' => 50.00,
                'impuesto' => 6.00,
                'total' => 56.00,
                'items' => json_encode([['descripcion' => 'Hamburguesa', 'precio' => 50, 'cantidad' => 1, 'total' => 50]]),
                'datos_restaurante' => json_encode([
                    'nombre' => 'Click&Serve Restaurant',
                    'direccion' => 'Dirección del Restaurante',
                    'telefono' => '(502) XXXX-XXXX',
                    'mensaje' => '¡Gracias por su preferencia!'
                ]),
                'estado' => 'activa'
            ],
            // Agrega las demás facturas según el script SQL
        ];

        foreach ($facturas as $factura) {
            Factura::create($factura);
        }
    }
} 