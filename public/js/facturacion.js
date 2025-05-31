// Variables y funciones globales
window.currentTicket = {
    items: [],
    subtotal: 0,
    tax: 0,
    total: 0,
    customer: 'Consumidor Final',
    nit: 'C/F'
};

window.formatMoney = function(amount) {
    return Number(amount).toFixed(2);
};

window.formatDate = function(date) {
    if (typeof date === 'string') {
        date = new Date(date);
    }
    return date instanceof Date && !isNaN(date) ? 
        date.toLocaleDateString('es-GT', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        }) : 'Fecha inválida';
};

window.updateTicketDisplay = function() {
    const ticketContainer = document.getElementById('ticket');
    const subtotalElement = document.getElementById('subtotal');
    const taxElement = document.getElementById('tax');
    const totalElement = document.getElementById('total');

    if (!window.currentTicket) return;

    const ticketHTML = `
        <div class="ticket-header text-center mb-2">
            <h3>Click&Serve Restaurant</h3>
            <p>Dirección del Restaurante</p>
            <p>Tel: (502) XXXX-XXXX</p>
            ${window.currentTicket.numero_factura ? `<p>Factura No: <strong>${window.currentTicket.numero_factura}</strong></p>` : ''}
            <p>Fecha: ${window.formatDate(new Date())}</p>
            <p>Cliente: <strong>${window.currentTicket.customer}</strong></p>
            <p>NIT/DPI: <strong>${window.currentTicket.nit}</strong></p>
        </div>
        <table class="table table-sm mb-2">
            <thead>
                <tr>
                    <th>Cant</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                ${window.currentTicket.items.map(item => `
                    <tr>
                        <td>${item.cantidad}</td>
                        <td>${item.descripcion}</td>
                        <td>Q${window.formatMoney(item.precio)}</td>
                        <td>Q${window.formatMoney(item.total)}</td>
                    </tr>
                `).join('')}
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end">Subtotal:</td>
                    <td class="text-end">Q${window.formatMoney(window.currentTicket.subtotal)}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end">IVA (12%):</td>
                    <td class="text-end">Q${window.formatMoney(window.currentTicket.tax)}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" class="text-end">Total:</td>
                    <td class="text-end">Q${window.formatMoney(window.currentTicket.total)}</td>
                </tr>
            </tfoot>
        </table>
        <div class="ticket-footer text-center mt-2">
            <p>¡Gracias por su preferencia!</p>
            ${window.currentTicket.estado === 'anulada' ? '<div class="anulada">FACTURA ANULADA</div>' : ''}
        </div>
    `;

    if (ticketContainer) ticketContainer.innerHTML = ticketHTML;
    if (subtotalElement) subtotalElement.textContent = `Q${window.formatMoney(window.currentTicket.subtotal)}`;
    if (taxElement) taxElement.textContent = `Q${window.formatMoney(window.currentTicket.tax)}`;
    if (totalElement) totalElement.textContent = `Q${window.formatMoney(window.currentTicket.total)}`;
};

window.updateCustomerInfo = function() {
    const customerName = document.getElementById('customer-name');
    const customerNIT = document.getElementById('customer-nit');
    if (window.currentTicket) {
        window.currentTicket.customer = customerName.value.trim() || 'Consumidor Final';
        window.currentTicket.nit = customerNIT.value.trim() || 'C/F';
        window.updateTicketDisplay();
    }
};

// Cargar productos y llenar el select
window.productosDisponibles = [];
window.cargarProductos = async function() {
    try {
        const response = await fetch('/productos');
        const data = await response.json();
        window.productosDisponibles = data;
        const select = document.getElementById('product-select');
        if (select) {
            select.innerHTML = '<option value="">Seleccione un producto</option>';
            data.forEach(producto => {
                select.innerHTML += `<option value="${producto.id}" data-precio="${producto.precio}">${producto.nombre}</option>`;
            });
        }
    } catch (error) {
        console.error('Error al cargar productos:', error);
    }
};

// Al seleccionar un producto, autollenar el precio
window.handleProductoSelect = function() {
    const select = document.getElementById('product-select');
    const precioInput = document.getElementById('product-price');
    if (select && precioInput) {
        const selectedOption = select.options[select.selectedIndex];
        const precio = selectedOption.getAttribute('data-precio');
        precioInput.value = precio ? parseFloat(precio).toFixed(2) : '';
    }
};

