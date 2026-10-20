import joblib
import pandas as pd


# ==========================================
# 1. CARGAR MODELO
# ==========================================

modelo = joblib.load("ml/modelo_ventas.pkl")

print("Modelo cargado correctamente")


# ==========================================
# 2. DATOS PARA LA PREDICCIÓN
# ==========================================

datos = pd.DataFrame([
    {
        "producto": "Botella PET 500ml",
        "mes": 10,
        "precio_unitario": 2.50,
        "cliente": "Juan Pérez",
        "vendedor": "Carlos Quispe"
    }
])


# ==========================================
# 3. REALIZAR PREDICCIÓN
# ==========================================

prediccion = modelo.predict(datos)


# ==========================================
# 4. MOSTRAR RESULTADO
# ==========================================

cantidad = round(prediccion[0])

print("\n==========================================")
print("PREDICCIÓN DE VENTAS")
print("==========================================")

print("Producto:", datos["producto"].iloc[0])
print("Mes:", datos["mes"].iloc[0])
print("Precio unitario:", datos["precio_unitario"].iloc[0])
print("Cliente:", datos["cliente"].iloc[0])
print("Vendedor:", datos["vendedor"].iloc[0])

print("------------------------------------------")

print("Cantidad estimada:", cantidad, "unidades")

print("==========================================")