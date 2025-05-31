<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;

class ClienteController extends Controller
{
    public function index()
    {
        return view('cliente.index');
    }

    public function menu()
    {
        return view('cliente.menu');
    }

    public function desayunos()
    {
        $categoria = \App\Models\Categoria::where('nombre', 'Desayunos')->first();
        if (!$categoria) {
            abort(404, "Categoría 'Desayunos' no encontrada");
        }
        $productos = \App\Models\Producto::with('ingredientes')
            ->where('categoria_id', $categoria->id)
            ->get()
            ->map(function($producto) {
                $productoArr = $producto->toArray();
                $productoArr['ingredientes'] = $producto->ingredientes->pluck('nombre')->toArray();
                return $productoArr;
            });
        return view('cliente.desayunos', compact('categoria', 'productos'));
    }

    public function antojos()
    {
        $categoria = \App\Models\Categoria::where('nombre', 'Antojos')->first();
        if (!$categoria) {
            abort(404, "Categoría 'Antojos' no encontrada");
        }
        $productos = \App\Models\Producto::with('ingredientes')
            ->where('categoria_id', $categoria->id)
            ->get()
            ->map(function($producto) {
                $productoArr = $producto->toArray();
                $productoArr['ingredientes'] = $producto->ingredientes->pluck('nombre')->toArray();
                return $productoArr;
            });
        return view('cliente.antojos', compact('categoria', 'productos'));
    }

    public function bebidas()
    {
        $categoria = \App\Models\Categoria::where('nombre', 'Bebidas')->first();
        if (!$categoria) {
            abort(404, "Categoría 'Bebidas' no encontrada");
        }
        $productos = \App\Models\Producto::with('ingredientes')
            ->where('categoria_id', $categoria->id)
            ->get()
            ->map(function($producto) {
                $productoArr = $producto->toArray();
                $productoArr['ingredientes'] = $producto->ingredientes->pluck('nombre')->toArray();
                return $productoArr;
            });
        return view('cliente.bebidas', compact('categoria', 'productos'));
    }

    public function entradas()
    {
        $categoria = \App\Models\Categoria::where('nombre', 'Entradas')->first();
        if (!$categoria) {
            abort(404, "Categoría 'Entradas' no encontrada");
        }
        $productos = \App\Models\Producto::with('ingredientes')
            ->where('categoria_id', $categoria->id)
            ->get()
            ->map(function($producto) {
                $productoArr = $producto->toArray();
                $productoArr['ingredientes'] = $producto->ingredientes->pluck('nombre')->toArray();
                return $productoArr;
            });
        return view('cliente.entradas', compact('categoria', 'productos'));
    }

    public function platos()
    {
        $categoria = \App\Models\Categoria::where('nombre', 'Platos Principales')->first();
        if (!$categoria) {
            abort(404, "Categoría 'Platos Principales' no encontrada");
        }
        $productos = \App\Models\Producto::with('ingredientes')
            ->where('categoria_id', $categoria->id)
            ->get()
            ->map(function($producto) {
                $productoArr = $producto->toArray();
                $productoArr['ingredientes'] = $producto->ingredientes->pluck('nombre')->toArray();
                return $productoArr;
            });
        return view('cliente.platos', compact('categoria', 'productos'));
    }

    public function postres()
    {
        $categoria = \App\Models\Categoria::where('nombre', 'Postres')->first();
        if (!$categoria) {
            abort(404, "Categoría 'Postres' no encontrada");
        }
        $productos = \App\Models\Producto::with('ingredientes')
            ->where('categoria_id', $categoria->id)
            ->get()
            ->map(function($producto) {
                $productoArr = $producto->toArray();
                $productoArr['ingredientes'] = $producto->ingredientes->pluck('nombre')->toArray();
                return $productoArr;
            });
        return view('cliente.postres', compact('categoria', 'productos'));
    }

    public function pedidos()
    {
        $pedidos = Pedido::where('user_id', Auth::id())->orderByDesc('fecha_hora')->get();
        return view('cliente.pedidos', compact('pedidos'));
    }
} 