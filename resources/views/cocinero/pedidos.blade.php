@extends('layouts.app')

@section('title', 'Panel de Cocina')

@push('styles')
<style>
.pedido-card {
    background: #f9fbfd;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 123, 255, 0.15);
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}
.pedido-card:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 12px 30px rgba(0, 123, 255, 0.3);
}
.card-header {
    background: linear-gradient(135deg, #85bfff 0%, #a7d8ff 100%);
    color: #034078;
    border-radius: 12px 12px 0 0;
    font-weight: 700;
    font-size: 1.25rem;
    text-align: center;
    letter-spacing: 1px;
}
.card-body {
    padding: 1.5rem;
    color: #034078;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.text-danger {
    color: #e86f6f !important;
    font-style: italic;
}
.alert-info {
    background-color: #d9ecff;
    color: #034078;
    border: none;
    border-radius: 8px;
    padding: 10px 15px;
    font-size: 0.9rem;
    box-shadow: inset 0 0 5px rgba(3, 64, 120, 0.1);
}
.btn-success {
    background: linear-gradient(45deg, #7ed56f, #3bb78f);
    border: none;
    font-weight: 600;
    font-size: 1.1rem;
    padding: 10px 0;
    border-radius: 50px;
    transition: background 0.3s ease;
    box-shadow: 0 6px 12px rgba(62, 180, 137, 0.4);
}
.btn-success:hover, .btn-success:focus {
    background: linear-gradient(45deg, #3bb78f, #7ed56f);
    box-shadow: 0 8px 16px rgba(62, 180, 137, 0.6);
    outline: none;
}
.text-muted small {
    font-style: italic;
    color: #6c757d;
}
@media (max-width: 768px) {
    .pedido-card {
        margin-bottom: 1.5rem;
    }
}
</style>
@endpush

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Pedidos en Cocina</h2>
    <div class="row" id="pedidos">
        @forelse($pedidos as $pedido)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card pedido-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Mesa {{ $pedido['mesa'] ?? '-' }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            @if(isset($pedido['items_json']))
                                @php $items = json_decode($pedido['items_json'], true); @endphp
                                @foreach($items as $item)
                                    <div class="mb-2">
                                        <strong>{{ $item['nombre'] }} x{{ $item['cantidad'] }}</strong>
                                        @if(!empty($item['ingredientes_removidos']))
                                            <div class="text-danger"><small>Sin: {{ implode(', ', $item['ingredientes_removidos']) }}</small></div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                {{ $pedido['pedido'] ?? 'Sin detalles del pedido' }}
                            @endif
                        </div>
                        @if(!empty($pedido['detalle']))
                            <div class="alert alert-info">{{ $pedido['detalle'] }}</div>
                        @endif
                        <div class="text-muted mb-2">
                            <small>Pedido realizado: {{ $pedido['fecha_hora'] ?? 'Fecha no disponible' }}</small>
                        </div>
                        @if(!empty($pedido['total']))
                            <div class="fw-bold mb-3">Total: Q{{ number_format($pedido['total'], 2) }}</div>
                        @endif
                        <button class="btn btn-success w-100" onclick="marcarListo('{{ $pedido['id'] ?? 0 }}')">
                            Marcar como Listo
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center"><h4>No hay pedidos pendientes</h4></div>
        @endforelse
    </div>
</div>
@push('scripts')
<script>
function marcarListo(id) {
    // Aquí deberías hacer una petición AJAX para marcar el pedido como listo
    alert('Pedido ' + id + ' marcado como listo (simulado)');
    // Después de marcar como listo, podrías recargar la página o actualizar la lista de pedidos
}
</script>
@endpush
@endsection 