// Modificar agregar producto para usar el select
window.addProductToTicket = function() {
    const select = document.getElementById('product-select');
    const productPrice = document.getElementById('product-price');
    const productQuantity = document.getElementById('product-quantity');
    const productId = select.value;
    const name = select.options[select.selectedIndex].text;
    const price = parseFloat(productPrice.value);
    const quantity = parseInt(productQuantity.value);
    if (!productId || isNaN(price) || isNaN(quantity) || price <= 0 || quantity <= 0) {
        alert('Por favor seleccione un producto y complete todos los campos correctamente');
        return;
    }
    const item = {
        descripcion: name,
        precio: price,
        cantidad: quantity,
        total: price * quantity
    };
    window.currentTicket.items.push(item);
    window.currentTicket.subtotal = window.currentTicket.items.reduce((sum, item) => sum + item.total, 0);
    window.currentTicket.tax = window.currentTicket.subtotal * 0.12;
    window.currentTicket.total = window.currentTicket.subtotal + window.currentTicket.tax;
    window.updateTicketDisplay();
    select.value = '';
    productPrice.value = '';
    productQuantity.value = '1';
    select.focus();
};

window.viewInvoice = async function(id) {
    try {
        const response = await fetch(`/facturas/${id}`);
        const data = await response.json();
        if (data) {
            const factura = data.invoice || data;
            window.currentTicket = {
                id: factura.id,
                numero_factura: factura.numero_factura,
                items: Array.isArray(factura.items) ? factura.items : JSON.parse(factura.items),
                customer: factura.cliente,
                nit: factura.nit,
                subtotal: parseFloat(factura.subtotal),
                tax: parseFloat(factura.impuesto),
                total: parseFloat(factura.total),
                estado: factura.estado,
                datos_restaurante: factura.datos_restaurante ? (typeof factura.datos_restaurante === 'object' ? factura.datos_restaurante : JSON.parse(factura.datos_restaurante)) : {}
            };
            window.updateTicketDisplay();
            const cancelButton = document.getElementById('cancel-ticket');
            if (cancelButton) {
                cancelButton.style.display = window.currentTicket.estado === 'activa' ? 'inline-block' : 'none';
            }
        } else {
            throw new Error('Error al cargar la factura');
        }
    } catch (error) {
        console.error('Error al cargar la factura:', error);
        alert(error.message || 'Error al cargar la factura');
    }
};

window.printInvoice = function(id) {
    window.open(`/facturas/${id}/imprimir`, '_blank');
};

window.cancelInvoice = async function(id) {
    if (!confirm('¿Está seguro de que desea anular esta factura?')) {
        return;
    }
    try {
        const response = await fetch(`/facturas/${id}/anular`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        const data = await response.json();
        if (data.success || data.estado === 'anulada') {
            alert('Factura anulada correctamente');
            if (window.loadInvoices) window.loadInvoices();
            if (window.currentTicket && window.currentTicket.id === id) {
                window.currentTicket.estado = 'anulada';
                if (window.updateTicketDisplay) window.updateTicketDisplay();
                document.getElementById('cancel-ticket').style.display = 'none';
            }
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        console.error('Error al anular factura:', error);
        alert('Error al anular la factura');
    }
};

window.loadInvoices = async function(searchTerm = '') {
    try {
        const url = searchTerm ? `/facturas?search=${encodeURIComponent(searchTerm)}` : '/facturas';
        const response = await fetch(url);
        const data = await response.json();
        let facturas = data.invoices || data;
        if (!Array.isArray(facturas)) facturas = [];
        const invoicesList = document.getElementById('invoices-list');
        if (invoicesList) {
            invoicesList.innerHTML = facturas.map(invoice => `
                <tr>
                    <td>${invoice.numero_factura}</td>
                    <td>${window.formatDate(invoice.fecha)}</td>
                    <td>${invoice.cliente || 'Consumidor Final'}</td>
                    <td class="text-right">Q${window.formatMoney(invoice.total)}</td>
                    <td>
                        <span class="status-${invoice.estado}">
                            ${invoice.estado.charAt(0).toUpperCase() + invoice.estado.slice(1)}
                        </span>
                    </td>
                    <td>
                        <button onclick="window.viewInvoice(${invoice.id})" class="btn-view">Ver</button>
                        <button onclick="window.printInvoice(${invoice.id})" class="btn-print">Imprimir</button>
                        ${invoice.estado === 'activa' ? 
                            `<button onclick="window.cancelInvoice(${invoice.id})" class="btn-cancel">Anular</button>` : 
                            ''}
                    </td>
                </tr>
            `).join('');
        }
    } catch (error) {
        console.error('Error al cargar facturas:', error);
        alert('Error al cargar las facturas');
    }
};

window.handlePrintTicket = function() {
    if (!window.currentTicket.items.length) {
        alert('No hay productos en el ticket para imprimir');
        return;
    }
    // Imprime la vista previa actual
    window.print();
};

window.handleSaveTicket = async function() {
    if (!validateTicket()) {
        return;
    }
    try {
        const response = await fetch('/facturas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                cliente: window.currentTicket.customer,
                nit: window.currentTicket.nit,
                subtotal: window.currentTicket.subtotal,
                impuesto: window.currentTicket.tax,
                total: window.currentTicket.total,
                items: window.currentTicket.items,
                datos_restaurante: {
                    nombre: 'Click&Serve Restaurant',
                    direccion: 'Dirección del Restaurante',
                    telefono: '(502) XXXX-XXXX',
                    mensaje: '¡Gracias por su preferencia!'
                }
            })
        });
        const data = await response.json();
        if (data.success) {
            alert('Factura guardada correctamente');
            window.currentTicket.numero_factura = data.numero_factura;
            window.currentTicket.id = data.invoice_id;
            window.updateTicketDisplay();
            window.loadInvoices();
            document.getElementById('cancel-ticket').style.display = 'inline-block';
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        console.error('Error al guardar factura:', error);
        alert('Error al guardar la factura');
    }
};

