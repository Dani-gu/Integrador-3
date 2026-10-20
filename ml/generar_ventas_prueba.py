import pymysql
import random
from datetime import datetime, timedelta

# ==========================================
# CONEXIÓN A MYSQL
# ==========================================

conexion = pymysql.connect(
    host="127.0.0.1",
    user="root",
    password="",
    database="matriplast_db",
    port=3306
)

cursor = conexion.cursor()

print("Conectado a matriplast_db")

# ==========================================
# OBTENER PRODUCTOS
# ==========================================

cursor.execute("""
    SELECT id, precio_unitario
    FROM productos_terminados
""")

productos = cursor.fetchall()

# ==========================================
# CONFIGURACIÓN
# ==========================================

clientes = [1, 2, 3]
vendedores = [1, 2, 3, 4, 5]

# Vamos a generar 100 ventas
cantidad_ventas = 100

# Fechas entre enero y septiembre de 2026
fecha_inicio = datetime(2026, 1, 1)

print(f"Generando {cantidad_ventas} ventas de prueba...")

# ==========================================
# GENERAR VENTAS
# ==========================================

for i in range(cantidad_ventas):

    # Fecha aleatoria
    dias = random.randint(0, 265)
    fecha = fecha_inicio + timedelta(days=dias)

    # Hora aleatoria
    fecha = fecha.replace(
        hour=random.randint(8, 17),
        minute=random.randint(0, 59),
        second=random.randint(0, 59)
    )

    # Cliente y vendedor
    id_cliente = random.choice(clientes)
    id_vendedor = random.choice(vendedores)

    # Crear pedido inicialmente
    cursor.execute("""
        INSERT INTO pedidos
        (
            id_cliente,
            id_vendedor,
            fecha_pedido,
            estado,
            total_pedido,
            created_at,
            updated_at
        )
        VALUES (%s, %s, %s, 'entregado', 0, NOW(), NOW())
    """, (
        id_cliente,
        id_vendedor,
        fecha
    ))

    id_pedido = cursor.lastrowid

    # Seleccionar producto
    id_producto, precio = random.choice(productos)

    # Cantidad según el tipo de producto
    if precio <= 1:
        cantidad = random.randint(200, 1000)
    elif precio <= 5:
        cantidad = random.randint(50, 500)
    elif precio <= 15:
        cantidad = random.randint(20, 200)
    else:
        cantidad = random.randint(5, 80)

    # Insertar detalle
    cursor.execute("""
        INSERT INTO detalles_pedido
        (
            id_pedido,
            id_producto_terminado,
            cantidad,
            precio_unitario,
            created_at,
            updated_at
        )
        VALUES (%s, %s, %s, %s, NOW(), NOW())
    """, (
        id_pedido,
        id_producto,
        cantidad,
        precio
    ))

    # Calcular total
    total = cantidad * float(precio)

    # Actualizar total del pedido
    cursor.execute("""
        UPDATE pedidos
        SET total_pedido = %s
        WHERE id = %s
    """, (
        total,
        id_pedido
    ))

# ==========================================
# GUARDAR CAMBIOS
# ==========================================

conexion.commit()

cursor.close()
conexion.close()

print("==========================================")
print("VENTAS GENERADAS CORRECTAMENTE")
print("==========================================")
print(f"Ventas nuevas: {cantidad_ventas}")
print("Estado: entregado")
print("Los datos fueron guardados en matriplast_db")