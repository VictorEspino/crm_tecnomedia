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
        Schema::create('prospectos', function (Blueprint $table) {
            $table->id();
            $table->string("rfc");
            $table->string("regimen");
            $table->string("razon_social");
            $table->date("fecha_io");
            $table->string("terminos_pago");
            $table->integer("estatus");
            $table->string("calle");
            $table->string("colonia");
            $table->string("num_ext");
            $table->string("num_int");
            $table->string("cp");
            $table->string("ciudad");
            $table->string("pais");
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
        Schema::dropIfExists('prospectos');
    }
};
