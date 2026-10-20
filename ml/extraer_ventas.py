import pymysql
import pandas as pd

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

print("Conectado a matriplast_db")

# ==========================================
# CONSULTA DE VENTAS
# ==========================================

consulta = """
SELECT
    p.id AS pedido,
    p.fecha_pedido,
    c.nombre_razon_social AS cliente,
    u.nombre_completo AS vendedor,
    pt.nombre AS producto,
    dp.cantidad,
    dp.precio_unitario,
    p.estado
FROM pedidos p
INNER JOIN detalles_pedido dp
    ON p.id = dp.id_pedido
INNER JOIN productos_terminados pt
    ON dp.id_producto_terminado = pt.id
INNER JOIN clientes c
    ON p.id_cliente = c.id
INNER JOIN usuarios u
    ON p.id_vendedor = u.id
WHERE p.estado = 'entregado'
ORDER BY p.fecha_pedido;
"""

# ==========================================
# LEER DATOS
# ==========================================

df = pd.read_sql(consulta, conexion)

conexion.close()

# ==========================================
# MOSTRAR DATOS
# ==========================================

print("\nVENTAS ENCONTRADAS:")
print(df)

print("\nCantidad de registros:", len(df))

# ==========================================
# GUARDAR DATASET
# ==========================================

df.to_csv(
    "ml/datos_ventas.csv",
    index=False,
    encoding="utf-8-sig"
)

print("\nDataset creado correctamente:")
print("ml/datos_ventas.csv")