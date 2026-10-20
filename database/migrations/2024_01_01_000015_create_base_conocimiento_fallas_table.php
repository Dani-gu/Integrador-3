<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('base_conocimiento_fallas', function (Blueprint $table) {
            $table->id();
            $table->text('sintoma_descripcion');
            $table->text('causa_probable')->nullable();
            $table->text('recomendacion_solucion');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('base_conocimiento_fallas');
    }
};