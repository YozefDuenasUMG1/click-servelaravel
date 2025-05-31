<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\RegistroPedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('registros')->get();
        return response()->json($pedidos);
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $data = $request->validate([
            'mesa' => 'required|string|max:50',
            'detalle' => 'nullable|string',
            'total' => 'required|numeric|min:0',
            'items_json' => 'required|string', // Recibimos el JSON como string
        ]);

        // Decodificar los items
        $items = json_decode($data['items_json'], true);

        if (empty($data['mesa']) || empty($items)) {
            return response()->json(["error" => "Los campos 'mesa' y 'items' no pueden estar vacíos."], 422);
        }

        // Convertir los items a texto legible
        $pedido_texto = '';
        foreach ($items as $item) {
            $pedido_texto .= "- {$item['nombre']} x{$item['cantidad']}\n";
            if (isset($item['ingredientes_removidos']) && !empty($item['ingredientes_removidos'])) {
                $pedido_texto .= "  Sin: " . implode(", ", $item['ingredientes_removidos']) . "\n";
            }
        }

        $fecha_hora = now();

        try {
            $pedido = \App\Models\Pedido::create([
                'mesa' => $data['mesa'],
                'pedido' => $pedido_texto,
                'detalle' => $data['detalle'] ?? '',
                'estado' => 'pendiente',
                'total' => $data['total'],
                'fecha_hora' => $fecha_hora,
                'items_json' => $data['items_json'],
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                "success" => true,
                "message" => "Pedido guardado correctamente",
                "pedido_id" => $pedido->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "Error al guardar el pedido: " . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $pedido = Pedido::with('registros')->findOrFail($id);
        return response()->json($pedido);
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        
        $request->validate([
            'mesa' => 'required|string|max:50',
            'pedido' => 'required|string',
            'detalle' => 'nullable|string',
            'estado' => 'required|string',
            'total' => 'required|numeric|min:0',
            'fecha_hora' => 'required|date',
            'items_json' => 'nullable|json',
        ]);

        $pedido->update($request->all());
        
        // Registrar cambio de estado
        if ($pedido->wasChanged('estado')) {
            RegistroPedido::create([
                'pedido_id' => $pedido->id,
                'mesa' => $pedido->mesa,
                'pedido' => $pedido->pedido,
                'detalle' => $pedido->detalle,
                'estado' => $pedido->estado,
                'total' => $pedido->total,
                'fecha_hora_pedido' => $pedido->fecha_hora,
                'items_json' => $pedido->items_json,
            ]);
        }

        return response()->json($pedido->load('registros'));
    }

    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->registros()->delete();
        $pedido->delete();
        return response()->json(null, 204);
    }
    
    public function cambiarEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|string',
        ]);
        
        $pedido = Pedido::findOrFail($id);
        $pedido->estado = $request->estado;
        $pedido->save();
        
        // Registrar cambio de estado
        RegistroPedido::create([
            'pedido_id' => $pedido->id,
            'mesa' => $pedido->mesa,
            'pedido' => $pedido->pedido,
            'detalle' => $pedido->detalle,
            'estado' => $pedido->estado,
            'total' => $pedido->total,
            'fecha_hora_pedido' => $pedido->fecha_hora,
            'items_json' => $pedido->items_json,
        ]);
        
        return response()->json($pedido->load('registros'));
    }

    public function pendientes()
    {
        $pedidos = \App\Models\Pedido::where('estado', 'pendiente')
            ->orderBy('fecha_hora', 'asc')
            ->get(['id', 'mesa', 'pedido', 'detalle', 'estado', 'fecha_hora', 'total', 'items_json']);
        return response()->json($pedidos);
    }
} 