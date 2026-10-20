<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('logs_acciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->nullable()->constrained('usuarios');
            $table->string('accion_realizada', 255);
            $table->string('tabla_afectada', 50)->nullable();
            $table->integer('id_registro_afectado')->nullable();
            $table->timestamp('fecha_accion')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('logs_acciones');
    }
};