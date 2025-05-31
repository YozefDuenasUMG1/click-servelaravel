@extends('layouts.app')

@section('content')
    @include('cliente.navbar')
    <!-- Modal para detalles del producto -->
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
        <h2 class="text-center">{{ $categoria['nombre'] ?? 'Bebidas' }}</h2>
        <p class="text-center">{{ $categoria['descripcion'] ?? '' }}</p>
        <div class="banner-container mt-3">
            <div class="owl-carousel">
                <img src="https://www.tuhogar.com/content/dam/cp-sites/home-care/tu-hogar/es_mx/recetas/snacks-bebidas-y-postres/aprende-a-preparar-batidos-saludables/4-ideas-para-preparar-batidos-saludables-axion.jpg" alt="Batido saludable">
                <img src="https://www.recetasnestle.com.ec/sites/default/files/styles/recipe_detail_desktop/public/srh_recipes/4e4293857c03d819e4ae51de1e86d66a.jpg" alt="Batido de frutas">
                <img src="https://www.pequerecetas.com/wp-content/uploads/2020/10/batidos-de-frutas.jpg" alt="Variedad de batidos">
            </div>
        </div>
        <div class="list-group mt-3">
            @foreach ($productos as $producto)
                <div class='card-desayuno menu-item hover-item'
                    data-nombre='{{ $producto["nombre"] }}'
                    data-descripcion='{{ $producto["descripcion"] }}'
                    data-precio='{{ $producto["precio"] }}'
                    data-imagen='{{ $producto["imagen_url"] }}'
                    data-ingredientes='@json($producto["ingredientes"])'>
                    <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}">
                    <div class="info">
                        <strong>{{ $producto['nombre'] }}</strong>
                        <span class="precio">Q{{ number_format($producto['precio'], 2) }}</span>
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
window.productoActual = null;
window.mostrarDetallesProducto = function(nombre, descripcion, precio, imagen, ingredientes) {
    window.productoActual = {
        nombre,
        descripcion,
        precio,
        imagen,
        ingredientes: ingredientes ? ingredientes.split(',') : []
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
};
document.addEventListener('DOMContentLoaded', function() {
    if (window.jQuery && window.$ && $(".owl-carousel").owlCarousel) {
        $(".owl-carousel").owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            items: 1,
            autoplay: true
        });
    }
    document.querySelectorAll('.menu-item').forEach(function(item) {
        item.addEventListener('click', function() {
            const nombre = this.getAttribute('data-nombre');
            const descripcion = this.getAttribute('data-descripcion');
            const precio = parseFloat(this.getAttribute('data-precio'));
            const imagen = this.getAttribute('data-imagen');
            const ingredientes = this.getAttribute('data-ingredientes');
            window.mostrarDetallesProducto(nombre, descripcion, precio, imagen, ingredientes);
        });
    });
    var btnRegresar = document.getElementById('btn-regresar-menu');
    if (btnRegresar) {
        btnRegresar.onclick = function() {
            window.location.href = "{{ route('cliente.menu') }}";
        };
    }
});
</script>
@endpush 