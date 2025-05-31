@extends('layouts.app')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<style>
/* Mejorar visualización del ticket */
.ticket-visual {
    border: 2px solid var(--primary-color);
    box-shadow: 0 8px 32px rgba(33,150,243,0.13);
    font-family: 'Courier New', monospace;
    font-size: 15px;
    background: #fff;
    margin: 0 auto;
}
.ticket-visual .ticket-header h3 {
    color: var(--primary-color);
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}
.ticket-visual .ticket-header p {
    margin: 2px 0;
    color: #333;
    font-size: 1rem;
}
.ticket-visual table {
    width: 100%;
    border-collapse: collapse;
    margin: 10px 0;
}
.ticket-visual th, .ticket-visual td {
    padding: 6px 4px;
    font-size: 1rem;
}
.ticket-visual th {
    border-bottom: 2px solid var(--primary-color);
    color: var(--primary-color);
    font-weight: bold;
}
.ticket-visual td:last-child, .ticket-visual th:last-child {
    text-align: right;
}
.ticket-visual tfoot td {
    font-weight: bold;
    background: #f0f7ff;
}
.ticket-visual .total-row {
    border-top: 2px solid var(--primary-color);
    font-size: 1.1rem;
    background: #e3f2fd;
}
.ticket-visual .ticket-footer {
    text-align: center;
    margin-top: 18px;
    font-size: 1.1rem;
    color: #4CAF50;
}
.ticket-visual .anulada {
    color: #f44336;
    border: 2px solid #f44336;
    padding: 5px;
    margin-top: 10px;
    font-weight: bold;
    background: #fff0f0;
}

/* Solo mostrar el ticket al imprimir */
@media print {
    body * {
        visibility: hidden !important;
    }
    .ticket-visual, .ticket-visual * {
        visibility: visible !important;
    }
    .ticket-visual {
        position: absolute !important;
        left: 0; right: 0; top: 0;
        margin: auto !important;
        box-shadow: none !important;
        border: none !important;
        background: #fff !important;
        width: 100% !important;
        max-width: 400px !important;
    }
}
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <!-- Panel de productos y cliente -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h2 class="card-title mb-3 text-primary"><i class="bi bi-basket"></i> Agregar Productos</h2>
                    <div class="row g-2">
                        <div class="col-12">
                            <label class="form-label">Producto</label>
                            <select id="product-select" class="form-select">
                                <option value="">Seleccione un producto</option>
                                <!-- Opciones dinámicas -->
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Precio</label>
                            <input type="number" id="product-price" class="form-control" min="0" step="0.01" placeholder="0.00" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Cantidad</label>
                            <input type="number" id="product-quantity" class="form-control" min="1" value="1">
                        </div>
                        <div class="col-12 d-grid">
                            <button id="add-product" class="btn btn-primary mt-2"><i class="bi bi-plus-circle"></i> Agregar al Ticket</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h3 class="card-title mb-3 text-secondary"><i class="bi bi-person"></i> Información del Cliente</h3>
                    <div class="mb-2">
                        <label class="form-label">Nombre del Cliente</label>
                        <input type="text" id="customer-name" class="form-control" placeholder="Consumidor Final">
                    </div>
                    <div>
                        <label class="form-label">NIT/DPI</label>
                        <input type="text" id="customer-nit" class="form-control" placeholder="C/F">
                    </div>
                </div>
            </div>
        </div>
        <!-- Ticket y acciones -->
        <div class="col-lg-7">
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-body">
                    <h2 class="card-title mb-3 text-primary"><i class="bi bi-receipt"></i> Vista Previa del Ticket</h2>
                    <div class="ticket-container mb-3 d-flex justify-content-center">
                        <div id="ticket" class="ticket-visual shadow-lg bg-white rounded-4 p-4 w-100" style="max-width: 400px;"></div>
                    </div>
                    <div class="ticket-summary mb-3">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span id="subtotal">Q0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>IVA (12%):</span>
                            <span id="tax">Q0.00</span>
                        </div>
                        <div class="summary-row total bg-light rounded px-2 py-1">
                            <span>Total:</span>
                            <span id="total">Q0.00</span>
                        </div>
                    </div>
                    <div class="actions d-flex flex-wrap gap-2">
                        <button id="print-ticket" class="btn btn-success"><i class="bi bi-printer"></i> Imprimir</button>
                        <button id="save-ticket" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                        <button id="new-ticket" class="btn btn-warning"><i class="bi bi-plus-square"></i> Nuevo</button>
                        <button id="cancel-ticket" class="btn btn-danger" style="display: none;"><i class="bi bi-x-circle"></i> Anular</button>
                    </div>
                </div>
            </div>
            <!-- Facturas emitidas -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h2 class="card-title mb-3 text-primary"><i class="bi bi-journal-text"></i> Facturas Emitidas</h2>
                    <div class="input-group mb-3">
                        <input type="text" id="search-invoice" class="form-control" placeholder="Número de factura o cliente">
                        <button id="search-btn" class="btn btn-outline-primary"><i class="bi bi-search"></i> Buscar</button>
                    </div>
                    <div class="table-responsive">
                        <table class="invoices-table table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="invoices-list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/facturacion.js') }}"></script>
@endpush 