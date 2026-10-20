@extends('layouts.app')

@section('title', 'Nuevo Pedido')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fa fa-plus mr-2"></i>Nuevo Pedido</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('pedidos.store') }}" id="pedidoForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_cliente">Cliente *</label>
                                    <select class="form-control @error('id_cliente') is-invalid @enderror" id="id_cliente" name="id_cliente" required>
                                        <option value="">Seleccionar cliente</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ old('id_cliente') == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->nombre_razon_social }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_cliente')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha del Pedido</label>
                                    <input type="text" class="form-control" value="{{ now()->format('d/m/Y') }}" readonly>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5>Productos</h5>
                        
                        <div id="productos-container">
                            <div class="producto-item border p-3 mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Producto</label>
                                        <select name="productos[0][id]" class="form-control producto-select" required>
                                            <option value="">Seleccionar producto</option>
                                            @foreach($productos as $producto)
                                                <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_unitario }}" data-stock="{{ $producto->stock_actual }}">
                                                    {{ $producto->nombre }} (Stock: {{ $producto->stock_actual }}) - ${{ $producto->precio_unitario }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Cantidad</label>
                                        <input type="number" name="productos[0][cantidad]" class="form-control cantidad-input" min="1" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Subtotal</label>
                                        <input type="text" class="form-control subtotal" readonly>
                                    </div>
                                    <div class="col-md-1">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-block remove-producto">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-producto" class="btn btn-secondary mb-3">
                            <i class="fa fa-plus mr-1"></i>Agregar Producto
                        </button>

                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5>Total: $<span id="total-pedido">0.00</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right mt-3">
                            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-1"></i>Crear Pedido
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let productoIndex = 1;

document.getElementById('add-producto').addEventListener('click', function() {
    const container = document.getElementById('productos-container');
    const newItem = container.children[0].cloneNode(true);
    
    // Actualizar nombres de inputs
    newItem.querySelectorAll('select, input').forEach(input => {
        if (input.name) {
            input.name = input.name.replace('[0]', '[' + productoIndex + ']');
        }
        if (input.type !== 'button') {
            input.value = '';
        }
    });
    
    container.appendChild(newItem);
    productoIndex++;
    updateEventListeners();
});

function updateEventListeners() {
    document.querySelectorAll('.remove-producto').forEach(btn => {
        btn.onclick = function() {
            if (document.querySelectorAll('.producto-item').length > 1) {
                this.closest('.producto-item').remove();
                calculateTotal();
            }
        };
    });

    document.querySelectorAll('.producto-select, .cantidad-input').forEach(input => {
        input.onchange = calculateSubtotal;
        input.oninput = calculateSubtotal;
    });
}

function calculateSubtotal() {
    const item = this.closest('.producto-item');
    const select = item.querySelector('.producto-select');
    const cantidad = item.querySelector('.cantidad-input');
    const subtotal = item.querySelector('.subtotal');
    
    if (select.value && cantidad.value) {
        const precio = select.options[select.selectedIndex].dataset.precio;
        const sub = parseFloat(precio) * parseInt(cantidad.value);
        subtotal.value = '$' + sub.toFixed(2);
    } else {
        subtotal.value = '';
    }
    
    calculateTotal();
}

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(input => {
        if (input.value) {
            total += parseFloat(input.value.replace('$', ''));
        }
    });
    document.getElementById('total-pedido').textContent = total.toFixed(2);
}

updateEventListeners();
</script>
@endsection