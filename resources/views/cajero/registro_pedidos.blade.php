@extends('layouts.app')

@push('styles')
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
body.bg-pastel {
  padding: 20px !important;
  background: linear-gradient(to right, #f8f9fa, #e9ecef) !important;
  font-family: 'Segoe UI', sans-serif !important;
}
.header {
  background: linear-gradient(to right, #343a40, #495057);
  color: white;
  padding: 20px;
  border-radius: 12px;
  margin-bottom: 25px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}
.resumen-pedidos {
  background: #fff;
  border-left: 5px solid #0d6efd;
  border-radius: 12px;
  padding: 15px 25px;
  margin-bottom: 20px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.pedido-card {
  background: linear-gradient(135deg, #ffffff, #f1f3f5);
  margin-bottom: 20px;
  border: none;
  border-radius: 12px;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  position: relative;
}
.pedido-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}
.estado-pendiente {
  border-left: 6px solid #ffc107;
  box-shadow: inset 6px 0 10px -6px #ffc107;
}
.estado-completado {
  border-left: 6px solid #198754;
  box-shadow: inset 6px 0 10px -6px #198754;
}
.estado-cancelado {
  border-left: 6px solid #dc3545;
  box-shadow: inset 6px 0 10px -6px #dc3545;
}
.items-list {
  list-style: none;
  padding-left: 0;
}
.items-list li {
  padding: 6px 0;
  border-bottom: 1px solid #dee2e6;
}
.datepicker-container {
  position: relative;
}
.datepicker-container i {
  position: absolute;
  right: 10px;
  top: 40px;
  pointer-events: none;
  color: #6c757d;
}
.alert-info {
  background-color: #dbeafe;
  color: #0c4a6e;
  border: 1px solid #90cdf4;
  border-radius: 12px;
}
.badge {
  font-size: 0.85rem;
  padding: 6px 10px;
  border-radius: 8px;
}
</style>
@endpush

@section('title', 'Registro de Pedidos')

@section('content')
<div class="bg-pastel" style="min-height: 100vh;">
  <div class="header">
    <h1 class="text-center mb-3">Registro de Pedidos</h1>
    <div class="d-flex justify-content-between align-items-center">
      <span id="fecha-actual"></span>
      <button class="btn btn-light btn-sm" onclick="filtrarPedidos()">
        <i class="bi bi-arrow-clockwise"></i> Actualizar
      </button>
    </div>
  </div>

  <div class="resumen-pedidos">
    <div class="row mb-3">
      <div class="col-md-3 datepicker-container">
        <label for="selector-fecha" class="form-label">Seleccionar fecha:</label>
        <input type="date" class="form-control" id="selector-fecha">
        <i class="bi bi-calendar"></i>
      </div>
      <div class="col-md-3">
        <label for="filtro-mesa" class="form-label">Filtrar por mesa:</label>
        <select class="form-select" id="filtro-mesa">
          <option value="todas">Todas las mesas</option>
          @for($i = 1; $i <= 10; $i++)
            <option value="{{ $i }}">Mesa {{ $i }}</option>
          @endfor
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-primary w-100" onclick="filtrarPedidos()">
          <i class="bi bi-funnel"></i> Filtrar
        </button>
      </div>
    </div>
  </div>

  <div class="alert alert-info d-flex justify-content-between align-items-center">
    <div>
      <span id="total-pedidos">0</span> pedidos -
      Total: Q<span id="total-importe">0.00</span>
    </div>
    <div id="fecha-consulta"></div>
  </div>

  <div id="pedidos-container">
    <!-- Aquí se cargarán los pedidos dinámicamente -->
  </div>
</div>
@endsection

@push('scripts')
<script>
document.body.classList.add('bg-pastel');
function formatearFecha(fecha) {
  if (!fecha) return 'Fecha no disponible';
  const d = new Date(fecha);
  if (isNaN(d)) return fecha;
  return d.toLocaleString('es-ES', { dateStyle: 'medium', timeStyle: 'short' });
}
function cargarPedidosRegistro() {
  fetch('/api/registro-pedidos')
    .then(r => r.json())
    .then(data => {
      window._registrosPedidos = data;
      renderPedidos(data);
    });
}
function renderPedidos(data) {
  let cont = document.getElementById('pedidos-container');
  let total = 0;
  let totalImporte = 0;
  let fechaFiltro = document.getElementById('selector-fecha').value;
  let mesaFiltro = document.getElementById('filtro-mesa').value;
  let hoy = new Date();
  let fechaActual = hoy.toLocaleDateString('es-ES', { dateStyle: 'full' });
  document.getElementById('fecha-actual').textContent = fechaActual;
  document.getElementById('fecha-consulta').textContent = fechaFiltro ? `Filtrado por: ${fechaFiltro}` : '';
  let html = '';
  let filtrados = data.filter(reg => {
    let fechaOk = true;
    let mesaOk = true;
    if (fechaFiltro) {
      fechaOk = reg.fecha_hora_pedido && reg.fecha_hora_pedido.startsWith(fechaFiltro);
    }
    if (mesaFiltro && mesaFiltro !== 'todas') {
      mesaOk = reg.mesa == mesaFiltro;
    }
    return fechaOk && mesaOk;
  });
  filtrados.forEach(reg => {
    total++;
    totalImporte += parseFloat(reg.total);
    let itemsHtml = '';
    if (reg.items_json) {
      try {
        const items = JSON.parse(reg.items_json);
        itemsHtml = items.map(item => {
          let sin = item.ingredientes_removidos && item.ingredientes_removidos.length > 0 ? `<div class='text-danger'><small>Sin: ${item.ingredientes_removidos.join(', ')}</small></div>` : '';
          return `<div><strong>${item.nombre} x${item.cantidad}</strong>${sin}</div>`;
        }).join('');
      } catch(e) {
        itemsHtml = reg.pedido || '-';
      }
    } else {
      itemsHtml = reg.pedido || '-';
    }
    let estadoClass = reg.estado === 'listo' ? 'estado-completado' : (reg.estado === 'pendiente' ? 'estado-pendiente' : 'estado-cancelado');
    html += `
      <div class="card pedido-card mb-3 ${estadoClass}">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="badge bg-${reg.estado === 'listo' ? 'success' : (reg.estado === 'pendiente' ? 'warning text-dark' : 'secondary')}">${reg.estado}</span>
            <span class="fw-bold">Mesa ${reg.mesa}</span>
            <span class="text-muted">${formatearFecha(reg.fecha_hora_pedido)}</span>
          </div>
          <div class="mb-2">${itemsHtml}</div>
          ${reg.detalle ? `<div class="alert alert-info">${reg.detalle}</div>` : ''}
          <div class="fw-bold">Total: Q${parseFloat(reg.total).toFixed(2)}</div>
        </div>
      </div>
    `;
  });
  if (!html) {
    html = '<div class="text-center text-muted py-5"><h4>No hay registros para los filtros seleccionados</h4></div>';
  }
  cont.innerHTML = html;
  document.getElementById('total-pedidos').textContent = total;
  document.getElementById('total-importe').textContent = totalImporte.toFixed(2);
}
function filtrarPedidos() {
  renderPedidos(window._registrosPedidos || []);
}
document.addEventListener('DOMContentLoaded', function() {
  cargarPedidosRegistro();
  document.getElementById('selector-fecha').addEventListener('change', filtrarPedidos);
  document.getElementById('filtro-mesa').addEventListener('change', filtrarPedidos);
});
setInterval(cargarPedidosRegistro, 15000);
</script>
@endpush 