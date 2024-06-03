<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto_licencia_seccions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_proyecto');
            $table->string('nombre');
            $table->date('f_inicio');
            $table->date('f_fin');
            $table->float('total_ingreso');
            $table->float('total_costo');
            $table->float('margen');
            $table->float('porcentaje_margen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyecto_licencia_seccions');
    }
};
