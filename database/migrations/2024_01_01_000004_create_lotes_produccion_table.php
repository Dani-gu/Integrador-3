<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lotes_produccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_maquina')->constrained('maquinas');
            $table->foreignId('id_operario')->constrained('usuarios');
            $table->timestamp('fecha_inicio')->nullable();
            $table->timestamp('fecha_fin')->nullable();
            $table->integer('cantidad_producida')->default(0);
            $table->enum('estado', ['planificado', 'en_proceso', 'finalizado', 'cancelado'])->default('planificado');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lotes_produccion');
    }
};