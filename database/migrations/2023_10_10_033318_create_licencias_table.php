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
        Schema::create('licencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prospecto_id');
            $table->foreignId('linea_negocio_id');
            $table->foreignId('moneda_id');
            $table->string('servicio');
            $table->string('producto');
            $table->string('licencias');
            $table->integer('años_contrato');
            $table->float('precio_sin_iva');
            $table->string('proc_facturacion')->nullable();
            $table->date('inicio_vigencia');
            $table->date('fin_vigencia');
            $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('licencias');
    }
};
