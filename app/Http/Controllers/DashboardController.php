<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Factura;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function api(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Facturas
        $facturasQuery = Factura::query();
        if ($startDate && $endDate) {
            $facturasQuery->whereBetween(DB::raw('DATE(fecha)'), [$startDate, $endDate]);
        }

        // Registropedidos: usar un nuevo builder para cada consulta
        $basePedidos = DB::table('registropedidos');
        if ($startDate && $endDate) {
            $basePedidos = $basePedidos->whereBetween(DB::raw('DATE(fecha_hora_pedido)'), [$startDate, $endDate]);
        }

        // KPIs
        $totalPedidos = (clone $basePedidos)->count();
        $ingresosTotales = $facturasQuery->sum('total');
        $ticketPromedio = $totalPedidos > 0 ? ($ingresosTotales / $totalPedidos) : 0;

        // Pedidos por día
        $pedidosPorDia = (clone $basePedidos)
            ->select(DB::raw('DATE(fecha_hora_pedido) as dia'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('DATE(fecha_hora_pedido)'))
            ->orderBy('dia')
            ->get();

        // Estado de pedidos
        $estadoPedidos = (clone $basePedidos)
            ->select('estado', DB::raw('COUNT(*) as cantidad'))
            ->groupBy('estado')
            ->get();

        // Ingresos por día
        $ingresosPorDia = $facturasQuery
            ->select(DB::raw('DATE(fecha) as dia'), DB::raw('SUM(total) as ingresos'))
            ->groupBy(DB::raw('DATE(fecha)'))
            ->orderBy('dia')
            ->get();

        // Pedidos por mesa
        $pedidosPorMesa = (clone $basePedidos)
            ->select('mesa', DB::raw('COUNT(*) as cantidad'))
            ->groupBy('mesa')
            ->get();

        // Pedidos por hora
        $pedidosPorHora = (clone $basePedidos)
            ->select(DB::raw('HOUR(fecha_hora_pedido) as hora'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('HOUR(fecha_hora_pedido)'))
            ->orderBy('hora')
            ->get();

        // Producto más vendido
        $productoMasVendido = (clone $basePedidos)
            ->select('pedido as producto', DB::raw('COUNT(*) as cantidad'))
            ->groupBy('pedido')
            ->orderByDesc('cantidad')
            ->first();

        // Ventas por categoría (si tienes la relación, aquí es ejemplo)
        $ventasPorCategoria = [];
        // Si tienes una tabla de productos y categorías, puedes hacer un join aquí

        return response()->json([
            'totalPedidos' => $totalPedidos,
            'ingresosTotales' => 'Q' . number_format($ingresosTotales, 2),
            'ticketPromedio' => 'Q' . number_format($ticketPromedio, 2),
            'pedidosPorDia' => $pedidosPorDia,
            'estadoPedidos' => $estadoPedidos,
            'ingresosPorDia' => $ingresosPorDia,
            'pedidosPorMesa' => $pedidosPorMesa,
            'pedidosPorHora' => $pedidosPorHora,
            'productoMasVendido' => $productoMasVendido,
            'ventasPorCategoria' => $ventasPorCategoria,
        ]);
    }
} 