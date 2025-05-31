@extends('layouts.app')

@section('title', 'Panel de Cajero')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
  <div class="card text-center p-5 shadow-lg">
    <h2 class="mb-4">Bienvenido al Panel de Cajero</h2>
    <a href="{{ route('cajero.registro_pedidos') }}" class="btn btn-primary btn-lg mb-2">Ver Registro de Pedidos</a>
    <a href="/dashboard/analytics" class="btn btn-info btn-lg mb-2">Ver Estadísticas</a>
    <a href="{{ url('/facturacion') }}" class="btn btn-success btn-lg mb-2">Facturación</a>
  </div>
</div>
@endsection 