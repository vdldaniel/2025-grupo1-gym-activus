<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('ID_Usuario');
            $table->unsignedBigInteger('ID_Estado_Usuario')->default(1);
            $table->string('Nombre', 100);
            $table->string('Apellido', 100);
            $table->string('Contrasena');
            $table->string('Email')->unique();
            $table->string('DNI', 15)->unique();
            $table->string('Foto_Perfil')->nullable();
            $table->string('Telefono', 30)->nullable();
            $table->date('Fecha_Alta')->default(now());
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
