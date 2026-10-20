from fastapi import FastAPI
from pydantic import BaseModel
import joblib
import pandas as pd


# ==========================================
# CREAR API
# ==========================================

app = FastAPI(
    title="API Predicción de Ventas - Matriplast",
    version="1.0"
)


# ==========================================
# CARGAR MODELO
# ==========================================

modelo = joblib.load("ml/modelo_ventas.pkl")


# ==========================================
# DATOS QUE RECIBIRÁ LA API
# ==========================================

class DatosVenta(BaseModel):

    producto: str
    mes: int
    precio_unitario: float
    cliente: str
    vendedor: str


# ==========================================
# RUTA PRINCIPAL
# ==========================================

@app.get("/")
def inicio():

    return {
        "mensaje": "API de predicción de ventas de Matriplast",
        "estado": "funcionando"
    }


# ==========================================
# RUTA DE PREDICCIÓN
# ==========================================

@app.post("/predecir")
def predecir(datos: DatosVenta):

    entrada = pd.DataFrame([
        {
            "producto": datos.producto,
            "mes": datos.mes,
            "precio_unitario": datos.precio_unitario,
            "cliente": datos.cliente,
            "vendedor": datos.vendedor
        }
    ])

    prediccion = modelo.predict(entrada)

    cantidad = max(0, round(float(prediccion[0])))

    return {
        "producto": datos.producto,
        "mes": datos.mes,
        "precio_unitario": datos.precio_unitario,
        "cliente": datos.cliente,
        "vendedor": datos.vendedor,
        "cantidad_estimada": cantidad
    }