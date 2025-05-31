// Dashboard JS para consumir la API de Laravel
let charts = {};

function toggleTheme() {
    document.body.classList.toggle('dark-mode');
}

function updateKPIs(data) {
    document.getElementById('totalPedidos').textContent = data.totalPedidos || 0;
    document.getElementById('ingresosTotales').textContent = data.ingresosTotales || 'Q0.00';
    document.getElementById('ticketPromedio').textContent = data.ticketPromedio || 'Q0.00';
}

function updateCharts(data) {
    // Destruir gráficas existentes
    for (const key in charts) {
        if (charts[key]) charts[key].destroy();
    }
    // Pedidos por Día
    if (data.pedidosPorDia && data.pedidosPorDia.length > 0) {
        charts.pedidosPorDia = new Chart(document.getElementById('pedidosPorDia').getContext('2d'), {
            type: 'line',
            data: {
                labels: data.pedidosPorDia.map(item => item.dia),
                datasets: [{
                    label: 'Pedidos por Día',
                    data: data.pedidosPorDia.map(item => item.total),
                    borderColor: '#36A2EB',
                    fill: false
                }]
            },
            options: {responsive: true, plugins: {legend: {display: true}, title: {display: true, text: 'Pedidos por Día'}}}
        });
    }
    // Estado de Pedidos
    if (data.estadoPedidos && data.estadoPedidos.length > 0) {
        charts.estadoPedidos = new Chart(document.getElementById('estadoPedidos').getContext('2d'), {
            type: 'pie',
            data: {
                labels: data.estadoPedidos.map(item => item.estado),
                datasets: [{
                    data: data.estadoPedidos.map(item => item.cantidad),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
                }]
            },
            options: {responsive: true, plugins: {legend: {position: 'top'}, title: {display: true, text: 'Estado de Pedidos'}}}
        });
    }
    // Ingresos por Día
    if (data.ingresosPorDia && data.ingresosPorDia.length > 0) {
        charts.ingresosPorDia = new Chart(document.getElementById('ingresosPorDia').getContext('2d'), {
            type: 'bar',
            data: {
                labels: data.ingresosPorDia.map(item => item.dia),
                datasets: [{
                    label: 'Ingresos por Día',
                    data: data.ingresosPorDia.map(item => item.ingresos),
                    backgroundColor: '#4CAF50'
                }]
            },
            options: {responsive: true, plugins: {legend: {display: true}, title: {display: true, text: 'Ingresos por Día'}}}
        });
    }
    // Pedidos por Mesa
    if (data.pedidosPorMesa && data.pedidosPorMesa.length > 0) {
        charts.pedidosPorMesa = new Chart(document.getElementById('pedidosPorMesa').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: data.pedidosPorMesa.map(item => `Mesa ${item.mesa}`),
                datasets: [{
                    data: data.pedidosPorMesa.map(item => item.cantidad),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50']
                }]
            },
            options: {responsive: true, plugins: {legend: {position: 'top'}, title: {display: true, text: 'Pedidos por Mesa'}}}
        });
    }
    // Pedidos por Hora
    if (data.pedidosPorHora && data.pedidosPorHora.length > 0) {
        charts.pedidosPorHora = new Chart(document.getElementById('pedidosPorHora').getContext('2d'), {
            type: 'bar',
            data: {
                labels: data.pedidosPorHora.map(item => `${item.hora}:00`),
                datasets: [{
                    label: 'Pedidos por Hora',
                    data: data.pedidosPorHora.map(item => item.total),
                    backgroundColor: '#FF9800'
                }]
            },
            options: {responsive: true, plugins: {legend: {display: true}, title: {display: true, text: 'Pedidos por Hora'}}}
        });
    }
    // Producto más vendido
    if (data.productoMasVendido) {
        charts.productoMasVendido = new Chart(document.getElementById('productoMasVendido').getContext('2d'), {
            type: 'bar',
            data: {
                labels: [data.productoMasVendido.producto],
                datasets: [{
                    label: 'Producto más vendido',
                    data: [data.productoMasVendido.cantidad],
                    backgroundColor: '#8e44ad'
                }]
            },
            options: {responsive: true, plugins: {legend: {display: false}, title: {display: true, text: 'Producto más vendido'}}}
        });
    }
    // Ventas por categoría (si hay datos)
    if (data.ventasPorCategoria && data.ventasPorCategoria.length > 0) {
        charts.ventasPorCategoria = new Chart(document.getElementById('ventasPorCategoria').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: data.ventasPorCategoria.map(item => item.categoria),
                datasets: [{
                    data: data.ventasPorCategoria.map(item => item.total),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#8e44ad']
                }]
            },
            options: {responsive: true, plugins: {legend: {position: 'top'}, title: {display: true, text: 'Ventas por Categoría'}}}
        });
    }
}

async function fetchData() {
    document.getElementById('loading').style.display = 'block';
    let startDate = document.getElementById('startDate')?.value;
    let endDate = document.getElementById('endDate')?.value;
    let params = [];
    if (startDate) params.push('startDate=' + startDate);
    if (endDate) params.push('endDate=' + endDate);
    let url = '/admin/dashboard/api';
    if (params.length) url += '?' + params.join('&');
    try {
        const response = await fetch(url);
        const data = await response.json();
        updateKPIs(data);
        updateCharts(data);
    } catch (error) {
        console.error('Error al obtener los datos:', error);
    } finally {
        document.getElementById('loading').style.display = 'none';
    }
}

document.getElementById('filterButton').addEventListener('click', fetchData);
document.getElementById('timeRange').addEventListener('change', function() {
    const customRange = document.getElementById('customDateRange');
    customRange.style.display = this.value === 'custom' ? 'block' : 'none';
    if (this.value !== 'custom') {
        const today = new Date();
        let startDate, endDate = formatDate(today);
        switch(this.value) {
            case 'today':
                startDate = endDate;
                break;
            case 'yesterday':
                const yesterday = new Date(today);
                yesterday.setDate(yesterday.getDate() - 1);
                startDate = endDate = formatDate(yesterday);
                break;
            case 'week':
                const firstDay = new Date(today);
                firstDay.setDate(firstDay.getDate() - firstDay.getDay());
                startDate = formatDate(firstDay);
                break;
            case 'month':
                startDate = formatDate(new Date(today.getFullYear(), today.getMonth(), 1));
                break;
        }
        document.getElementById('startDate').value = startDate;
        document.getElementById('endDate').value = endDate;
    }
});
function formatDate(date) {
    return date.toISOString().split('T')[0];
}
fetchData();
document.getElementById('exportButton').addEventListener('click', function() {
    fetch('/admin/dashboard/api').then(r => r.json()).then(data => {
        const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(data));
        const downloadAnchorNode = document.createElement('a');
        downloadAnchorNode.setAttribute("href", dataStr);
        downloadAnchorNode.setAttribute("download", "datos_dashboard.json");
        document.body.appendChild(downloadAnchorNode);
        downloadAnchorNode.click();
        downloadAnchorNode.remove();
    });
});
// Tema oscuro
window.toggleTheme = toggleTheme; 