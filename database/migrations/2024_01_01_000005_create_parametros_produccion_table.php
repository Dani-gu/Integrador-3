<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('parametros_produccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lote')->constrained('lotes_produccion');
            $table->decimal('temperatura', 5, 2)->nullable();
            $table->decimal('presion', 5, 2)->nullable();
            $table->decimal('cantidad_resina', 10, 2)->nullable();
            $table->timestamp('timestamp_lectura')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parametros_produccion');
    }
};