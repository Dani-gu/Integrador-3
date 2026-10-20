<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Predicción de Ventas - Matriplast</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .contenedor {
            max-width: 900px;
            margin: auto;
        }

        .encabezado {
            background: #1f2937;
            color: white;
            padding: 30px;
            border-radius: 12px 12px 0 0;
        }

        .encabezado h1 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .encabezado p {
            color: #d1d5db;
        }

        .contenido {
            background: white;
            padding: 30px;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .formulario {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .campo {
            display: flex;
            flex-direction: column;
        }

        .campo-completo {
            grid-column: 1 / -1;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            color: #374151;
        }

        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            background: white;
        }

        select:focus {
            outline: none;
            border-color: #2563eb;
        }

        .precio {
            margin-top: 8px;
            color: #2563eb;
            font-weight: bold;
        }

        .boton {
            grid-column: 1 / -1;
            margin-top: 10px;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .boton:hover {
            background: #1d4ed8;
        }

        .resultado {
            margin-top: 30px;
            padding: 25px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 10px;
            text-align: center;
        }

        .resultado h2 {
            color: #065f46;
            margin-bottom: 15px;
        }

        .cantidad {
            font-size: 42px;
            font-weight: bold;
            color: #059669;
            margin: 15px 0;
        }

        .detalle {
            color: #374151;
            margin-top: 8px;
        }

        .error {
            margin-bottom: 20px;
            padding: 15px;
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            border-radius: 8px;
        }

        @media (max-width: 700px) {
            .formulario {
                grid-template-columns: 1fr;
            }

            .campo-completo,
            .boton {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>

<div class="contenedor">

    <div class="encabezado">
        <h1>Predicción de Ventas</h1>
        <p>Modelo de Machine Learning - Matriplast S.A.</p>
    </div>

    <div class="contenido">

        @if(session('error'))
            <div class="error">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('prediccion.venta') }}" method="POST">

            @csrf

            <div class="formulario">

                <!-- PRODUCTO -->
                <div class="campo campo-completo">
                    <label for="producto">
                        Producto
                    </label>

                    <select
                        name="producto"
                        id="producto"
                        required
                        onchange="mostrarPrecio()"
                    >
                        <option value="">
                            Seleccione un producto
                        </option>

                        @foreach($productos as $producto)
                            <option
                                value="{{ $producto->id }}"
                                data-precio="{{ $producto->precio_unitario }}"
                                {{ old('producto') == $producto->id ? 'selected' : '' }}
                            >
                                {{ $producto->nombre }}
                            </option>
                        @endforeach

                    </select>

                    <div class="precio" id="precio">
                        Precio unitario: Bs. 0.00
                    </div>
                </div>


                <!-- MES -->
                <div class="campo">

                    <label for="mes">
                        Mes de predicción
                    </label>

                    <select
                        name="mes"
                        id="mes"
                        required
                    >

                        <option value="">
                            Seleccione un mes
                        </option>

                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>

                    </select>

                </div>


                <!-- CLIENTE -->
                <div class="campo">

                    <label for="cliente">
                        Cliente
                    </label>

                    <select
                        name="cliente"
                        id="cliente"
                        required
                    >

                        <option value="">
                            Seleccione un cliente
                        </option>

                        @foreach($clientes as $cliente)

                            <option
                                value="{{ $cliente->id }}"
                            >
                                {{ $cliente->nombre_razon_social }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- VENDEDOR -->
                <div class="campo campo-completo">

                    <label for="vendedor">
                        Vendedor
                    </label>

                    <select
                        name="vendedor"
                        id="vendedor"
                        required
                    >

                        <option value="">
                            Seleccione un vendedor
                        </option>

                        @foreach($vendedores as $vendedor)

                            <option
                                value="{{ $vendedor->id }}"
                            >
                                {{ $vendedor->nombre_completo }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- BOTÓN -->
                <button
                    type="submit"
                    class="boton"
                >
                    Predecir ventas
                </button>

            </div>

        </form>


        <!-- RESULTADO -->

        @if(isset($resultado))

            <div class="resultado">

                <h2>
                    Resultado de la predicción
                </h2>

                <div class="cantidad">
                    {{ $resultado['cantidad_estimada'] }}
                </div>

                <p class="detalle">
                    Unidades estimadas de venta
                </p>

                <p class="detalle">
                    <strong>Producto:</strong>
                    {{ $resultado['producto'] }}
                </p>

                <p class="detalle">
                    <strong>Mes:</strong>
                    {{ $resultado['mes'] }}
                </p>

                <p class="detalle">
                    <strong>Precio unitario:</strong>
                    Bs. {{ number_format($resultado['precio_unitario'], 2) }}
                </p>

                <p class="detalle">
                    <strong>Cliente:</strong>
                    {{ $resultado['cliente'] }}
                </p>

                <p class="detalle">
                    <strong>Vendedor:</strong>
                    {{ $resultado['vendedor'] }}
                </p>

            </div>

        @endif

    </div>

</div>


<script>

    function mostrarPrecio() {

        const producto = document.getElementById('producto');

        const opcion = producto.options[producto.selectedIndex];

        const precio = opcion.getAttribute('data-precio');

        const elementoPrecio = document.getElementById('precio');

        if (precio) {

            elementoPrecio.textContent =
                'Precio unitario: Bs. ' +
                parseFloat(precio).toFixed(2);

        } else {

            elementoPrecio.textContent =
                'Precio unitario: Bs. 0.00';

        }
    }

</script>

</body>

</html>