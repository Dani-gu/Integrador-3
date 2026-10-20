import pandas as pd
import joblib

from sklearn.model_selection import train_test_split
from sklearn.preprocessing import OneHotEncoder
from sklearn.compose import ColumnTransformer
from sklearn.pipeline import Pipeline
from sklearn.ensemble import RandomForestRegressor
from sklearn.metrics import mean_absolute_error, mean_squared_error, r2_score


# ==========================================
# 1. CARGAR DATASET
# ==========================================

df = pd.read_csv("ml/datos_ventas.csv")

print("Dataset cargado correctamente")
print("Registros:", len(df))


# ==========================================
# 2. CREAR VARIABLE MES
# ==========================================

df["fecha_pedido"] = pd.to_datetime(df["fecha_pedido"])

df["mes"] = df["fecha_pedido"].dt.month


# ==========================================
# 3. DEFINIR ENTRADAS Y SALIDA
# ==========================================

X = df[
    [
        "producto",
        "mes",
        "precio_unitario",
        "cliente",
        "vendedor"
    ]
]

y = df["cantidad"]


print("\nVariables de entrada:")
print(X.head())

print("\nVariable de salida:")
print(y.head())


# ==========================================
# 4. DIVIDIR DATOS
# ==========================================

X_train, X_test, y_train, y_test = train_test_split(
    X,
    y,
    test_size=0.20,
    random_state=42
)

print("\nDatos para entrenamiento:", len(X_train))
print("Datos para prueba:", len(X_test))


# ==========================================
# 5. DEFINIR COLUMNAS
# ==========================================

columnas_categoricas = [
    "producto",
    "cliente",
    "vendedor"
]

columnas_numericas = [
    "mes",
    "precio_unitario"
]


# ==========================================
# 6. TRANSFORMAR DATOS
# ==========================================

preprocesamiento = ColumnTransformer(
    transformers=[
        (
            "categoricas",
            OneHotEncoder(handle_unknown="ignore"),
            columnas_categoricas
        ),
        (
            "numericas",
            "passthrough",
            columnas_numericas
        )
    ]
)


# ==========================================
# 7. CREAR MODELO
# ==========================================

modelo = RandomForestRegressor(
    n_estimators=100,
    random_state=42
)


# ==========================================
# 8. CREAR PIPELINE
# ==========================================

pipeline = Pipeline(
    steps=[
        ("preprocesamiento", preprocesamiento),
        ("modelo", modelo)
    ]
)


# ==========================================
# 9. ENTRENAR
# ==========================================

print("\nEntrenando modelo...")

pipeline.fit(X_train, y_train)

print("Modelo entrenado correctamente")


# ==========================================
# 10. REALIZAR PREDICCIONES
# ==========================================

y_pred = pipeline.predict(X_test)


# ==========================================
# 11. EVALUAR MODELO
# ==========================================

mae = mean_absolute_error(y_test, y_pred)
mse = mean_squared_error(y_test, y_pred)
r2 = r2_score(y_test, y_pred)


print("\n==========================================")
print("EVALUACIÓN DEL MODELO")
print("==========================================")

print(f"MAE: {mae:.2f}")
print(f"MSE: {mse:.2f}")
print(f"R²:  {r2:.2f}")


# ==========================================
# 12. MOSTRAR PREDICCIONES
# ==========================================

resultados = X_test.copy()

resultados["cantidad_real"] = y_test.values
resultados["cantidad_predicha"] = y_pred.round(0)

print("\n==========================================")
print("PREDICCIONES")
print("==========================================")

print(resultados.head(10))


# ==========================================
# 13. GUARDAR MODELO
# ==========================================

joblib.dump(
    pipeline,
    "ml/modelo_ventas.pkl"
)

print("\n==========================================")
print("MODELO GUARDADO")
print("==========================================")
print("Archivo: ml/modelo_ventas.pkl")