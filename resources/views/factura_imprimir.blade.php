<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura {{ $factura->numero_factura }}</title>
    <style>
        /* Reset y configuración base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        
        /* Contenedor principal */
        .ticket {
            width: 100%;
            max-width: 420px;
            margin: 32px auto;
            background: #fff;
            border: 1px dashed #ccc;
            padding: 18px 18px 10px 18px;
        }
        
        /* Encabezado */
        .ticket-header {
            text-align: center;
            margin-bottom: 18px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #000;
        }
        
        .ticket-header h2 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 6px;
            text-transform: uppercase;
        }
        
        .ticket-header p {
            margin: 3px 0;
            font-size: 13px;
        }
        
        /* Información de la factura */
        .ticket-info {
            margin: 14px 0;
            font-size: 13px;
        }
        
        .ticket-info strong {
            font-weight: bold;
        }
        
        /* Tabla de productos */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            table-layout: fixed;
            font-size: 13px;
        }
        
        th, td {
            padding: 6px 4px;
            vertical-align: top;
            word-break: break-word;
        }
        
        th {
            border-bottom: 1px solid #000;
            font-weight: bold;
            text-align: left;
        }
        
        td {
            border-bottom: 1px dashed #ccc;
        }
        
        td:last-child, th:last-child {
            text-align: right;
        }
        
        /* Totales */
        tfoot td {
            font-weight: bold;
            border: none;
        }
        
        .total-row {
            border-top: 2px solid #000;
            font-size: 14px;
            background: #f5f5f5;
        }
        
        /* Pie de página */
        .ticket-footer {
            text-align: center;
            margin-top: 18px;
            padding-top: 10px;
            border-top: 1px dashed #000;
            font-size: 12px;
        }
        
        /* Estado anulado */
        .anulada {
            color: #f44336;
            border: 2px solid #f44336;
            padding: 8px;
            margin-top: 12px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            background: #fff0f0;
        }
        
        /* Optimización para impresión */
        @media print {
            html, body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                background: #fff;
            }
            body {
                margin: 0;
                padding: 0;
            }
            .ticket {
                width: 100mm;
                max-width: 100mm;
                margin: 10mm auto 0 auto;
                box-shadow: none;
                border-radius: 0;
                page-break-inside: avoid;
                break-inside: avoid;
                padding: 0;
                background: #fff;
            }
            .ticket *, .ticket-header, .ticket-info, table, tfoot, .ticket-footer {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
            @page {
                size: A4 portrait;
                margin: 15mm;
            }
        }
        
        /* Clases utilitarias */
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-bold {
            font-weight: bold;
        }
        
        .mt-2 {
            margin-top: 2mm;
        }
        
        .mb-2 {
            margin-bottom: 2mm;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <!-- Encabezado del restaurante -->
        <div class="ticket-header">
            <h2>{{ $factura->datos_restaurante['nombre'] ?? 'RESTAURANTE' }}</h2>
            <p>{{ $factura->datos_restaurante['direccion'] ?? 'Dirección no especificada' }}</p>
            <p>Tel: {{ $factura->datos_restaurante['telefono'] ?? 'N/A' }}</p>
            @if(!empty($factura->datos_restaurante['nit']))
                <p>NIT: {{ $factura->datos_restaurante['nit'] }}</p>
            @endif
            <p class="mt-2 text-bold">FACTURA No: {{ $factura->numero_factura }}</p>
            <p>Fecha: {{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y H:i') }}</p>
        </div>
        
        <!-- Información del cliente -->
        <div class="ticket-info">
            <p>Cliente: <strong>{{ $factura->cliente }}</strong></p>
            <p>NIT/CI: <strong>{{ $factura->nit }}</strong></p>
        </div>
        
        <!-- Tabla de productos -->
        <table>
            <thead>
                <tr>
                    <th style="width: 15%">Cant.</th>
                    <th style="width: 45%">Descripción</th>
                    <th style="width: 20%">P. Unit.</th>
                    <th style="width: 20%">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($factura->items as $item)
                <tr>
                    <td>{{ $item['cantidad'] }}</td>
                    <td>{{ $item['descripcion'] }}</td>
                    <td class="text-right">Q{{ number_format($item['precio'], 2) }}</td>
                    <td class="text-right">Q{{ number_format($item['cantidad'] * $item['precio'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right">Subtotal:</td>
                    <td class="text-right">Q{{ number_format($factura->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right">IVA (12%):</td>
                    <td class="text-right">Q{{ number_format($factura->impuesto, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" class="text-right">TOTAL:</td>
                    <td class="text-right">Q{{ number_format($factura->total, 2) }}</td>
                </tr>
            </tfoot>
        </table>
        
        <!-- Pie de página -->
        <div class="ticket-footer">
            <p>{{ $factura->datos_restaurante['mensaje'] ?? '¡Gracias por su preferencia!' }}</p>
            <p class="mt-2">--------------------------------</p>
            <p>Esta factura es un documento legal</p>
            <p>Conserve este comprobante</p>
            
            @if($factura->estado === 'anulada')
            <div class="anulada mt-2">
                FACTURA ANULADA
            </div>
            @endif
            
            <!-- Código QR o información adicional -->
            <div class="mt-2">
                <small>Ticket generado el: {{ now()->format('d/m/Y H:i:s') }}</small>
            </div>
        </div>
    </div>
    
    <script>
        // Autoimpresión y cierre después de imprimir
        window.onload = function() {
            setTimeout(function() {
                window.print();
                setTimeout(function() {
                    window.close();
                }, 500);
            }, 200);
        };
        
        // Manejo de la tecla ESC para cerrar
        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") {
                window.close();
            }
        });
    </script>
</body>
</html>