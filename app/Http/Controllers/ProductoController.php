<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Ingrediente;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['categoria', 'ingredientes'])->get();
        return response()->json($productos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'imagen_url' => 'nullable|url|max:255',
            'ingredientes' => 'nullable|array',
            'ingredientes.*' => 'exists:ingredientes,id',
        ]);

        $producto = Producto::create($request->except('ingredientes'));
        
        if ($request->has('ingredientes')) {
            $producto->ingredientes()->attach($request->ingredientes);
        }

        if ($request->expectsJson()) {
            return response()->json($producto->load('ingredientes'), 201);
        }
        return redirect()->route('admin.productos.gestion')->with('success', 'Producto agregado correctamente');
    }

    public function show($id)
    {
        $producto = Producto::with(['categoria', 'ingredientes'])->findOrFail($id);
        return response()->json($producto);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'imagen_url' => 'nullable|url|max:255',
            'ingredientes' => 'nullable|array',
            'ingredientes.*' => 'exists:ingredientes,id',
        ]);

        $producto->update($request->except('ingredientes'));
        
        if ($request->has('ingredientes')) {
            $producto->ingredientes()->sync($request->ingredientes);
        }

        if ($request->expectsJson()) {
            return response()->json($producto->load('ingredientes'));
        }
        return redirect()->route('admin.productos.gestion')->with('success', 'Producto actualizado correctamente');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->ingredientes()->detach();
        $producto->delete();
        if (request()->expectsJson()) {
            return response()->json(null, 204);
        }
        return redirect()->route('admin.productos.gestion')->with('success', 'Producto eliminado correctamente');
    }

    /**
     * Vista de gestión de productos para admin
     */
    public function gestion(Request $request)
    {
        $categorias = \App\Models\Categoria::all();
        $ingredientes = \App\Models\Ingrediente::all();
        $productos = \App\Models\Producto::with(['categoria', 'ingredientes'])->get();
        $producto_editar = null;
        $ingredientes_producto = [];
        if ($request->has('edit')) {
            $producto_editar = \App\Models\Producto::with('ingredientes')->find($request->edit);
            if ($producto_editar) {
                $ingredientes_producto = $producto_editar->ingredientes->pluck('id')->toArray();
            }
        }
        return view('admin.productos_gestion', compact('categorias', 'ingredientes', 'productos', 'producto_editar', 'ingredientes_producto'));
    }
} 