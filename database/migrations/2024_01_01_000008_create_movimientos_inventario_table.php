<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario_responsable')->constrained('usuarios');
            $table->foreignId('id_materia_prima')->nullable()->constrained('materia_prima');
            $table->foreignId('id_producto_terminado')->nullable()->constrained('productos_terminados');
            $table->enum('tipo_movimiento', ['entrada', 'salida_produccion', 'salida_venta', 'ajuste']);
            $table->decimal('cantidad', 10, 2);
            $table->timestamp('fecha_movimiento')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};