@extends('layouts.app')

@section('title', 'Registro de Usuario - Click&serve')

@push('styles')
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          primary: '#2563EB',
          primaryLight: '#3B82F6',
          primaryDark: '#1E40AF',
          background: '#F3F4F6',
        },
        fontFamily: {
          display: ['Playfair Display', 'serif'],
          sans: ['Lato', 'sans-serif'],
        },
      },
    },
  }
</script>
@endpush

@section('content')
<body class="bg-background font-sans min-h-screen flex items-center justify-center p-6">
  <div class="w-full max-w-2xl">
    <div class="bg-white border border-blue-200 rounded-2xl shadow-xl p-10">
      <!-- Título -->
      <div class="text-center mb-10">
        <h1 class="text-5xl font-display font-bold text-primaryDark drop-shadow-sm">🍽️ Click&serve</h1>
        <p class="text-blue-600 mt-2 text-lg">Registro de Nuevo Usuario</p>
      </div>
      <!-- Mensajes de error y éxito -->
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
      <form action="{{ route('register') }}" method="post" id="registroForm" novalidate>
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Usuario (name) -->
          <div>
            <label for="name" class="block text-blue-700 text-lg font-semibold mb-3">Usuario</label>
            <div class="relative">
              <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-blue-300">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.21 0 4.29.534 6.121 1.474M15 11a3 3 0 10-6 0 3 3 0 006 0z" />
                </svg>
              </span>
              <input type="text" name="name" id="name" required value="{{ old('name') }}"
                class="w-full pl-14 pr-5 py-4 text-lg border border-blue-300 rounded-lg focus:outline-none focus:ring-3 focus:ring-primaryLight transition" />
            </div>
          </div>
          <!-- Email -->
          <div>
            <label for="email" class="block text-blue-700 text-lg font-semibold mb-3">Email</label>
            <div class="relative">
              <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-blue-300">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0zm0 0v1a2 2 0 01-2 2H10a2 2 0 01-2-2v-1" />
                </svg>
              </span>
              <input type="email" name="email" id="email" required value="{{ old('email') }}"
                class="w-full pl-14 pr-5 py-4 text-lg border border-blue-300 rounded-lg focus:outline-none focus:ring-3 focus:ring-primaryLight transition" />
            </div>
          </div>
          <!-- Contraseña -->
          <div>
            <label for="password" class="block text-blue-700 text-lg font-semibold mb-3">Contraseña</label>
            <div class="relative">
              <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-blue-300">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.657-1.343-3-3-3s-3 1.343-3 3m12 0c0-1.657-1.343-3-3-3s-3 1.343-3 3m0 4v4" />
                </svg>
              </span>
              <input type="password" name="password" id="password" required
                class="w-full pl-14 pr-5 py-4 text-lg border border-blue-300 rounded-lg focus:outline-none focus:ring-3 focus:ring-primaryLight transition" />
            </div>
            <p class="text-blue-400 mt-1 text-sm">Mínimo 8 caracteres</p>
          </div>
          <!-- Confirmar contraseña -->
          <div>
            <label for="password_confirmation" class="block text-blue-700 text-lg font-semibold mb-3">Confirmar Contraseña</label>
            <div class="relative">
              <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-blue-300">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.657-1.343-3-3-3s-3 1.343-3 3m12 0c0-1.657-1.343-3-3-3s-3 1.343-3 3m0 4v4" />
                </svg>
              </span>
              <input type="password" name="password_confirmation" id="password_confirmation" required
                class="w-full pl-14 pr-5 py-4 text-lg border border-blue-300 rounded-lg focus:outline-none focus:ring-3 focus:ring-primaryLight transition" />
            </div>
          </div>
          <!-- Rol (oculto) -->
          <div>
            <label class="block text-blue-700 text-lg font-semibold mb-3">Rol</label>
            <input type="text" disabled value="Cliente"
              class="w-full px-5 py-4 bg-blue-50 border border-blue-200 text-blue-400 rounded-lg cursor-not-allowed text-lg" />
            <input type="hidden" name="rol" value="cliente" />
          </div>
        </div>
        <!-- Botones -->
        <div class="flex flex-col sm:flex-row justify-between items-center mt-10 gap-6">
          <a href="{{ route('login') }}"
            class="w-full sm:w-auto text-center bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-4 px-10 rounded-lg transition text-lg">
            Cancelar
          </a>
          <button type="submit"
            class="w-full sm:w-auto bg-primary hover:bg-primaryDark text-white font-semibold py-4 px-10 rounded-lg transition transform active:scale-95 text-lg">
            Registrar Usuario
          </button>
        </div>
      </form>
    </div>
    <!-- Footer -->
    <div class="text-center mt-6 text-blue-400 text-sm">
      &copy; {{ date('Y') }} Click&serve
    </div>
  </div>
  <!-- Scripts -->
  <script>
      document.addEventListener('DOMContentLoaded', function() {
          const form = document.getElementById('registroForm');
          form.addEventListener('submit', function(e) {
              const usuario = document.getElementById('name');
              const password = document.getElementById('password');
              const confirmarPassword = document.getElementById('password_confirmation');
              if (usuario.value.trim().length < 4) {
                  e.preventDefault();
                  alert('El nombre de usuario debe tener al menos 4 caracteres');
                  usuario.focus();
                  return false;
              }
              if (password.value.length < 8) {
                  e.preventDefault();
                  alert('La contraseña debe tener al menos 8 caracteres');
                  password.focus();
                  return false;
              }
              if (password.value !== confirmarPassword.value) {
                  e.preventDefault();
                  alert('Las contraseñas no coinciden');
                  confirmarPassword.focus();
                  return false;
              }
          });
          // Validación en vivo para las contraseñas
          const password = document.getElementById('password');
          const confirmarPassword = document.getElementById('password_confirmation');
          function validarCoincidencia() {
              if (confirmarPassword.value === '') {
                  confirmarPassword.style.borderColor = '';
                  return;
              }
              if (password.value === confirmarPassword.value) {
                  confirmarPassword.parentElement.style.borderColor = '#22c55e';
              } else {
                  confirmarPassword.parentElement.style.borderColor = '#ef4444';
              }
          }
          password.addEventListener('keyup', validarCoincidencia);
          confirmarPassword.addEventListener('keyup', validarCoincidencia);
      });
  </script>
</body>
@endsection 