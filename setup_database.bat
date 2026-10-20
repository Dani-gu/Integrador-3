@echo off
echo ========================================
echo CONFIGURACION DE BASE DE DATOS MATRIPLAST
echo ========================================

echo.
echo 1. Ejecutando migraciones...
php artisan migrate:fresh --force

echo.
echo 2. Ejecutando seeders...
php artisan db:seed --force

echo.
echo 3. Limpiando cache...
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo.
echo ========================================
echo BASE DE DATOS CONFIGURADA EXITOSAMENTE
echo ========================================
echo.
echo Credenciales de acceso:
echo - Admin: admin@matriplast.com / password
echo - Operario: operario@matriplast.com / password
echo - Supervisor: supervisor@matriplast.com / password
echo.
pause