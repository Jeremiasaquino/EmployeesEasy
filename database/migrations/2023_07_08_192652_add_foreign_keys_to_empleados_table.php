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
        Schema::table('empleados', function (Blueprint $table) {
             // Foreign key constraints
             $table->foreign('posicione_id')->references('id')->on('posiciones')->onUpdate('cascade');
             $table->foreign('departamento_id')->references('id')->on('departamentos')->onUpdate('cascade');
             $table->foreign('horario_id')->references('id')->on('horarios')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empleados', function (Blueprint $table) {
            //
        });
    }
};
