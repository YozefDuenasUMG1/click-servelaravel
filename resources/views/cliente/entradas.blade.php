@extends('layouts.app')

@section('content')
    @include('cliente.navbar')
    <!-- Modal Detalles Producto -->
    <div class="modal fade" id="productoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles del Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImagen" src="" class="img-fluid mb-3" alt="Producto">
                    <h5 id="modalNombre" class="mt-3"></h5>
                    <p id="modalDescripcion" class="text-muted"></p>
                    <p id="modalPrecio" class="fw-bold"></p>
                    <div class="text-start">
                        <h6>Ingredientes:</h6>
                        <div id="ingredientesContainer"></div>
                    </div>
                    <button class="btn btn-primary mt-3" id="btnAgregarCarrito">Agregar al Carrito</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5 pt-5">
        <h2 class="text-center">{{ $categoria['nombre'] }}</h2>
        <p class="text-center">{{ $categoria['descripcion'] }}</p>
        <div class="banner-container mt-3">
            <div class="owl-carousel">
                <img src="https://www.recetasnestle.com.ec/sites/default/files/srh_recipes/4e4293857c03d819e4ae51de1e86d66a.jpg" alt="Entrada de empanadas">
                <img src="https://www.comedera.com/wp-content/uploads/2022/09/teque%C3%B1os-venezolanos.jpg" alt="Tequeños venezolanos">
                <img src="https://www.laylita.com/recetas/wp-content/uploads/2018/06/1-Empanadas-de-carne.jpg" alt="Empanadas de carne">
            </div>
        </div>
        <div class="list-group mt-3">
            @foreach ($productos as $producto)
            <div class="list-group-item list-group-item-action menu-item hover-item"
                onclick="mostrarDetallesProducto(
                    '{{ addslashes($producto['nombre']) }}',
                    '{{ addslashes($producto['descripcion']) }}',
                    {{ $producto['precio'] }},
                    '{{ addslashes($producto['imagen_url']) }}',
                    '{{ isset($producto['ingredientes']) ? addslashes(implode(', ', $producto['ingredientes'])) : '' }}'
                )">
                <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}">
                <div>
                    <strong>{{ $producto['nombre'] }}</strong><br>
                    Q{{ number_format($producto['precio'], 2) }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="card-redirect">
        <h4>¿Terminaste tu pedido?</h4>
        <button class="btn-animado" onclick="window.location.href='{{ route('cliente.menu') }}'">
            Regresar al Menú
        </button>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endpush

@push('scripts')
<script>
function mostrarDetallesProducto(nombre, descripcion, precio, imagen, ingredientes) {
    window.productoActual = {
        nombre: nombre,
        descripcion: descripcion,
        precio: precio,
        imagen: imagen,
        ingredientes: ingredientes ? ingredientes.split(', ') : []
    };
    document.getElementById('modalNombre').textContent = nombre;
    document.getElementById('modalDescripcion').textContent = descripcion;
    document.getElementById('modalPrecio').textContent = `Q${parseFloat(precio).toFixed(2)}`;
    document.getElementById('modalImagen').src = imagen;
    const ingredientesContainer = document.getElementById('ingredientesContainer');
    ingredientesContainer.innerHTML = '';
    if (window.productoActual.ingredientes.length > 0 && window.productoActual.ingredientes[0].trim() !== '') {
        window.productoActual.ingredientes.forEach(ing => {
            const label = document.createElement('label');
            label.innerHTML = `<input type=\"checkbox\" class=\"ingredient-checkbox\" checked data-ingrediente=\"${ing.trim()}\"> ${ing.trim()}`;
            ingredientesContainer.appendChild(label);
            ingredientesContainer.appendChild(document.createElement('br'));
        });
    } else {
        ingredientesContainer.innerHTML = '<p>No se especificaron ingredientes</p>';
    }
    document.getElementById('btnAgregarCarrito').onclick = function() {
        const removidos = [];
        ingredientesContainer.querySelectorAll('.ingredient-checkbox').forEach(c => {
            if (!c.checked) removidos.push(c.dataset.ingrediente);
        });
        window.agregarAlCarrito(nombre, descripcion, precio, removidos, imagen);
        bootstrap.Modal.getInstance(document.getElementById('productoModal')).hide();
    };
    new bootstrap.Modal(document.getElementById('productoModal')).show();
}
$(document).ready(function(){
    $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        items: 1,
        autoplay: true
    });
});
</script>
@endpush 