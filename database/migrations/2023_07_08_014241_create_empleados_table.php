<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellidos');
            $table->date('fecha_nacimiento');
            $table->enum('genero', ['Femenino', 'Masculino', 'Otro']);
            $table->integer('edad');
            $table->string('nacionalidad');
            $table->enum('estado_civil', ['Soltero', 'Casado', 'Divorciado', 'Viudo']);
            $table->enum('tipo_identificacion', ['Cedula', 'Pasaporte']);
            $table->string('numero_identificacion')->unique();
            $table->string('numero_seguro_social')->unique();
            $table->string('numero_telefono')->unique();
            $table->string('email')->unique();
            $table->unsignedBigInteger('posicione_id');
            $table->unsignedBigInteger('departamento_id');
            $table->unsignedBigInteger('horario_id');
            $table->enum('estado', ['activo', 'inactivo', 'suspendido', 'vacaciones', 'en_licencia', 'terminado']);
            $table->string('image')->nullable();
            $table->timestamps();

           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
