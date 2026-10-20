<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cliente')->constrained('clientes');
            $table->foreignId('id_vendedor')->constrained('usuarios');
            $table->timestamp('fecha_pedido')->useCurrent();
            $table->enum('estado', ['pendiente', 'en_proceso', 'listo_para_entrega', 'entregado', 'cancelado'])->default('pendiente');
            $table->decimal('total_pedido', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
};