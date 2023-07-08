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
        Schema::create('informacion_direcion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id');
            $table->string('calle');
            $table->string('numero_calle');
            $table->string('provincia');
            $table->string('municipio');
            $table->string('sector');
            $table->string('localidad');
            $table->string('edificio');
            $table->string('numero_apartamento');
            $table->string('referencia_ubicacion');
            $table->timestamps();

    // Foreign key constraint
    $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_direcion');
    }
};
