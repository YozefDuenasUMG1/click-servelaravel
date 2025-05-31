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

    <!-- Hero Section -->
    <header class="hero">
        <div class="hero-content">
            <h1>Bienvenidos</h1>
            <br>
            <a href="{{ route('cliente.menu') }}"><button>MENU</button></a>
        </div>
    </header>

    <section class="fine-dining">
        <div class="carousel-indicators">
            <span id="left-arrow">&larr;</span>
            <div class="dots">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot active"></span>
            </div>
            <span id="right-arrow">&rarr;</span>
        </div>
        <br>
        <section>
            <div class="dining-gallery">
                <img src="https://cdn7.kiwilimon.com/ss_secreto/3010/3010.jpg" alt="Dining Room" />
                <img src="https://www.shutterstock.com/image-photo/elegant-restaurant-dining-scene-featuring-600nw-2541042231.jpg" alt="Dish" />
                <img src="https://img.freepik.com/foto-gratis/primer-plano-cristaleria-brillante-pie-detras-placa-cena_8353-664.jpg" alt="Guests" />
            </div>
        </section>
        <section style="margin-top:100px;">
            <div class="dining-gallery">
                <img src="https://media.istockphoto.com/id/1411971240/es/foto/copa-de-vino-y-champain-en-bodas-y-eventos-de-lujo.jpg?s=612x612&w=0&k=20&c=u_hEm_WfnmQtfl9SCsaJ8zNI0BXpj_hCOSt-pd6ezFU=" alt="Dining Room" />
                <img src="https://i0.wp.com/foodandpleasure.com/wp-content/uploads/2022/08/restaurantes-de-lujo-bajel-sofitel.jpg?fit=1280%2C868&ssl=1" alt="Dish" />
                <img src="https://animalgourmet.com/wp-content/uploads/2018/01/jay-wennington-2065-1-e1516220610269.jpg" alt="Guests" />
            </div>
        </section>
    </section>

    <!-- Contenido principal -->
    <div class="container text-center" style="padding-top: 80px;">
        <div class="row mt-4">
            <div class="col-6"  style="margin-bottom: -90px;" ></div>
            <div class="col-6"></div>
        </div>
        <!-- Ofertas -->
        <h3 class="mt-4 text-danger" style="font-size: 65px;" >Ofertas para ti</h3>
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <div class="card-oferta position-relative rounded-4 overflow-hidden shadow-lg hover-grow"
                    data-nombre="2 Tocino Ranch"
                    data-descripcion="Promoción especial: Dos hamburguesas con tocino, queso, ranch y lechuga."
                    data-precio="75.00"
                    data-imagen="https://img.freepik.com/fotos-premium/hamburguesa-mucho-humo-sobre-fondo-oscuro_856795-3589.jpg"
                    data-ingredientes="">
                    <img src="https://img.freepik.com/fotos-premium/hamburguesa-mucho-humo-sobre-fondo-oscuro_856795-3589.jpg" class="img-fluid w-100" style="height: 250px; object-fit: cover;">
                    <div class="position-absolute bottom-0 w-100 text-white text-center p-2" style="background: rgba(0,0,0,0.6);">
                        <strong>2 Tocino Ranch x 75</strong>
                    </div>
                    <button class="btn btn-primary w-100 mt-2">Agregar al Carrito</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-oferta position-relative rounded-4 overflow-hidden shadow-lg hover-grow"
                    data-nombre="Hamburguesa de Pollo"
                    data-descripcion="Pechuga de pollo empanizada, lechuga, tomate y mayonesa especial."
                    data-precio="29.00"
                    data-imagen="https://tofuu.getjusto.com/orioneat-local/resized2/YKpAjwPmaEDuAhzpS-800-x.webp"
                    data-ingredientes="">
                    <img src="https://tofuu.getjusto.com/orioneat-local/resized2/YKpAjwPmaEDuAhzpS-800-x.webp" class="img-fluid w-100" style="height: 250px; object-fit: cover;">
                    <div class="position-absolute bottom-0 w-100 text-white text-center p-2" style="background: rgba(0,0,0,0.6);">
                        <strong>Hamburguesa de Pollo x 29</strong>
                    </div>
                    <button class="btn btn-primary w-100 mt-2">Agregar al Carrito</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <section class="fade-section">
        <section class="gift-card">
            <div class="gift-card__content">
                <div class="gift-card__image">
                    <img style="width: 300px;" src="{{ asset('images/click&serveimg.png') }}" alt="Bebida refrescante" />
                </div>
                <div class="gift-card__text">
                    <h2 class="creative-title">CLICK<span class="amp">&</span>SERVE</h2>
                    <p style="font-size: 22px; color: #333; line-height: 1.6; max-width: 800px; margin: 20px auto; text-align: center;">
                        <span style="font-weight: bold; color: #eab308;">Click&Serve</span> optimiza la experiencia gastronómica al permitir que los clientes realicen sus pedidos directamente desde la mesa, reduciendo la necesidad de personal adicional y agilizando el servicio.
                    </p>
                </div>
            </div>
        </section>
    </section>
    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <h5 class="fw-bold">Click&Serve</h5>
            <p>Síguenos en redes sociales</p>
            <div class="d-flex justify-content-center gap-3 mb-3">
                <a href="#" class="text-light fs-4"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-light fs-4"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-light fs-4"><i class="fab fa-whatsapp"></i></a>
            </div>
            <small>&copy; 2025 Click&Serve. Todos los derechos reservados.</small>
        </div>
    </footer>
    <div class="footer-bottom">
        <div class="cards" style="font-size: 2rem; color: white; display: flex; gap: 20px;">
            <i class="fab fa-cc-mastercard"></i>
            <i class="fab fa-cc-visa"></i>
            <i class="fab fa-cc-amex"></i>
            <i class="fab fa-cc-discover"></i>
        </div>
    </div>
    <!-- Scripts -->
    <script>
        // --- MODAL DETALLES PRODUCTO Y CARRITO ---
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
            document.querySelectorAll('.card-oferta').forEach(card => {
                card.addEventListener('click', function(e) {
                    if (e.target.tagName === 'BUTTON') return;
                    window.mostrarDetallesProducto(
                        this.dataset.nombre,
                        this.dataset.descripcion,
                        parseFloat(this.dataset.precio),
                        this.dataset.imagen,
                        this.dataset.ingredientes
                    );
                });
            });
            document.querySelectorAll('.card-oferta .btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const card = this.closest('.card-oferta');
                    window.mostrarDetallesProducto(
                        card.dataset.nombre,
                        card.dataset.descripcion,
                        parseFloat(card.dataset.precio),
                        card.dataset.imagen,
                        card.dataset.ingredientes
                    );
                });
            });
        });

        // Carousel hero
        const hero = document.querySelector('.hero');
        const dots = document.querySelectorAll('.dot');
        const leftArrow = document.getElementById('left-arrow');
        const rightArrow = document.getElementById('right-arrow');
        const backgrounds = [
            'url("https://foodandpleasure.com/wp-content/uploads/2022/04/terrazaz-masaryk-cuernomasaryk.jpg")',
            'url("https://img.hellofresh.com/w_3840,q_auto,f_auto,c_fill,fl_lossy/hellofresh_s3/image/HF_Y24_R16_W02_ES_ESSGB17598-4_Main_high-48eefd40.jpg")',
            'url("https://dynamic-media-cdn.tripadvisor.com/media/photo-o/19/c8/10/88/salao-do-vista.jpg?w=1200&h=1200&s=1")'
        ];
        let currentIndex = 0;
        function updateBackground() {
            if (hero) {
                hero.style.background = `${backgrounds[currentIndex]} no-repeat center center/cover`;
            }
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentIndex);
            });
        }
        if (leftArrow && rightArrow) {
            leftArrow.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + backgrounds.length) % backgrounds.length;
                updateBackground();
            });
            rightArrow.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % backgrounds.length;
                updateBackground();
            });
        }
        setInterval(() => {
            currentIndex = (currentIndex + 1) % backgrounds.length;
            updateBackground();
        }, 5000);
        updateBackground();
    </script>
@endsection 