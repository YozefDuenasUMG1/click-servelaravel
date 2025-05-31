// JS Gestión de Usuarios
async function cargarUsuarios() {
    const res = await fetch('/admin/usuarios/api');
    const data = await res.json();
    const tbody = document.getElementById('usuarios-list');
    tbody.innerHTML = data.map(u => `
      <tr>
        <td>${u.id}</td>
        <td>${u.usuario}</td>
        <td>${u.rol}</td>
        <td>
          <button class="btn btn-sm btn-info" onclick="editarUsuario(${u.id})">Editar</button>
          <button class="btn btn-sm btn-danger" onclick="eliminarUsuario(${u.id})">Eliminar</button>
        </td>
      </tr>
    `).join('');
}

async function guardarUsuario(e) {
    e.preventDefault();
    const id = document.getElementById('user-id').value;
    const usuario = document.getElementById('usuario').value.trim();
    const rol = document.getElementById('rol').value;
    const password = document.getElementById('password').value;
    let url = '/admin/usuarios/api';
    let method = id ? 'PUT' : 'POST';
    let body = { usuario, rol };
    if (!id) body.password = password;
    if (id) body.id = id;
    if (!usuario || (!id && !password)) {
        alert('Usuario y contraseña son obligatorios');
        return;
    }
    if (usuario.length < 4) {
        alert('El nombre de usuario debe tener al menos 4 caracteres');
        return;
    }
    if (!id && password.length < 8) {
        alert('La contraseña debe tener al menos 8 caracteres');
        return;
    }
    const res = await fetch(url, {
        method: method,
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
        body: JSON.stringify(body)
    });
    const data = await res.json();
    if (data.success) {
        alert(data.message);
        document.getElementById('form-user').reset();
        document.getElementById('user-id').value = '';
        document.getElementById('password-group').style.display = '';
        document.getElementById('cancel-edit').style.display = 'none';
        cargarUsuarios();
    } else {
        alert(data.message || 'Error al guardar usuario');
    }
}

async function editarUsuario(id) {
    const res = await fetch(`/admin/usuarios/api/${id}`);
    const u = await res.json();
    document.getElementById('user-id').value = u.id;
    document.getElementById('usuario').value = u.usuario;
    document.getElementById('rol').value = u.rol;
    document.getElementById('password-group').style.display = 'none';
    document.getElementById('cancel-edit').style.display = '';
}

async function eliminarUsuario(id) {
    if (!confirm('¿Eliminar este usuario?')) return;
    const res = await fetch(`/admin/usuarios/api/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') } });
    const data = await res.json();
    if (data.success) {
        alert('Usuario eliminado');
        cargarUsuarios();
    } else {
        alert(data.message || 'Error al eliminar usuario');
    }
}

document.getElementById('form-user').addEventListener('submit', guardarUsuario);
document.getElementById('cancel-edit').addEventListener('click', function() {
    document.getElementById('form-user').reset();
    document.getElementById('user-id').value = '';
    document.getElementById('password-group').style.display = '';
    this.style.display = 'none';
});

document.addEventListener('DOMContentLoaded', cargarUsuarios); 