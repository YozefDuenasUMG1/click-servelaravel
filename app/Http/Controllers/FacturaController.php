<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = Factura::all();
        return response()->json($facturas);
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'numero_factura' => 'required|string|max:50|unique:facturas', // Ya no requerido
            // 'fecha' => 'required|date', // Ya no requerido
            'cliente' => 'nullable|string|max:100',
            'nit' => 'nullable|string|max:20',
            'subtotal' => 'required|numeric|min:0',
            'impuesto' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'items' => 'required|array',
            'datos_restaurante' => 'required|array',
            'estado' => 'nullable|in:activa,anulada',
        ]);

        // Generar número de factura correlativo por año
        $year = now()->format('Y');
        $ultimo = Factura::where('numero_factura', 'like', "FACT-{$year}-%")
            ->orderByDesc('numero_factura')
            ->first();
        if ($ultimo) {
            $lastNumber = intval(explode('-', $ultimo->numero_factura)[2]);
            $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '00001';
        }
        $numero_factura = "FACT-{$year}-{$nextNumber}";

        $factura = Factura::create([
            'numero_factura' => $numero_factura,
            'fecha' => now(),
            'cliente' => $request->cliente ?? 'Consumidor Final',
            'nit' => $request->nit ?? 'C/F',
            'subtotal' => $request->subtotal,
            'impuesto' => $request->impuesto,
            'total' => $request->total,
            'items' => json_encode($request->items),
            'datos_restaurante' => json_encode($request->datos_restaurante),
            'estado' => $request->estado ?? 'activa',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Factura guardada correctamente',
            'invoice_id' => $factura->id,
            'numero_factura' => $factura->numero_factura
        ], 201);
    }

    public function show($id)
    {
        $factura = Factura::findOrFail($id);
        return response()->json($factura);
    }

    public function update(Request $request, $id)
    {
        $factura = Factura::findOrFail($id);
        
        $request->validate([
            'numero_factura' => 'required|string|max:50|unique:facturas,numero_factura,'.$id,
            'fecha' => 'required|date',
            'cliente' => 'nullable|string|max:100',
            'nit' => 'nullable|string|max:20',
            'subtotal' => 'required|numeric|min:0',
            'impuesto' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'items' => 'required|array',
            'datos_restaurante' => 'required|array',
            'estado' => 'nullable|in:activa,anulada',
        ]);

        $factura->update([
            'numero_factura' => $request->numero_factura,
            'fecha' => $request->fecha,
            'cliente' => $request->cliente ?? 'Consumidor Final',
            'nit' => $request->nit ?? 'C/F',
            'subtotal' => $request->subtotal,
            'impuesto' => $request->impuesto,
            'total' => $request->total,
            'items' => json_encode($request->items),
            'datos_restaurante' => json_encode($request->datos_restaurante),
            'estado' => $request->estado ?? 'activa',
        ]);

        return response()->json($factura);
    }

    public function destroy($id)
    {
        $factura = Factura::findOrFail($id);
        $factura->delete();
        return response()->json(null, 204);
    }
    
    public function anular($id)
    {
        $factura = Factura::findOrFail($id);
        $factura->estado = 'anulada';
        $factura->save();
        return response()->json($factura);
    }

    public function imprimir($id)
    {
        $factura = Factura::findOrFail($id);
        $factura->items = is_array($factura->items) ? $factura->items : json_decode($factura->items, true);
        $factura->datos_restaurante = is_array($factura->datos_restaurante) ? $factura->datos_restaurante : json_decode($factura->datos_restaurante, true);
        return view('factura_imprimir', compact('factura'));
    }
} 