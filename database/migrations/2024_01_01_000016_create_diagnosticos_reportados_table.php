<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('diagnosticos_reportados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lote')->nullable()->constrained('lotes_produccion');
            $table->foreignId('id_falla_detectada')->nullable()->constrained('base_conocimiento_fallas');
            $table->foreignId('id_usuario_reporta')->constrained('usuarios');
            $table->text('descripcion_problema')->nullable();
            $table->timestamp('fecha_reporte')->useCurrent();
            $table->enum('estado_resolucion', ['pendiente', 'en_proceso', 'resuelto'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('diagnosticos_reportados');
    }
};