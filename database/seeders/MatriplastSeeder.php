<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Rol;
use App\Models\Usuario;
use App\Models\Maquina;
use App\Models\LoteProduccion;
use App\Models\MateriaPrima;
use App\Models\ProductoTerminado;
use App\Models\Cliente;
use App\Models\BaseConocimientoFalla;

class MatriplastSeeder extends Seeder
{
    public function run()
    {
        // Insertar roles
        $roles = [
            'Administrador', 'Supervisor', 'Operario', 'Vendedor', 'Almacenista', 'Contador', 'Gerente'
        ];
        
        foreach ($roles as $rol) {
            Rol::create(['nombre_rol' => $rol]);
        }

        // Insertar usuarios de prueba
        Usuario::create([
            'id_rol' => 1,
            'nombre_completo' => 'Administrador del Sistema',
            'email' => 'admin@matriplast.com',
            'password_hash' => Hash::make('password'),
            'creado_en' => now(),
        ]);
        
        Usuario::create([
            'id_rol' => 3,
            'nombre_completo' => 'Juan Pérez - Operario',
            'email' => 'operario@matriplast.com',
            'password_hash' => Hash::make('password'),
            'creado_en' => now(),
        ]);
        
        Usuario::create([
            'id_rol' => 2,
            'nombre_completo' => 'María González - Supervisor',
            'email' => 'supervisor@matriplast.com',
            'password_hash' => Hash::make('password'),
            'creado_en' => now(),
        ]);

        // Insertar máquinas de ejemplo
        Maquina::create(['nombre' => 'Extrusora Principal', 'estado' => 'operativa']);
        Maquina::create(['nombre' => 'Moldeadora A1', 'estado' => 'operativa']);
        Maquina::create(['nombre' => 'Cortadora Industrial', 'estado' => 'en_mantenimiento']);
        Maquina::create(['nombre' => 'Selladora Automática', 'estado' => 'operativa']);

        // Insertar algunos lotes de producción
        LoteProduccion::create([
            'id_maquina' => 1,
            'id_operario' => 2,
            'fecha_inicio' => now()->subHours(4),
            'cantidad_producida' => 150,
            'estado' => 'en_proceso',
        ]);
        
        LoteProduccion::create([
            'id_maquina' => 2,
            'id_operario' => 2,
            'fecha_inicio' => now()->subDays(1),
            'fecha_fin' => now()->subHours(2),
            'cantidad_producida' => 300,
            'estado' => 'finalizado',
        ]);

        // Insertar materia prima
        MateriaPrima::create([
            'nombre' => 'Resina PVC',
            'descripcion' => 'Resina de policloruro de vinilo para producción',
            'stock_actual' => 500.00,
            'stock_minimo' => 100.00,
            'unidad_medida' => 'kg'
        ]);
        
        MateriaPrima::create([
            'nombre' => 'Pigmento Azul',
            'descripcion' => 'Colorante azul para plásticos',
            'stock_actual' => 25.50,
            'stock_minimo' => 50.00,
            'unidad_medida' => 'kg'
        ]);
        
        MateriaPrima::create([
            'nombre' => 'Estabilizador Térmico',
            'descripcion' => 'Aditivo para estabilidad térmica',
            'stock_actual' => 75.00,
            'stock_minimo' => 30.00,
            'unidad_medida' => 'kg'
        ]);

        // Insertar productos terminados
        ProductoTerminado::create([
            'nombre' => 'Tubería PVC 4 pulgadas',
            'descripcion' => 'Tubería de PVC para instalaciones sanitarias',
            'stock_actual' => 150,
            'precio_unitario' => 25.50
        ]);
        
        ProductoTerminado::create([
            'nombre' => 'Codo PVC 90°',
            'descripcion' => 'Accesorio codo de 90 grados',
            'stock_actual' => 300,
            'precio_unitario' => 3.75
        ]);
        
        ProductoTerminado::create([
            'nombre' => 'Tapa PVC',
            'descripcion' => 'Tapa para tubería PVC',
            'stock_actual' => 0,
            'precio_unitario' => 2.25
        ]);

        // Insertar clientes
        Cliente::create([
            'nombre_razon_social' => 'Constructora ABC S.R.L.',
            'nit_ci' => '1234567890',
            'telefono' => '591-2-2345678',
            'email' => 'ventas@constructoraabc.com'
        ]);
        
        Cliente::create([
            'nombre_razon_social' => 'Juan Pérez',
            'nit_ci' => '9876543210',
            'telefono' => '591-7-1234567',
            'email' => 'juan.perez@email.com'
        ]);
        
        Cliente::create([
            'nombre_razon_social' => 'Ferretería El Tornillo',
            'nit_ci' => '5555555555',
            'telefono' => '591-2-3456789',
            'email' => 'info@eltornillo.com'
        ]);

        // Insertar base de conocimiento de fallas
        BaseConocimientoFalla::create([
            'sintoma_descripcion' => 'Temperatura de la máquina excesivamente alta durante la producción',
            'causa_probable' => 'Sistema de refrigeración deficiente o filtros obstruidos',
            'recomendacion_solucion' => 'Verificar el sistema de refrigeración, limpiar filtros y revisar el flujo de aire. Si persiste, contactar mantenimiento.'
        ]);
        
        BaseConocimientoFalla::create([
            'sintoma_descripcion' => 'Presión baja en el sistema hidráulico',
            'causa_probable' => 'Fuga en el sistema hidráulico o bomba defectuosa',
            'recomendacion_solucion' => 'Inspeccionar todas las conexiones hidráulicas en busca de fugas. Verificar el estado de la bomba y los sellos.'
        ]);
        
        BaseConocimientoFalla::create([
            'sintoma_descripcion' => 'Vibración excesiva en la máquina durante operación',
            'causa_probable' => 'Desbalance en componentes rotativos o desgaste de rodamientos',
            'recomendacion_solucion' => 'Detener la máquina inmediatamente. Verificar el balance de componentes rotativos y el estado de los rodamientos.'
        ]);
        
        BaseConocimientoFalla::create([
            'sintoma_descripcion' => 'Calidad del producto final deficiente o irregular',
            'causa_probable' => 'Parámetros de producción incorrectos o materia prima de mala calidad',
            'recomendacion_solucion' => 'Revisar y ajustar parámetros de temperatura, presión y velocidad. Verificar la calidad de la materia prima utilizada.'
        ]);
    }
}