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
                <img src="https://images.unsplash.com/photo-1544025162-d76694265947" alt="Plato Principal 1">
                <img src="https://images.unsplash.com/photo-1559847844-5315695dadae" alt="Plato Principal 2">
                <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38" alt="Plato Principal 3">
            </div>
        </div>
        <div class="list-group mt-3">
            @foreach ($productos as $producto)
            <div class="list-group-item list-group-item-action menu-item hover-item"
                data-nombre="{{ $producto['nombre'] }}"
                data-descripcion="{{ $producto['descripcion'] }}"
                data-precio="{{ $producto['precio'] }}"
                data-imagen="{{ $producto['imagen_url'] }}"
                data-ingredientes="{{ isset($producto['ingredientes']) ? implode(', ', $producto['ingredientes']) : '' }}">
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

// Delegación de eventos para los productos
$(document).ready(function(){
    $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        items: 1,
        autoplay: true
    });
    $('.menu-item').on('click', function() {
        mostrarDetallesProducto(
            $(this).data('nombre'),
            $(this).data('descripcion'),
            parseFloat($(this).data('precio')),
            $(this).data('imagen'),
            $(this).data('ingredientes')
        );
    });
});
</script>
@endpush 