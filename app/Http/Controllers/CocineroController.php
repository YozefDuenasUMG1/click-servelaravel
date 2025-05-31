<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\RegistroPedido;

class CocineroController extends Controller
{
    public function index()
    {
        return view('cocinero.index');
    }

    public function pedidos()
    {
        // Aquí deberías obtener los pedidos desde la base de datos
        $pedidos = [];
        return view('cocinero.pedidos', compact('pedidos'));
    }

    // API: Obtener pedidos en formato JSON desde la base de datos
    public function apiPedidos()
    {
        // Solo pedidos pendientes
        $pedidos = Pedido::where('estado', 'pendiente')->orderBy('fecha_hora', 'asc')->get();
        // Formatear para el panel
        $result = $pedidos->map(function($pedido) {
            return [
                'id' => $pedido->id,
                'mesa' => $pedido->mesa,
                'detalle' => $pedido->detalle ?? $pedido->pedido,
                'estado' => ucfirst($pedido->estado),
                'fecha_hora' => $pedido->fecha_hora ? $pedido->fecha_hora->format('Y-m-d H:i') : '',
                'items_json' => $pedido->items_json,
                'total' => $pedido->total,
            ];
        });
        return response()->json($result);
    }

    // API: Marcar pedido como listo en la base de datos
    public function apiMarcarListo($id)
    {
        $pedido = Pedido::find($id);
        if (!$pedido) {
            return response()->json(['success' => false, 'message' => 'Pedido no encontrado'], 404);
        }
        if ($pedido->estado === 'completado') {
            return response()->json(['success' => false, 'message' => 'El pedido ya está completado'], 400);
        }
        $pedido->estado = 'completado';
        $pedido->save();
        // Registrar el cambio de estado
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
        return response()->json(['success' => true, 'message' => 'Pedido marcado como listo']);
    }
} 