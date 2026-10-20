<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pedido')->nullable()->constrained('pedidos');
            $table->foreignId('id_cliente')->constrained('clientes');
            $table->timestamp('fecha_emision')->useCurrent();
            $table->decimal('monto_total', 10, 2);
            $table->enum('estado_pago', ['pendiente', 'pagada'])->default('pendiente');
            $table->string('nit_facturacion', 20)->nullable();
            $table->string('razon_social_facturacion', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturas');
    }
};