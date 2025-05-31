<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('cliente.index') }}">
            <img src="{{ asset('images/click&serveimg.png') }}" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
            Click&Serve
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cliente.index') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cliente.menu') }}">Menú</a>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('cliente.pedidos') }}">Mis Pedidos</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); clearLocalStorage();">Cerrar sesión</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                    </li>
                @endauth
                <li class="nav-item">
                    <button id="toggle-carrito-nav" class="btn btn-secondary position-relative">
                        <img src="{{ asset('images/carrito.png') }}" alt="Carrito" style="width: 30px; height: 30px;" class="rounded-full shadow-md hover:bg-blue-700 transition duration-300 cursor-pointer" />
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">0</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Overlay y Carrito -->
<div class="overlay" id="overlay"></div>

<div id="carrito-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Carrito de Pedido</h4>
        <button class="btn-close" onclick="toggleCarrito()"></button>
    </div>
    <div class="form-group mb-3">
        <label for="mesa-select" class="form-label">Número de Mesa:</label>
        <select class="form-select" id="mesa-select">
            <option value="" selected disabled>Seleccionar mesa</option>
            @for($i = 1; $i <= 10; $i++)
                <option value="{{ $i }}">Mesa {{ $i }}</option>
            @endfor
        </select>
    </div>
    <p id="numero-mesa" class="fw-bold"></p>
    <h5 class="mb-3">Detalles del Pedido</h5>
    <div id="carrito" class="mb-4"></div>
    <div class="cart-total-section">
        <h5 class="d-flex justify-content-between">
            <span>Total:</span> 
            <span>Q<span id="total">0</span></span>
        </h5>
    </div>
    <div class="form-group mb-3 mt-3">
        <label for="detalle" class="form-label">Detalles adicionales:</label>
        <textarea class="form-control" id="detalle" rows="2" placeholder="Instrucciones especiales, alergias, etc."></textarea>
    </div>
    <button class="btn btn-primary mt-3 w-100" onclick="enviarPedido()">Enviar Pedido</button>
</div>

<!-- Modal para confirmación de pedido -->
<div class="modal fade" id="confirmacionPedidoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <pre id="mensajePedido" class="border p-3 bg-light" style="white-space: pre-wrap;"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Seguir pidiendo</button>
                <button type="button" class="btn btn-primary" onclick="confirmarPedido()">Confirmar Pedido</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* ... estilos originales del navbar ... */
    @media (max-width: 600px) {
        nav.navbar .navbar-brand {
            font-size: 1rem;
            padding: 2px 4px;
        }
        nav.navbar .nav-link {
            font-size: 0.95rem;
            padding: 6px 8px;
        }
        #toggle-carrito-nav img {
            width: 24px !important;
            height: 24px !important;
        }
        .navbar-toggler {
            padding: 4px 8px;
            font-size: 1.1rem;
        }
    }
</style>

<script>
function clearLocalStorage() {
    localStorage.clear();
}

// --- Carrito de pedidos ---
let pedidoItems = JSON.parse(localStorage.getItem('pedidoItems') || '[]');
let numeroMesa = "";

// Actualiza la variable numeroMesa cuando el usuario selecciona una mesa
const mesaSelect = document.getElementById('mesa-select');
if (mesaSelect) {
    mesaSelect.addEventListener('change', function() {
        numeroMesa = this.value;
    });
    // Si ya había una mesa seleccionada antes (por recarga)
    if (mesaSelect.value) numeroMesa = mesaSelect.value;
}

function agregarAlCarrito(nombre, descripcion, precio, ingredientesRemovidos = []) {
    const item = {
        nombre: nombre,
        descripcion: descripcion,
        precio: precio,
        cantidad: 1,
        ingredientes_removidos: ingredientesRemovidos
    };
    const itemExistente = pedidoItems.findIndex(i => i.nombre === nombre);
    if (itemExistente !== -1) {
        pedidoItems[itemExistente].cantidad += 1;
    } else {
        pedidoItems.push(item);
    }
    document.getElementById("cart-count").textContent = pedidoItems.length;
    localStorage.setItem('pedidoItems', JSON.stringify(pedidoItems));
    actualizarVistaCarrito();
}

