@extends('layouts.app')

@section('title', 'Mis Pedidos')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Mis Pedidos</h2>
    @if($pedidos->isEmpty())
        <div class="alert alert-info text-center">Aún no has realizado ningún pedido.</div>
    @else
        <div class="table-responsive" style="overflow-x:auto;">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>Fecha</th>
                        <th>Mesa</th>
                        <th>Detalle</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedidos as $pedido)
                        <tr>
                            <td>{{ $pedido->fecha_hora ? $pedido->fecha_hora->format('Y-m-d H:i') : '' }}</td>
                            <td>{{ $pedido->mesa }}</td>
                            <td>{{ $pedido->detalle ?? $pedido->pedido }}</td>
                            <td>{{ ucfirst($pedido->estado) }}</td>
                            <td>Q{{ number_format($pedido->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection 