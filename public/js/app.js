document.addEventListener('DOMContentLoaded', function () {
    cargarPedidos();

    const fechaInput = document.getElementById('selector-fecha');
    const mesaInput = document.getElementById('filtro-mesa');
    if (fechaInput) fechaInput.addEventListener('change', filtrarPedidos);
    if (mesaInput) mesaInput.addEventListener('change', filtrarPedidos);

    // Mostrar fecha actual
    const fechaActual = new Date().toLocaleDateString();
    const fechaActualSpan = document.getElementById('fecha-actual');
    if (fechaActualSpan) fechaActualSpan.textContent = fechaActual;
});

function cargarPedidos(filtros = {}) {
    fetch('/api/pedidos')
        .then(res => res.json())
        .then(pedidos => {
            mostrarPedidos(pedidos, filtros);
        });
}

function filtrarPedidos() {
    const fecha = document.getElementById('selector-fecha').value;
    const mesa = document.getElementById('filtro-mesa').value;
    cargarPedidos({ fecha, mesa });
}

function mostrarPedidos(pedidos, filtros) {
    let pedidosFiltrados = pedidos;

    // Filtrar por fecha si se selecciona
    if (filtros.fecha) {
        pedidosFiltrados = pedidosFiltrados.filter(p =>
            p.fecha_hora && p.fecha_hora.startsWith(filtros.fecha)
        );
    }
    // Filtrar por mesa si se selecciona
    if (filtros.mesa && filtros.mesa !== 'todas') {
        pedidosFiltrados = pedidosFiltrados.filter(p => p.mesa == filtros.mesa);
    }

    // Calcular totales
    let totalPedidos = pedidosFiltrados.length;
    let totalImporte = pedidosFiltrados.reduce((sum, p) => sum + parseFloat(p.total), 0);

    document.getElementById('total-pedidos').textContent = totalPedidos;
    document.getElementById('total-importe').textContent = totalImporte.toFixed(2);

    // Mostrar fecha de consulta
    document.getElementById('fecha-consulta').textContent = filtros.fecha ? `Filtrado por: ${filtros.fecha}` : '';

    // Renderizar cards
    const cont = document.getElementById('pedidos-container');
    cont.innerHTML = '';
    if (pedidosFiltrados.length === 0) {
        cont.innerHTML = '<div class="alert alert-warning text-center">No hay pedidos para los filtros seleccionados.</div>';
        return;
    }

    pedidosFiltrados.forEach(pedido => {
        const estadoClass = pedido.estado === 'completado'
            ? 'estado-completado'
            : pedido.estado === 'cancelado'
                ? 'estado-cancelado'
                : 'estado-pendiente';

        let itemsHtml = '';
        if (pedido.items_json && Array.isArray(pedido.items_json)) {
            itemsHtml = '<ul class="items-list">' +
                pedido.items_json.map(item =>
                    `<li>
                        <strong>${item.nombre} x${item.cantidad}</strong>
                        ${item.ingredientes_removidos && item.ingredientes_removidos.length
                            ? `<div class="text-danger"><small>Sin: ${item.ingredientes_removidos.join(', ')}</small></div>`
                            : ''}
                    </li>`
                ).join('') +
                '</ul>';
        } else {
            itemsHtml = `<div>${pedido.pedido || ''}</div>`;
        }

        cont.innerHTML += `
            <div class="card pedido-card ${estadoClass}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-primary">Mesa ${pedido.mesa}</span>
                        <span class="badge bg-secondary">${pedido.estado.charAt(0).toUpperCase() + pedido.estado.slice(1)}</span>
                    </div>
                    <div class="mb-2">${itemsHtml}</div>
                    ${pedido.detalle ? `<div class="alert alert-info">${pedido.detalle}</div>` : ''}
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-muted">Fecha: ${pedido.fecha_hora ? pedido.fecha_hora : ''}</small>
                        <span class="fw-bold">Q${parseFloat(pedido.total).toFixed(2)}</span>
                    </div>
                </div>
            </div>
        `;
    });
} 