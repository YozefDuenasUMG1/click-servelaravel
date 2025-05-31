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
    .pedido-card { margin-bottom: 1.5rem; }
}
</style>
@endpush

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Pedidos en Cocina</h2>
    <div class="row" id="pedidos"></div>
</div>
@endsection

@push('scripts')
<script>
function formatearFecha(fecha) {
    if (!fecha) return 'Fecha no disponible';
    const d = new Date(fecha);
    if (isNaN(d)) return fecha;
    return d.toLocaleString('es-ES', { dateStyle: 'medium', timeStyle: 'short' });
}
function cargarPedidos() {
    fetch("{{ route('cocina.pedidos_pendientes') }}")
    .then(response => response.json())
    .then(data => {
        let contenedor = document.getElementById("pedidos");
        let contenido = "";
        data.forEach(pedido => {
            let itemsHtml = '';
            if (pedido.items_json) {
                try {
                    const items = JSON.parse(pedido.items_json);
                    items.forEach(item => {
                        itemsHtml += `
                            <div class="mb-2">
                                <strong>${item.nombre} x${item.cantidad}</strong>
                                ${item.ingredientes_removidos && item.ingredientes_removidos.length > 0 ? 
                                    `<div class="text-danger"><small>Sin: ${item.ingredientes_removidos.join(', ')}</small></div>` 
                                    : ''}
                            </div>`;
                    });
                } catch(e) {
                    itemsHtml = pedido.pedido || 'Sin detalles del pedido';
                }
            } else {
                itemsHtml = pedido.pedido || 'Sin detalles del pedido';
            }
            contenido += `
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card pedido-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Mesa ${pedido.mesa}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                ${itemsHtml}
                            </div>
                            ${pedido.detalle ? `<div class="alert alert-info">${pedido.detalle}</div>` : ''}
                            <div class="text-muted mb-2">
                                <small>Pedido realizado: ${formatearFecha(pedido.fecha_hora)}</small>
                            </div>
                            ${pedido.total ? `<div class="fw-bold mb-3">Total: Q${parseFloat(pedido.total).toFixed(2)}</div>` : ''}
                            <button class="btn btn-success w-100" onclick="marcarListo(${pedido.id}, this)">
                                Marcar como Listo
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });
        if (contenido === "") {
            contenido = '<div class="col-12 text-center"><h4>No hay pedidos pendientes</h4></div>';
        }
        contenedor.innerHTML = contenido;
    })
    .catch(error => {
        console.error('Error cargando los pedidos:', error);
        document.getElementById("pedidos").innerHTML = 
            '<div class="col-12 text-center text-danger">' +
            '<h4>Error al cargar los pedidos. Por favor, actualice la página.</h4></div>';
    });
}
function marcarListo(id, btn) {
    btn.disabled = true;
    fetch(`/cocinero/api/pedidos/${id}/listo`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
        }
    })
    .then(r => r.json())
    .then(data => {
        cargarPedidos();
    })
    .catch(() => {
        alert('Error al marcar como listo');
        btn.disabled = false;
    });
}
setInterval(cargarPedidos, 5000);
cargarPedidos();
</script>
@endpush 