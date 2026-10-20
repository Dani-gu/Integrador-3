<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detalles_factura', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_factura')->constrained('facturas')->onDelete('cascade');
            $table->string('descripcion_item', 255);
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalles_factura');
    }
};