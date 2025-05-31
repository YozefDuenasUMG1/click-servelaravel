@extends('layouts.app')

@push('styles')
<style>
body.menu-page { background-color: #fdf6f0; }
.menu-cards-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 50px;
    margin-bottom: 50px;
    padding: 0 20px;
}
.menu-cards-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-template-rows: repeat(2, 1fr);
    gap: 60px 48px;
    width: 100%;
    max-width: 1200px;
    min-height: 600px;
    justify-items: center;
    align-items: stretch;
    box-sizing: border-box;
}
.menu-cards-grid > div {
    display: flex;
    justify-content: center;
    align-items: stretch;
    width: 100%;
}
.categoria-card {
    width: 100%;
    max-width: 320px;
    min-width: 220px;
    margin: 0 auto;
    text-align: center;
    transition: transform 0.3s ease;
}
.categoria-card:hover {
    transform: translateY(-5px);
}
.categoria-title, .categoria-subtitle, .categoria-desc {
    text-align: center !important;
    margin-left: auto;
    margin-right: auto;
}
.categoria-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px 8px 0 0;
}
/* Distribución tipo diamante */
.menu-cards-grid > div:nth-child(1) { grid-column: 1; grid-row: 1; }
.menu-cards-grid > div:nth-child(2) { grid-column: 2; grid-row: 1; }
.menu-cards-grid > div:nth-child(3) { grid-column: 3; grid-row: 1; }
.menu-cards-grid > div:nth-child(4) { grid-column: 1; grid-row: 2; }
.menu-cards-grid > div:nth-child(5) { grid-column: 2; grid-row: 2; }
.menu-cards-grid > div:nth-child(6) { grid-column: 3; grid-row: 2; }
@media (max-width: 1100px) {
    .menu-cards-grid {
        gap: 40px 20px;
    }
}
@media (max-width: 900px) {
    .menu-cards-grid {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: repeat(3, 1fr);
        gap: 32px 12px;
        min-height: 0;
        max-width: 800px;
    }
    .menu-cards-grid > div:nth-child(1) { grid-column: 1; grid-row: 1; }
    .menu-cards-grid > div:nth-child(2) { grid-column: 2; grid-row: 1; }
    .menu-cards-grid > div:nth-child(3) { grid-column: 1; grid-row: 2; }
    .menu-cards-grid > div:nth-child(4) { grid-column: 2; grid-row: 2; }
    .menu-cards-grid > div:nth-child(5) { grid-column: 1; grid-row: 3; }
    .menu-cards-grid > div:nth-child(6) { grid-column: 2; grid-row: 3; }
}
@media (max-width: 700px) {
    .menu-cards-wrapper {
        margin-top: 18px;
        margin-bottom: 18px;
        padding: 0 10px;
    }
    .menu-cards-grid {
        grid-template-columns: 1fr;
        grid-template-rows: repeat(6, auto);
        gap: 18px 0;
        max-width: 500px;
    }
    .categoria-card {
        min-width: 90%;
        max-width: 100%;
    }
    .menu-cards-grid > div:nth-child(n) { 
        grid-column: 1 !important; 
        grid-row: auto !important;
    }
}
</style>
@endpush

@section('content')
    @include('cliente.navbar')
    <div class="container container-menu">
        <h1 class="titulo-menu text-center">Menú de la Casa</h1>
        <div class="menu-cards-wrapper">
            <div class="menu-cards-grid">
                @php
                    $categorias = [
                        [
                            'nombre' => 'Desayunos',
                            'img' => 'https://comedera.com/wp-content/uploads/sites/9/2022/12/Desayono-americano-shutterstock_2120331371.jpg',
                            'subtitulo' => 'Lo mejor de la Casa',
                            'desc' => 'Empieza tu día con nuestros deliciosos desayunos.',
                            'ruta' => route('cliente.desayunos')
                        ],
                        [
                            'nombre' => 'Platos Principales',
                            'img' => 'https://mandolina.co/wp-content/uploads/2024/06/carne-asada-a-la-parrilla-1080x550-1-1200x900.jpg',
                            'subtitulo' => 'El sabor de nuestro puerto',
                            'desc' => 'Nuestros platos estrella preparados con las mejores recetas.',
                            'ruta' => route('cliente.platos')
                        ],
                        [
                            'nombre' => 'Antojos',
                            'img' => 'https://foodisafourletterword.com/wp-content/uploads/2020/09/Instant_Pot_Birria_Tacos_with_Consomme_Recipe_tacoplate.jpg',
                            'subtitulo' => 'Lo mejor de la Casa',
                            'desc' => 'Deliciosos antojitos para compartir o disfrutar solo.',
                            'ruta' => route('cliente.antojos')
                        ],
                        [
                            'nombre' => 'Entradas',
                            'img' => 'https://www.recetasnestle.com.ec/sites/default/files/srh_recipes/4e4293857c03d819e4ae51de1e86d66a.jpg',
                            'subtitulo' => 'Para comenzar',
                            'desc' => 'Perfectas para compartir mientras esperas tu plato principal.',
                            'ruta' => route('cliente.entradas')
                        ],
                        [
                            'nombre' => 'Bebidas',
                            'img' => 'https://www.tuhogar.com/content/dam/cp-sites/home-care/tu-hogar/es_mx/recetas/snacks-bebidas-y-postres/aprende-a-preparar-batidos-saludables/4-ideas-para-preparar-batidos-saludables-axion.jpg',
                            'subtitulo' => 'Refrescantes',
                            'desc' => 'La mejor selección de bebidas para acompañar tu comida.',
                            'ruta' => route('cliente.bebidas')
                        ],
                        [
                            'nombre' => 'Postres',
                            'img' => 'https://images.aws.nestle.recipes/resized/2024_10_23T08_34_55_badun_images.badun.es_pastelitos_de_chocolate_blanco_y_queso_con_fresas_1290_742.jpg',
                            'subtitulo' => 'Dulces tentaciones',
                            'desc' => 'Termina tu comida con nuestros deliciosos postres caseros.',
                            'ruta' => route('cliente.postres')
                        ],
                    ];
                @endphp
                @foreach ($categorias as $cat)
                    <div>
                        <div class="categoria-card shadow-sm">
                            <a href="{{ $cat['ruta'] }}" class="text-decoration-none text-dark">
                                <img src="{{ $cat['img'] }}" alt="{{ $cat['nombre'] }}" class="categoria-img" />
                                <div class="categoria-body p-3">
                                    <h3 class="categoria-title">{{ $cat['nombre'] }}</h3>
                                    <div class="categoria-subtitle text-muted">{{ $cat['subtitulo'] }}</div>
                                    <p class="categoria-desc mt-2">{{ $cat['desc'] }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Botón Regresar -->
        <div class="text-center mt-5 mb-5">
            <a href="{{ route('cliente.index') }}" class="btn btn-danger btn-lg">Regresar al Inicio</a>
        </div>
    </div>
@endsection