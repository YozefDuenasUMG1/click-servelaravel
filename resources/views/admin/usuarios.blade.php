@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
.usuarios-container { max-width: 900px; margin: 30px auto; background: #fff; border-radius: 10px; box-shadow: 0 4px 16px rgba(0,0,0,0.07); padding: 30px; }
.table th, .table td { vertical-align: middle; }
.form-user { background: #f8f9fa; border-radius: 8px; padding: 18px; margin-bottom: 30px; }
</style>
@endpush

@section('content')
@include('admin.sidebar')
<div class="usuarios-container">
  <h2 class="mb-4 text-center">Gestión de Usuarios</h2>
  <form id="form-user" class="form-user mb-4">
    <input type="hidden" id="user-id">
    <div class="row g-2">
      <div class="col-md-4">
        <label class="form-label">Usuario</label>
        <input type="text" class="form-control" id="usuario" required minlength="4">
      </div>
      <div class="col-md-4">
        <label class="form-label">Rol</label>
        <select class="form-select" id="rol">
          <option value="admin">Admin</option>
          <option value="cajero">Cajero</option>
          <option value="cocinero">Cocinero</option>
          <option value="cliente">Cliente</option>
        </select>
      </div>
      <div class="col-md-4" id="password-group">
        <label class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" minlength="8">
      </div>
    </div>
    <div class="mt-3 text-end">
      <button type="submit" class="btn btn-primary">Guardar Usuario</button>
      <button type="button" class="btn btn-secondary" id="cancel-edit" style="display:none;">Cancelar</button>
    </div>
  </form>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Usuario</th>
          <th>Rol</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="usuarios-list"></tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/usuarios.js') }}"></script>
@endpush 