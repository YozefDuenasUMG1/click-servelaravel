<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Click&Serve')</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- OwlCarousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styless2.css') }}">
    @stack('styles')
</head>
<body>
    @yield('content')

    <!-- Bootstrap JS (bundle, incluye Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- OwlCarousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    
    <!-- Lógica global para carrito y overlay -->
    <style>
        #carrito-container {
            position: fixed;
            top: 70px;
            right: 20px;
            width: 350px;
            max-width: 95vw;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            z-index: 1051;
            padding: 24px 18px 18px 18px;
            display: none;
            transition: all 0.3s cubic-bezier(.4,0,.2,1);
        }
        .overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.25);
            z-index: 1050;
            display: none;
        }
        @media (max-width: 600px) {
            #carrito-container { right: 2vw; left: 2vw; width: 96vw; }
        }
    </style>
    <script>
    // Mostrar/ocultar carrito y overlay
    function toggleCarrito(show) {
        const carrito = document.getElementById('carrito-container');
        const overlay = document.getElementById('overlay');
        if (!carrito || !overlay) return;
        if (show === undefined) show = carrito.style.display !== 'block';
        carrito.style.display = show ? 'block' : 'none';
        overlay.style.display = show ? 'block' : 'none';
        if (show) renderizarCarrito();
    }
    // Click en el botón del navbar
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('toggle-carrito-nav');
        if (btn) btn.addEventListener('click', function(e) {
            e.preventDefault();
            toggleCarrito(true);
        });
        // Cerrar al hacer click en overlay
        const overlay = document.getElementById('overlay');
        if (overlay) overlay.addEventListener('click', function() {
            toggleCarrito(false);
        });
        // Cerrar con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') toggleCarrito(false);
        });
        // Actualizar contador del carrito
        actualizarContadorCarrito();
        renderizarCarrito();
    });
    // Actualizar el contador del carrito
    function actualizarContadorCarrito() {
        let carrito = JSON.parse(localStorage.getItem('pedidoItems') || '[]');
        let count = carrito.length;
        let badge = document.getElementById('cart-count');
        if (badge) badge.textContent = count;
    }
    // Llama esto después de agregar/eliminar productos
    window.actualizarContadorCarrito = actualizarContadorCarrito;
    // Asegura que toggleCarrito esté global
    window.toggleCarrito = toggleCarrito;

    // Lógica para agregar productos al carrito
    function agregarAlCarrito(nombre, descripcion, precio, ingredientesRemovidos = [], imagen = null) {
        let carrito = JSON.parse(localStorage.getItem('pedidoItems') || '[]');
        // Puedes mejorar la lógica para evitar duplicados, aquí solo agrega
        carrito.push({ nombre, descripcion, precio, ingredientesRemovidos, imagen, cantidad: 1 });
        localStorage.setItem('pedidoItems', JSON.stringify(carrito));
        actualizarContadorCarrito();
        renderizarCarrito();
    }
    window.agregarAlCarrito = agregarAlCarrito;

    // Renderizar el carrito en el panel
    function renderizarCarrito() {
        let carrito = JSON.parse(localStorage.getItem('pedidoItems') || '[]');
        let carritoDiv = document.getElementById('carrito');
        let totalDiv = document.getElementById('total');
        if (!carritoDiv || !totalDiv) return;
        if (carrito.length === 0) {
            carritoDiv.innerHTML = '<p class="text-center text-muted">El carrito está vacío.</p>';
            totalDiv.textContent = '0';
            return;
        }
        let total = 0;
        let html = '<ul class="list-group">';
        carrito.forEach((item, idx) => {
            total += parseFloat(item.precio);
            html += `<li class='list-group-item d-flex justify-content-between align-items-center'>
                <div>
                    <strong>${item.nombre}</strong><br>
                    <small>Q${parseFloat(item.precio).toFixed(2)}</small>
                    ${item.ingredientesRemovidos && item.ingredientesRemovidos.length > 0 ? `<br><small class='text-danger'>Sin: ${item.ingredientesRemovidos.join(', ')}</small>` : ''}
                </div>
                <button class='btn btn-sm btn-danger' onclick='eliminarDelCarrito(${idx})'>&times;</button>
            </li>`;
        });
        html += '</ul>';
        carritoDiv.innerHTML = html;
        totalDiv.textContent = total.toFixed(2);
    }
    window.renderizarCarrito = renderizarCarrito;

    // Eliminar producto del carrito
    function eliminarDelCarrito(idx) {
        let carrito = JSON.parse(localStorage.getItem('pedidoItems') || '[]');
        carrito.splice(idx, 1);
        localStorage.setItem('pedidoItems', JSON.stringify(carrito));
        actualizarContadorCarrito();
        renderizarCarrito();
    }
    window.eliminarDelCarrito = eliminarDelCarrito;
    </script>
    @stack('scripts')
</body>
</html> 