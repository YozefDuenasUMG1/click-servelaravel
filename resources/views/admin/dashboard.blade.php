@extends('layouts.app')

@push('styles')
<!-- Chart.js y estilos propios -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
/* --- Dashboard Styles adaptados del HTML proporcionado --- */
body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f9;
}
.container-dashboard {
  max-width: 1200px;
  margin: 20px auto;
  padding: 15px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
h1 {
  text-align: center;
  margin-bottom: 20px;
}
canvas {
  margin: 20px 0;
}
@media (min-width: 768px) {
  .chart-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }
}
@media (min-width: 1200px) {
  .chart-container {
    grid-template-columns: repeat(3, 1fr);
  }
}
.filters {
  background: #f8f9fa;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 20px;
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  align-items: center;
  justify-content: center;
}
.filters label {
  font-weight: bold;
  margin-right: 5px;
}
.filters input[type="date"],
.filters input[type="number"] {
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}
.filters button {
  padding: 8px 15px;
  background-color: #4e73df;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}
.filters button:hover {
  background-color: #2e59d9;
}
.kpi-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 15px;
  margin-bottom: 20px;
}
.kpi-card {
  background: white;
  border-radius: 8px;
  padding: 15px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  text-align: center;
}
.kpi-card h3 {
  margin-top: 0;
  color: #666;
  font-size: 1rem;
}
.kpi-value {
  font-size: 1.8rem;
  font-weight: bold;
  color: #333;
}
.spinner {
  border: 5px solid #f3f3f3;
  border-top: 5px solid #3498db;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
  margin: 0 auto 10px;
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
.info-tooltip {
  background: #4e73df;
  color: white;
  border: none;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  cursor: help;
  margin-left: 5px;
}
[data-tooltip] {
  position: relative;
}
[data-tooltip]:hover::after {
  content: attr(data-tooltip);
  position: absolute;
  bottom: 100%;
  left: 50%;
  transform: translateX(-50%);
  background: #333;
  color: white;
  padding: 5px 10px;
  border-radius: 4px;
  font-size: 0.8rem;
  white-space: nowrap;
  z-index: 10;
}
.chart-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
  padding: 10px;
}
@media (min-width: 768px) {
  .chart-container {
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: space-around;
  }
}
body.dark-mode {
  background-color: #121212;
  color: #ffffff;
}
body.dark-mode .container-dashboard {
  background-color: #1e1e1e;
  box-shadow: 0 4px 8px rgba(255, 255, 255, 0.1);
}
.theme-toggle {
  position: fixed;
  top: 10px;
  right: 10px;
  background-color: #007bff;
  color: #fff;
  border: none;
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
}
.notification {
  position: fixed;
  top: 20px;
  right: 20px;
  padding: 10px 20px;
  border-radius: 5px;
  color: #fff;
  z-index: 1000;
}
.notification.error {
  background-color: #e74c3c;
}
.notification.success {
  background-color: #2ecc71;
}
</style>
@endpush

@section('content')
@include('admin.sidebar')
<button class="theme-toggle" onclick="toggleTheme()">Toggle Dark Mode</button>
<div class="container-dashboard">
  <h1>Dashboard de Estadísticas</h1>
  <div class="filters">
      <div>
          <label for="timeRange">Rango:</label>
          <select id="timeRange">
              <option value="today">Hoy</option>
              <option value="yesterday">Ayer</option>
              <option value="week">Esta semana</option>
              <option value="month">Este mes</option>
              <option value="custom">Personalizado</option>
          </select>
      </div>
      <div id="customDateRange" style="display:none;">
          <label for="startDate">Desde:</label>
          <input type="date" id="startDate">
          <label for="endDate">Hasta:</label>
          <input type="date" id="endDate">
      </div>
      <button id="filterButton">Filtrar</button>
      <button id="exportButton" class="btn btn-secondary">Exportar Datos</button>
  </div>
  <div id="loading" style="display: none; text-align: center; padding: 20px;">
      <div class="spinner"></div>
      <p>Cargando datos...</p>
  </div>
  <div class="kpi-container">
    <div class="kpi-card">
      <h3>Total Pedidos</h3>
      <div class="kpi-value" id="totalPedidos">0</div>
    </div>
    <div class="kpi-card">
      <h3>Ingresos Totales</h3>
      <div class="kpi-value" id="ingresosTotales">Q0</div>
    </div>
    <div class="kpi-card">
      <h3>Ticket Promedio</h3>
      <div class="kpi-value" id="ticketPromedio">Q0</div>
    </div>
  </div>
  <div class="chart-container" id="chartContainer">
    <canvas id="pedidosPorDia"></canvas>
    <canvas id="productoMasVendido"></canvas>
    <canvas id="estadoPedidos"></canvas>
    <button class="info-tooltip" data-tooltip="Esta gráfica muestra la distribución de pedidos por estado">?</button>
    <canvas id="ingresosPorDia"></canvas>
    <canvas id="pedidosPorMesa"></canvas>
    <canvas id="pedidosPorHora"></canvas>
    <canvas id="ventasPorCategoria"></canvas>
  </div>
  <div id="promedioPedidos" style="text-align: center; font-size: 1.2rem; margin-top: 20px;"></div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
@endpush 