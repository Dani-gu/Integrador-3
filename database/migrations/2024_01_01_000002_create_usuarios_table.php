<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_rol')->constrained('roles');
            $table->string('nombre_completo', 100);
            $table->string('email', 100)->unique();
            $table->string('password_hash', 255);
            $table->timestamp('creado_en')->useCurrent();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};