function actualizarVistaCarrito() {
    const carritoElement = document.getElementById("carrito");
    const totalElement = document.getElementById("total");
    const cartCountElement = document.getElementById("cart-count");
    carritoElement.innerHTML = "";
    if (pedidoItems.length === 0) {
        carritoElement.innerHTML = "<p class='text-muted'>El carrito está vacío</p>";
        totalElement.textContent = "0.00";
        cartCountElement.textContent = "0";
        return;
    }
    let total = 0;
    pedidoItems.forEach((item, index) => {
        const itemTotal = item.precio * item.cantidad;
        total += itemTotal;
        let ingredientesRemovidosHtml = '';
        if (item.ingredientes_removidos && item.ingredientes_removidos.length > 0) {
            ingredientesRemovidosHtml = `
                <div class="text-danger fst-italic">
                    <small>Sin: ${item.ingredientes_removidos.join(', ')}</small>
                </div>`;
        }
        const div = document.createElement("div");
        div.className = "cart-item";
        div.innerHTML = `
            <div class="d-flex justify-content-between">
                <div class="cart-item-header">${item.nombre} x${item.cantidad}</div>
                <div>
                    <button class="btn btn-sm btn-outline-secondary me-1" onclick="ajustarCantidad(${index}, -1)">-</button>
                    <button class="btn btn-sm btn-outline-secondary me-1" onclick="ajustarCantidad(${index}, 1)">+</button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarItem(${index})">X</button>
                </div>
            </div>
            <div class="cart-item-details">
                ${item.descripcion}
                ${ingredientesRemovidosHtml}
            </div>
            <div class="d-flex justify-content-between">
                <span>Precio unitario: Q${item.precio.toFixed(2)}</span>
                <strong>Q${itemTotal.toFixed(2)}</strong>
            </div>
        `;
        carritoElement.appendChild(div);
    });
    totalElement.textContent = total.toFixed(2);
    cartCountElement.textContent = pedidoItems.length;
}

function ajustarCantidad(index, cambio) {
    pedidoItems[index].cantidad += cambio;
    if (pedidoItems[index].cantidad <= 0) {
        pedidoItems.splice(index, 1);
    }
    localStorage.setItem('pedidoItems', JSON.stringify(pedidoItems));
    actualizarVistaCarrito();
}

function eliminarItem(index) {
    pedidoItems.splice(index, 1);
    localStorage.setItem('pedidoItems', JSON.stringify(pedidoItems));
    actualizarVistaCarrito();
}

function enviarPedido() {
    if (!numeroMesa) {
        alert("Por favor selecciona un número de mesa");
        return;
    }
    if (pedidoItems.length === 0) {
        alert("El carrito está vacío");
        return;
    }
    const detalle = document.getElementById("detalle").value;
    let mensaje = `Pedido para la mesa ${numeroMesa}\n\nDetalles del pedido:\n`;
    pedidoItems.forEach(item => {
        mensaje += `- ${item.nombre} x${item.cantidad}: Q${(item.precio * item.cantidad).toFixed(2)}\n`;
        if (item.ingredientes_removidos && item.ingredientes_removidos.length > 0) {
            mensaje += `  Sin: ${item.ingredientes_removidos.join(', ')}\n`;
        }
    });
    mensaje += `\nTotal: Q${document.getElementById("total").textContent}`;
    if (detalle.trim() !== "") {
        mensaje += `\n\nInstrucciones especiales: ${detalle}`;
    }
    document.getElementById('mensajePedido').textContent = mensaje;
    const modal = new bootstrap.Modal(document.getElementById('confirmacionPedidoModal'));
    modal.show();
    toggleCarrito();
}

function confirmarPedido() {
    const detalle = document.getElementById("detalle").value;
    const total = parseFloat(document.getElementById("total").textContent);
    const pedidoData = {
        mesa: numeroMesa,
        pedido: pedidoItems.map(item => `${item.nombre} x${item.cantidad}`).join(', '),
        detalle: detalle,
        estado: 'pendiente',
        total: total,
        fecha_hora: new Date().toISOString(),
        items_json: JSON.stringify(pedidoItems)
    };
    fetch('/cliente/enviar-pedido', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
        },
        body: JSON.stringify(pedidoData)
    })
    .then(response => {
        if (!response.ok) throw new Error('Error al enviar el pedido');
        return response.json();
    })
    .then(data => {
        alert("¡Pedido confirmado! Se está preparando en cocina.");
        pedidoItems = [];
        localStorage.setItem('pedidoItems', JSON.stringify(pedidoItems));
        document.getElementById("detalle").value = "";
        actualizarVistaCarrito();
        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmacionPedidoModal'));
        modal.hide();
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Hubo un error al procesar el pedido. Por favor, intente de nuevo.");
    });
}

// Inicializa la vista del carrito al cargar la página
actualizarVistaCarrito();
</script> 