<?php
// Script para generar hashes de contraseñas
echo "Hashes para las contraseñas:\n\n";
echo "admin123: " . password_hash('admin123', PASSWORD_DEFAULT) . "\n\n";
echo "operario123: " . password_hash('operario123', PASSWORD_DEFAULT) . "\n\n";
echo "supervisor123: " . password_hash('supervisor123', PASSWORD_DEFAULT) . "\n\n";

// SQL con hashes generados
$adminHash = password_hash('admin123', PASSWORD_DEFAULT);
$operarioHash = password_hash('operario123', PASSWORD_DEFAULT);
$supervisorHash = password_hash('supervisor123', PASSWORD_DEFAULT);

echo "SQL para insertar en phpMyAdmin:\n\n";
echo "INSERT INTO usuarios (id_rol, nombre_completo, email, password_hash, creado_en) VALUES\n";
echo "(1, 'Administrador del Sistema', 'admin@matriplast.com', '$adminHash', NOW()),\n";
echo "(3, 'Juan Pérez - Operario', 'operario@matriplast.com', '$operarioHash', NOW()),\n";
echo "(2, 'María González - Supervisor', 'supervisor@matriplast.com', '$supervisorHash', NOW());\n";
?>