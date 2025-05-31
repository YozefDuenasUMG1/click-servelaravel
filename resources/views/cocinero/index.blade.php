@extends('layouts.app')

@section('title', 'Redirección a Cocina')

@push('styles')
<style>
body {
  margin: 0;
  padding: 0;
  background: linear-gradient(135deg, #dfe9f3, #ffffff);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
}
.card {
  background: white;
  padding: 3rem 4rem;
  border-radius: 1.5rem;
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  max-width: 400px;
  width: 100%;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 16px 50px rgba(0, 0, 0, 0.2);
}
.card h2 {
  margin-bottom: 1.5rem;
  font-size: 1.8rem;
  color: #222;
}
.btn {
  padding: 0.9rem 2.2rem;
  font-size: 1.1rem;
  color: white;
  background-color: #007bff;
  border: none;
  border-radius: 0.6rem;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s ease;
}
.btn:hover {
  background-color: #0056b3;
  transform: scale(1.05);
}
.btn:disabled {
  background-color: #999;
  cursor: not-allowed;
  transform: none;
}
.loading {
  margin-top: 1.2rem;
  font-size: 1rem;
  color: #555;
  display: none;
}
</style>
@endpush

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
  <div class="card">
    <h2>Ir a la Vista de Cocina</h2>
    <button class="btn" id="btnIr">Ir a Cocina</button>
    <div class="loading" id="loadingText">Redirigiendo...</div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const btn = document.getElementById('btnIr');
  const loadingText = document.getElementById('loadingText');
  btn.addEventListener('click', () => {
    btn.disabled = true;
    loadingText.style.display = 'block';
    setTimeout(() => {
      window.location.href = "{{ route('cocinero.panel') }}";
    }, 1200);
  });
</script>
@endpush 