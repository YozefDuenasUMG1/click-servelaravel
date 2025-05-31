@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<style>
body.bg-pastel-admin {
  padding-top: 70px !important;
  background: linear-gradient(to right, #f8f9fa, #e9ecef) !important;
  font-family: 'Segoe UI', sans-serif !important;
}
.admin-panel {
  max-width: 1100px;
  margin: 0 auto;
  padding: 40px 0;
  position: relative;
  height: 650px;
}
.row-custom {
  position: relative;
  width: 100%;
  display: flex;
  justify-content: center;
  gap: 40px;
}
.row-custom.top {
  margin-bottom: 20px;
  margin-top: -40px;
}
.row-custom.bottom {
  margin-left: 100px;
  margin-top: 60px;
}
.card {
  border: none;
  border-radius: 16px;
  transition: all 0.3s ease;
  background: #ffffff;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  overflow: hidden;
  position: relative;
  width: 320px;
  height: 280px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.card:hover {
  transform: translateY(-8px);
  box-shadow: 0 16px 32px rgba(0, 0, 0, 0.12);
}
.card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  height: 6px;
  width: 100%;
  background: linear-gradient(to right, #0d6efd, #6610f2);
  transition: all 0.3s ease;
  opacity: 0;
}
.card:hover::before {
  opacity: 1;
}
.card-body {
  padding: 30px;
  text-align: center;
}
.card-title {
  font-size: 1.5rem;
  margin-bottom: 25px;
  color: #343a40;
}
.btn {
  border-radius: 8px;
  font-weight: 600;
  padding: 12px 24px;
  font-size: 1rem;
  transition: background-color 0.3s ease;
}
.btn-primary:hover { background-color: #0b5ed7; }
.btn-success:hover { background-color: #157347; }
.btn-info:hover { background-color: #0dcaf0; }
.btn-warning:hover { background-color: #ffc107; color: #000; }
.btn-secondary:hover { background-color: #6c757d; }
.btn-dark:hover { background-color: #000; }
h1 {
  font-weight: bold;
  color: #343a40;
  margin-bottom: 50px;
}
.card-icon {
  font-size: 48px;
  color: #6610f2;
  margin-bottom: 15px;
  transition: color 0.3s ease;
}
.card:hover .card-icon { color: #0d6efd; }
.sidebar {
  position: fixed;
  left: 0; top: 0; bottom: 0;
  width: 250px;
  background: #fff;
  box-shadow: 2px 0 12px rgba(0,0,0,0.07);
  z-index: 1001;
  padding-top: 20px;
  transition: left 0.3s;
  overflow-y: auto;
  max-height: 100vh;
}
.sidebar .brand {
  display: flex; align-items: center; gap: 10px; padding: 0 20px 10px 20px;
}
.sidebar .brand img { width: 38px; border-radius: 50%; }
.sidebar .letramod { padding: 10px 20px 0 20px; color: #888; font-size: 0.95rem; font-weight: 600; }
.sidebar .menu { list-style: none; padding: 0; margin: 0 0 10px 0; }
.sidebar .menu-item { margin: 0; }
.sidebar .menu-link {
  display: flex; align-items: center; gap: 12px;
  padding: 12px 20px;
  color: #333; text-decoration: none;
  font-weight: 500; border-radius: 8px;
  transition: background 0.2s, color 0.2s;
}
.sidebar .menu-link:hover, .sidebar .menu-link.active {
  background: #f0f4ff; color: #0d6efd;
}
.sidebar .menu-link i { font-size: 1.3rem; }
.sidebar .footer {
  position: absolute; bottom: 0; left: 0; width: 100%; padding: 18px 20px; background: #f8f9fa; border-top: 1px solid #eee;
}
.sidebar .user { display: flex; align-items: center; gap: 10px; }
.sidebar .user-img img { width: 38px; border-radius: 50%; }
.sidebar .user-data { flex: 1; }
.sidebar .user-data .name { font-weight: 600; font-size: 1rem; }
.sidebar .user-data .email { font-size: 0.9rem; color: #888; }
.sidebar .user-icon i { font-size: 1.3rem; color: #dc3545; cursor: pointer; }
.menu-btn.sidebar-btn { position: fixed; left: 15px; top: 15px; z-index: 1100; background: #fff; border-radius: 50%; box-shadow: 0 2px 8px rgba(0,0,0,0.08); width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; cursor: pointer; }
.menu-btn.sidebar-btn i { font-size: 1.7rem; }
@media (max-width: 991px) {
  .sidebar { left: -260px; }
  .sidebar.active { left: 0; }
}
@media (min-width: 992px) {
  .sidebar { left: 0; }
  .menu-btn.sidebar-btn { display: none; }
  .admin-panel { margin-left: 250px; }
}
</style>
@endpush

@section('title', 'Panel de Administrador')

@section('content')
<div class="menu-btn sidebar-btn" id="sidebar-btn">
    <i class='bx bx-menu'></i>
    <i class='bx bx-x' style="display:none;"></i>
</div>
<div class="bg-pastel-admin" style="min-height: 100vh;">
  <div class="container admin-panel">
    <h1 class="text-center">Panel de Administrador</h1>
    <div class="row-custom top">
      <div class="card">
        <div class="card-body">
          <i class="bi bi-menu-button-wide card-icon"></i>
          <h5 class="card-title">Gestión de Menú</h5>
          <a href="{{ route('admin.productos.gestion') }}" class="btn btn-primary mt-3">Administrar Productos</a>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <i class="bi bi-basket2 card-icon"></i>
          <h5 class="card-title">Sistema de Pedidos</h5>
          <a href="{{ route('cliente.index') }}" class="btn btn-success mt-3" target="_blank">Ver Menú Cliente</a>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <i class="bi bi-people card-icon"></i>
          <h5 class="card-title">Gestión de Usuarios</h5>
          <a href="{{ route('admin.usuarios') }}" class="btn btn-info mt-3">Administrar Usuarios</a>
        </div>
      </div>
    </div>
    <div class="row-custom bottom">
      <div class="card">
        <div class="card-body">
          <i class="bi bi-fire card-icon"></i>
          <h5 class="card-title">Cocina</h5>
          <a href="{{ route('cocinero.panel') }}" class="btn btn-warning mt-3" target="_blank">Ver Cocina</a>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <i class="bi bi-bar-chart-line card-icon"></i>
          <h5 class="card-title">Estadísticas</h5>
          <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Ver Estadísticas</a>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <i class="bi bi-cash-stack card-icon"></i>
          <h5 class="card-title">Módulo de Cajero</h5>
          <a href="{{ route('cajero.index') }}" class="btn btn-dark mt-3" target="_blank">Acceder a Cajero</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
// Sidebar toggle
const sidebarBtn = document.getElementById('sidebar-btn');
const sidebar = document.getElementById('sidebar');
const menuIcon = sidebarBtn.querySelector('.bx-menu');
const closeIcon = sidebarBtn.querySelector('.bx-x');
sidebarBtn.addEventListener('click', function() {
  sidebar.classList.toggle('active');
  if (sidebar.classList.contains('active')) {
    menuIcon.style.display = 'none';
    closeIcon.style.display = '';
  } else {
    menuIcon.style.display = '';
    closeIcon.style.display = 'none';
  }
});
document.body.classList.add('bg-pastel-admin');
</script>
@endpush 