<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<style>
.sidebar {
  position: fixed;
  left: 0; top: 0; bottom: 0;
  width: 250px;
  background: #fff;
  box-shadow: 2px 0 12px rgba(0,0,0,0.07);
  z-index: 1001;
  padding-top: 20px;
  transition: left 0.3s;
  overflow-y: auto;
  max-height: 100vh;
}
.sidebar .letramod { padding: 10px 20px 0 20px; color: #888; font-size: 0.95rem; font-weight: 600; }
.sidebar .menu { list-style: none; padding: 0; margin: 0 0 10px 0; }
.sidebar .menu-item { margin: 0; }
.sidebar .menu-link {
  display: flex; align-items: center; gap: 12px;
  padding: 12px 20px;
  color: #333; text-decoration: none;
  font-weight: 500; border-radius: 8px;
  transition: background 0.2s, color 0.2s;
}
.sidebar .menu-link:hover, .sidebar .menu-link.active {
  background: #f0f4ff; color: #0d6efd;
}
.sidebar .menu-link i { font-size: 1.3rem; }
.sidebar .footer {
  position: absolute; bottom: 0; left: 0; width: 100%; padding: 18px 20px; background: #f8f9fa; border-top: 1px solid #eee;
}
.sidebar .user { display: flex; align-items: center; gap: 10px; }
.sidebar .user-data { flex: 1; }
.sidebar .user-data .name { font-weight: 600; font-size: 1rem; }
.sidebar .user-data .email { font-size: 0.9rem; color: #888; }
.sidebar .user-icon i { font-size: 1.3rem; color: #dc3545; cursor: pointer; }
.menu-btn.sidebar-btn { position: fixed; left: 15px; top: 15px; z-index: 1100; background: #fff; border-radius: 50%; box-shadow: 0 2px 8px rgba(0,0,0,0.08); width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; cursor: pointer; }
.menu-btn.sidebar-btn i { font-size: 1.7rem; }
@media (max-width: 991px) {
  .sidebar { left: -260px; }
  .sidebar.active { left: 0; }
}
@media (min-width: 992px) {
  .sidebar { left: 0; }
  .menu-btn.sidebar-btn { display: none; }
  .admin-panel, .usuarios-container, .container-dashboard { margin-left: 250px; }
}
</style>
<div class="menu-btn sidebar-btn" id="sidebar-btn">
    <i class='bx bx-menu'></i>
    <i class='bx bx-x' style="display:none;"></i>
</div>
<div class="sidebar" id="sidebar">
    <div class="letramod">
        <span>Administrador</span>
    </div>
    <ul class="menu">
        <li class="menu-item menu-item-static">
            <a href="{{ route('admin.panel') }}" class="menu-link"><i class='bx bx-home-alt-2'></i><span>Panel</span></a>
        </li>
        <li class="menu-item menu-item-static">
            <a href="{{ route('admin.productos.gestion') }}" class="menu-link"><i class='bx bx-menu'></i><span>Gestión de Menú</span></a>
        </li>
        <li class="menu-item menu-item-static">
            <a href="{{ route('cliente.index') }}" class="menu-link" target="_blank"><i class='bx bx-basket'></i><span>Sistema de Pedidos</span></a>
        </li>
        <li class="menu-item menu-item-static">
            <a href="{{ route('admin.usuarios') }}" class="menu-link"><i class='bx bx-user'></i><span>Gestión de Usuarios</span></a>
        </li>
        <li class="menu-item menu-item-static">
            <a href="{{ route('cocinero.panel') }}" class="menu-link" target="_blank"><i class='bx bx-food-menu'></i><span>Cocina</span></a>
        </li>
        <li class="menu-item menu-item-static">
            <a href="{{ route('admin.dashboard') }}" class="menu-link"><i class='bx bx-bar-chart'></i><span>Estadísticas</span></a>
        </li>
        <li class="menu-item menu-item-static">
            <a href="{{ route('cajero.index') }}" class="menu-link" target="_blank"><i class='bx bx-cash'></i><span>Cajero</span></a>
        </li>
    </ul>
    <div class="footer">
        <div class="user">
            <div class="user-data">
                <span class="name">{{ Auth::user()->name ?? 'Usuario' }}</span>
                <span class="email">{{ Auth::user()->email ?? '' }}</span>
            </div>
            <div class="user-icon">
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none; border:none; padding:0; cursor:pointer;">
                        <i class='bx bx-log-out' title="Cerrar sesión"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
// Sidebar toggle
const sidebarBtn = document.getElementById('sidebar-btn');
const sidebar = document.getElementById('sidebar');
const menuIcon = sidebarBtn.querySelector('.bx-menu');
const closeIcon = sidebarBtn.querySelector('.bx-x');
sidebarBtn.addEventListener('click', function() {
  sidebar.classList.toggle('active');
  if (sidebar.classList.contains('active')) {
    menuIcon.style.display = 'none';
    closeIcon.style.display = '';
  } else {
    menuIcon.style.display = '';
    closeIcon.style.display = 'none';
  }
});
</script> 