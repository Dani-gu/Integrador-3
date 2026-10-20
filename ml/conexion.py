import pymysql

conexion = pymysql.connect(
    host="127.0.0.1",
    user="root",
    password="",
    database="matriplast_db",
    port=3306
)

print("CONEXIÓN EXITOSA")
print("Base de datos: matriplast_db")

conexion.close()