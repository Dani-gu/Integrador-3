@extends('layouts.app')

@section('title', 'Nueva Factura')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fa fa-plus mr-2"></i>Nueva Factura</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('facturas.store') }}" id="facturaForm">
                        @csrf
                        @if($pedido)
                            <input type="hidden" name="id_pedido" value="{{ $pedido->id }}">
                            <input type="hidden" name="id_cliente" value="{{ $pedido->cliente->id }}">
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="razon_social_facturacion">Razón Social *</label>
                                    <input type="text" class="form-control @error('razon_social_facturacion') is-invalid @enderror" 
                                           id="razon_social_facturacion" name="razon_social_facturacion" 
                                           value="{{ old('razon_social_facturacion', $pedido ? $pedido->cliente->nombre_razon_social : '') }}" required>
                                    @error('razon_social_facturacion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nit_facturacion">NIT/CI *</label>
                                    <input type="text" class="form-control @error('nit_facturacion') is-invalid @enderror" 
                                           id="nit_facturacion" name="nit_facturacion" 
                                           value="{{ old('nit_facturacion', $pedido ? $pedido->cliente->nit_ci : '') }}" required>
                                    @error('nit_facturacion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if($pedido)
                            <div class="alert alert-info">
                                <strong>Facturando Pedido #{{ $pedido->id }}</strong><br>
                                Cliente: {{ $pedido->cliente->nombre_razon_social }}<br>
                                Total: ${{ number_format($pedido->total_pedido, 2) }}
                            </div>
                        @endif

                        <hr>
                        <h5>Items de la Factura</h5>
                        
                        <div id="items-container">
                            @if($pedido)
                                @foreach($pedido->detalles as $index => $detalle)
                                <div class="item-factura border p-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label>Descripción</label>
                                            <input type="text" name="items[{{ $index }}][descripcion]" class="form-control" 
                                                   value="{{ $detalle->producto->nombre }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Cantidad</label>
                                            <input type="number" name="items[{{ $index }}][cantidad]" class="form-control cantidad-input" 
                                                   value="{{ $detalle->cantidad }}" min="1" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Precio Unit.</label>
                                            <input type="number" step="0.01" name="items[{{ $index }}][precio_unitario]" class="form-control precio-input" 
                                                   value="{{ $detalle->precio_unitario }}" min="0" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Subtotal</label>
                                            <input type="text" class="form-control subtotal-display" readonly>
                                        </div>
                                        <div class="col-md-1">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-block remove-item">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="item-factura border p-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label>Descripción</label>
                                            <input type="text" name="items[0][descripcion]" class="form-control" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Cantidad</label>
                                            <input type="number" name="items[0][cantidad]" class="form-control cantidad-input" min="1" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Precio Unit.</label>
                                            <input type="number" step="0.01" name="items[0][precio_unitario]" class="form-control precio-input" min="0" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Subtotal</label>
                                            <input type="text" class="form-control subtotal-display" readonly>
                                        </div>
                                        <div class="col-md-1">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-block remove-item">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <button type="button" id="add-item" class="btn btn-secondary mb-3">
                            <i class="fa fa-plus mr-1"></i>Agregar Item
                        </button>

                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5>Total: $<span id="total-factura">0.00</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right mt-3">
                            <a href="{{ route('facturas.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-1"></i>Crear Factura
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let itemIndex = {{ $pedido ? $pedido->detalles->count() : 1 }};

document.getElementById('add-item').addEventListener('click', function() {
    const container = document.getElementById('items-container');
    const newItem = container.children[0].cloneNode(true);
    
    newItem.querySelectorAll('input').forEach(input => {
        if (input.name) {
            input.name = input.name.replace(/\[\d+\]/, '[' + itemIndex + ']');
        }
        if (input.type !== 'button') {
            input.value = '';
        }
    });
    
    container.appendChild(newItem);
    itemIndex++;
    updateEventListeners();
});

function updateEventListeners() {
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.onclick = function() {
            if (document.querySelectorAll('.item-factura').length > 1) {
                this.closest('.item-factura').remove();
                calculateTotal();
            }
        };
    });

    document.querySelectorAll('.cantidad-input, .precio-input').forEach(input => {
        input.onchange = calculateSubtotal;
        input.oninput = calculateSubtotal;
    });
}

function calculateSubtotal() {
    const item = this.closest('.item-factura');
    const cantidad = item.querySelector('.cantidad-input');
    const precio = item.querySelector('.precio-input');
    const subtotal = item.querySelector('.subtotal-display');
    
    if (cantidad.value && precio.value) {
        const sub = parseFloat(precio.value) * parseInt(cantidad.value);
        subtotal.value = '$' + sub.toFixed(2);
    } else {
        subtotal.value = '';
    }
    
    calculateTotal();
}

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal-display').forEach(input => {
        if (input.value) {
            total += parseFloat(input.value.replace('$', ''));
        }
    });
    document.getElementById('total-factura').textContent = total.toFixed(2);
}

updateEventListeners();
calculateTotal();
</script>
@endsection