window.handleNewTicket = function() {
    window.currentTicket = {
        items: [],
        subtotal: 0,
        tax: 0,
        total: 0,
        customer: 'Consumidor Final',
        nit: 'C/F'
    };
    const customerName = document.getElementById('customer-name');
    const customerNIT = document.getElementById('customer-nit');
    if (customerName) customerName.value = '';
    if (customerNIT) customerNIT.value = '';
    window.updateTicketDisplay();
    document.getElementById('cancel-ticket').style.display = 'none';
};

window.handleCancelTicket = async function() {
    if (!window.currentTicket || !window.currentTicket.id) {
        alert('No hay factura para anular');
        return;
    }
    if (!confirm('¿Está seguro de que desea anular esta factura?')) {
        return;
    }
    try {
        const response = await fetch(`/facturas/${window.currentTicket.id}/anular`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        const data = await response.json();
        if (data.success || data.estado === 'anulada') {
            alert('Factura anulada correctamente');
            window.loadInvoices();
            window.handleNewTicket();
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        console.error('Error al anular la factura:', error);
        alert('Error al anular la factura');
    }
};

window.validateTicket = function() {
    if (!window.currentTicket.items.length) {
        alert('Debe agregar al menos un producto al ticket');
        return false;
    }
    return true;
};

document.addEventListener('DOMContentLoaded', function() {
    const addProductBtn = document.getElementById('add-product');
    const customerName = document.getElementById('customer-name');
    const customerNIT = document.getElementById('customer-nit');
    const printTicketBtn = document.getElementById('print-ticket');
    const saveTicketBtn = document.getElementById('save-ticket');
    const newTicketBtn = document.getElementById('new-ticket');
    const cancelTicketBtn = document.getElementById('cancel-ticket');
    const searchInput = document.getElementById('search-invoice');
    const searchBtn = document.getElementById('search-btn');
    if (addProductBtn) addProductBtn.addEventListener('click', window.addProductToTicket);
    if (customerName) customerName.addEventListener('change', window.updateCustomerInfo);
    if (customerNIT) customerNIT.addEventListener('change', window.updateCustomerInfo);
    if (printTicketBtn) printTicketBtn.addEventListener('click', window.handlePrintTicket);
    if (saveTicketBtn) saveTicketBtn.addEventListener('click', window.handleSaveTicket);
    if (newTicketBtn) newTicketBtn.addEventListener('click', window.handleNewTicket);
    if (cancelTicketBtn) cancelTicketBtn.addEventListener('click', window.handleCancelTicket);
    if (searchBtn) searchBtn.addEventListener('click', function() {
        window.loadInvoices(searchInput.value);
    });
    if (searchInput) searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') window.loadInvoices(searchInput.value);
    });
    window.updateTicketDisplay();
    window.loadInvoices();
    window.cargarProductos();
    const select = document.getElementById('product-select');
    if (select) select.addEventListener('change', window.handleProductoSelect);
}); 