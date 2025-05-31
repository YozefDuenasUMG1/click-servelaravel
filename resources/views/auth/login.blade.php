@extends('layouts.app')

@section('title', 'Iniciar Sesión - Click&serve')

@push('styles')
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato:wght@400;700&display=swap" rel="stylesheet"/>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          primary: '#3B82F6',
          secondary: '#1E3A8A',
          light: '#F3F4F6',
          dark: '#1F2937',
          error: '#DC2626',
        },
        fontFamily: {
          display: ['Playfair Display', 'serif'],
          sans: ['Lato', 'sans-serif'],
        },
        boxShadow: {
          soft: '0 4px 20px rgba(0, 0, 0, 0.1)',
          glass: '0 8px 30px rgba(0, 0, 0, 0.12)',
        },
        borderRadius: {
          xl: '1.25rem',
        },
      }
    }
  }
</script>
@endpush

@section('content')
<body class="bg-gradient-to-br from-light via-blue-100 to-blue-200 min-h-screen flex items-center justify-center font-sans p-4">
  <div class="w-full max-w-md">
    <div class="bg-white/80 backdrop-blur-md border border-blue-200 rounded-xl shadow-glass p-8">
      <!-- Logo y Título -->
      <div class="text-center mb-8">
        <h1 class="text-4xl font-display font-bold text-secondary drop-shadow-sm">Click&serve</h1>
        <p class="text-gray-600 mt-2 text-base">Bienvenido al sistema</p>
      </div>
      <!-- Mensaje de Error -->
      @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-600 px-4 py-3 rounded mb-6 text-center text-sm">
          {{ session('error') }}
        </div>
      @endif
      @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-600 px-4 py-3 rounded mb-6 text-center text-sm">
          @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      @endif
      @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-6 text-center text-sm">
          {{ session('success') }}
        </div>
      @endif
      <!-- Formulario -->
      <form action="{{ route('login') }}" method="post" id="loginForm">
        @csrf
        <!-- Usuario/email -->
        <div class="mb-6">
          <label for="email" class="block text-base font-semibold text-gray-700 mb-2">Usuario o Email</label>
          <input 
            class="w-full bg-blue-50 text-gray-800 placeholder-gray-400 px-6 py-5 rounded-lg border border-blue-200 focus:outline-none focus:ring-2 focus:ring-primary transition text-xl"
            placeholder="Tu usuario o email"
            type="text"
            name="email"
            id="email"
            required
            value="{{ old('email') }}"
          >
        </div>
        <!-- Contraseña -->
        <div class="mb-8">
          <label for="password" class="block text-base font-semibold text-gray-700 mb-2">Contraseña</label>
          <input 
            class="w-full bg-blue-50 text-gray-800 placeholder-gray-400 px-6 py-5 rounded-lg border border-blue-200 focus:outline-none focus:ring-2 focus:ring-primary transition text-xl"
            placeholder="Tu contraseña"
            type="password"
            name="password"
            id="password"
            required
          >
        </div>
        <!-- Botón Iniciar -->
        <button 
          type="submit"
          class="w-full bg-primary hover:bg-blue-600 text-white font-bold py-4 rounded-xl text-xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1"
        >
          Iniciar Sesión
        </button>
      </form>
      <!-- Enlace de Registro -->
      <div class="text-center mt-6">
        <a 
          href="{{ route('register') }}"
          class="inline-block bg-white border border-primary text-primary font-semibold px-6 py-3 rounded-lg text-base mt-2 shadow hover:bg-primary hover:text-white transition-all duration-300"
        >
          ¿No tienes una cuenta? <span class="underline">Regístrate aquí</span>
        </a>
      </div>
    </div>
    <!-- Footer -->
    <div class="text-center mt-6 text-gray-400 text-xs">
      &copy; {{ date('Y') }} Click&serve - Todos los derechos reservados
    </div>
  </div>
  <script>
    const form = document.getElementById('loginForm');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    form.addEventListener('submit', function (e) {
      if (email.value.trim() === '') {
        e.preventDefault();
        alert('Por favor ingrese su usuario o email');
        email.focus();
        return false;
      }
      if (password.value.trim() === '') {
        e.preventDefault();
        alert('Por favor ingrese su contraseña');
        password.focus();
        return false;
      }
    });
  </script>
</body>
@endsection 