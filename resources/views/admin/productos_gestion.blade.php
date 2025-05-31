@extends('layouts.app')

@section('title', 'Gestión de Productos')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body.bg-pastel-admin {
  background: linear-gradient(135deg, #f0f4ff, #d9e7ff) !important;
  font-family: 'Poppins', sans-serif !important;
  color: #222;
}
.container {
  max-width: 1200px;
  margin: auto;
}
h1 {
  font-weight: 900;
  font-size: 2.5rem;
  color: #3b49df;
  text-align: center;
  margin-bottom: 2.5rem;
  text-shadow: 1px 1px 5px rgba(59,73,223,0.5);
}
.card {
  border-radius: 20px;
  box-shadow: 0 20px 40px rgba(59,73,223,0.1);
  background: #fff;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover {
  transform: translateY(-8px);
  box-shadow: 0 30px 50px rgba(59,73,223,0.2);
}
.card-header h3 {
  font-weight: 700;
  color: #3b49df;
  border-bottom: 3px solid #3b49df;
  padding-bottom: 10px;
}
.table {
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(59,73,223,0.1);
}
.table thead {
  background: linear-gradient(90deg, #3b49df, #6177ff);
  color: white;
  font-weight: 600;
  font-size: 1rem;
}
.table tbody tr:hover {
  background-color: #f0f4ff;
  cursor: pointer;
  transition: background-color 0.3s ease;
}
.table td, .table th {
  vertical-align: middle;
  text-align: center;
  font-weight: 500;
  font-size: 1rem;
}
.btn-sm {
  font-weight: 700;
  letter-spacing: 0.05em;
  padding: 6px 14px;
  border-radius: 12px;
  transition: all 0.3s ease;
}
.btn-primary {
  background: linear-gradient(45deg, #3b49df, #6177ff);
  border: none;
  box-shadow: 0 6px 15px rgba(59,73,223,0.3);
}
.btn-primary:hover {
  background: linear-gradient(45deg, #2a37b8, #4250d4);
  box-shadow: 0 10px 25px rgba(42,55,184,0.5);
}
.btn-danger {
  background: linear-gradient(45deg, #df3b3b, #ff6161);
  border: none;
  box-shadow: 0 6px 15px rgba(223,59,59,0.3);
}
.btn-danger:hover {
  background: linear-gradient(45deg, #b82a2a, #d44242);
  box-shadow: 0 10px 25px rgba(184,42,42,0.5);
}
.form-container {
  background: white;
  padding: 30px 25px;
  border-radius: 20px;
  box-shadow: 0 20px 40px rgba(59,73,223,0.1);
  transition: box-shadow 0.3s ease;
}
.form-container:hover {
  box-shadow: 0 30px 60px rgba(59,73,223,0.15);
}
.form-container h3 {
  color: #3b49df;
  font-weight: 700;
  margin-bottom: 2rem;
  text-align: center;
  letter-spacing: 1.5px;
}
.form-label {
  font-weight: 600;
  color: #444;
}
input[type="text"],
input[type="number"],
textarea,
select {
  border-radius: 12px;
  border: 2px solid #d0d7ff;
  padding: 12px 15px;
  font-size: 1rem;
  transition: border-color 0.3s ease;
  width: 100%;
  box-sizing: border-box;
  color: #222;
  background-color: #f8faff;
  font-weight: 500;
}
input[type="text"]:focus,
input[type="number"]:focus,
textarea:focus,
select:focus {
  border-color: #3b49df;
  outline: none;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(59,73,223,0.2);
}
textarea {
  resize: vertical;
}
.ingredientes-container {
  max-height: 220px;
  overflow-y: auto;
  border: 1px solid #d0d7ff;
  border-radius: 12px;
  padding: 15px;
  background: #f8faff;
  box-shadow: inset 0 3px 6px rgba(59,73,223,0.05);
}
.ingrediente-checkbox {
  appearance: none;
  -webkit-appearance: none;
  width: 22px;
  height: 22px;
  border: 2.5px solid #3b49df;
  border-radius: 50%;
  display: inline-block;
  position: relative;
  margin-right: 12px;
  cursor: pointer;
  vertical-align: middle;
  transition: background-color 0.3s ease, border-color 0.3s ease;
}
.ingrediente-checkbox:checked {
  background: #3b49df;
  border-color: #3b49df;
}
.ingrediente-checkbox:checked::after {
  content: '✓';
  color: white;
  position: absolute;
  top: 1px;
  left: 6px;
  font-size: 16px;
  font-weight: 700;
}
.form-check-label {
  font-weight: 600;
  color: #333;
  user-select: none;
  cursor: pointer;
}
button[type="submit"] {
  background: linear-gradient(45deg, #3b49df, #6177ff);
  border: none;
  padding: 14px;
  font-size: 1.2rem;
  font-weight: 700;
  color: white;
  border-radius: 14px;
  width: 100%;
  cursor: pointer;
  transition: background 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 8px 20px rgba(59,73,223,0.3);
  margin-top: 10px;
}
button[type="submit"]:hover {
  background: linear-gradient(45deg, #2a37b8, #4250d4);
  box-shadow: 0 12px 35px rgba(42,55,184,0.5);
}
a.btn-secondary {
  display: block;
  margin-top: 12px;
  font-weight: 700;
  border-radius: 14px;
  padding: 12px 0;
  text-align: center;
  background: #888d9e;
  color: white;
  transition: background 0.3s ease;
  box-shadow: 0 6px 15px rgba(136,141,158,0.3);
}
a.btn-secondary:hover {
  background: #62677f;
  text-decoration: none;
}
.ingredientes-container::-webkit-scrollbar {
  width: 8px;
}
.ingredientes-container::-webkit-scrollbar-track {
  background: #f0f4ff;
  border-radius: 12px;
}
.ingredientes-container::-webkit-scrollbar-thumb {
  background: #3b49df;
  border-radius: 12px;
}
</style>
@endpush

@section('content')
<div class="bg-pastel-admin" style="min-height: 100vh;">
    <div class="container py-5">
        <h1 class="text-center mb-4">Administración de Menú</h1>
        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Lista de Productos</h3>
                        <div class="mb-2">
                            <label for="filtro-categoria" class="form-label">Filtrar por categoría:</label>
                            <select id="filtro-categoria" class="form-select">
                                <option value="todas">Todas las categorías</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="tabla-productos">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $producto)
                                <tr data-categoria="{{ $producto->categoria_id }}">
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->categoria->nombre ?? '' }}</td>
                                    <td>Q{{ number_format($producto->precio, 2) }}</td>
                                    <td>
                                        <a href="{{ route('admin.productos.gestion', ['edit' => $producto->id]) }}" class="btn btn-sm btn-primary">Editar</a>
                                        <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este producto?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-container">
                    <h3>{{ isset($producto_editar) && $producto_editar ? 'Editar Producto' : 'Agregar Producto' }}</h3>
                    <form method="POST" action="{{ isset($producto_editar) && $producto_editar ? route('admin.productos.update', $producto_editar->id) : route('admin.productos.store') }}">
                        @csrf
                        @if(isset($producto_editar) && $producto_editar)
                            <input type="hidden" name="id" value="{{ $producto_editar->id }}">
                        @endif
                        <div class="mb-3">
                            <label class="form-label">Categoría</label>
                            <select name="categoria_id" class="form-select" required>
                                <option value="">Seleccionar categoría</option>
                                @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ (isset($producto_editar) && $producto_editar && $producto_editar->categoria_id == $categoria->id) ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nombre del Producto</label>
                            <input type="text" name="nombre" class="form-control" value="{{ $producto_editar->nombre ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3" required>{{ $producto_editar->descripcion ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Precio (Q)</label>
                            <input type="number" step="0.01" name="precio" class="form-control" value="{{ $producto_editar->precio ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL de la Imagen</label>
                            <input type="text" name="imagen_url" class="form-control" value="{{ $producto_editar->imagen_url ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ingredientes</label>
                            <div class="ingredientes-container">
                                @foreach($ingredientes as $ingrediente)
                                <div class="form-check">
                                    <input class="ingrediente-checkbox" type="checkbox" name="ingredientes[]" value="{{ $ingrediente->id }}" id="ing{{ $ingrediente->id }}" {{ (isset($ingredientes_producto) && in_array($ingrediente->id, $ingredientes_producto)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ing{{ $ingrediente->id }}">
                                        {{ $ingrediente->nombre }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            {{ isset($producto_editar) && $producto_editar ? 'Actualizar Producto' : 'Agregar Producto' }}
                        </button>
                        @if(isset($producto_editar) && $producto_editar)
                        <a href="{{ route('admin.productos.gestion') }}" class="btn btn-secondary w-100 mt-2">Cancelar</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.body.classList.add('bg-pastel-admin');
// Filtrado de productos por categoría
const filtro = document.getElementById('filtro-categoria');
filtro.addEventListener('change', function() {
    const cat = this.value;
    document.querySelectorAll('#tabla-productos tbody tr').forEach(tr => {
        if (cat === 'todas' || tr.getAttribute('data-categoria') === cat) {
            tr.style.display = '';
        } else {
            tr.style.display = 'none';
        }
    });
});
</script>
@endpush 