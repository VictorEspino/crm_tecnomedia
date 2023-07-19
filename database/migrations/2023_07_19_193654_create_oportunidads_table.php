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
        Schema::create('oportunidads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->nullable;
            $table->foreignId('user_id');
            $table->foreignId('compania_id');
            $table->foreignId('prospecto_id');
            $table->foreignId('contacto_prospecto_id');
            $table->foreignId('linea_negocio_id');
            $table->foreignId('servicio_id');
            $table->string('oportunidad');
            $table->string('partner');
            $table->string('producto');
            $table->foreignId('etapa_id');
            $table->foreignId('moneda_id');
            $table->integer('horas_consultoria');
            $table->integer('valor_propuesta');
            $table->float('costo_fabricante');
            $table->float('costo_consultoria');
            $table->float('margen_estimado');
            $table->date('estimacion_cierre');
            $table->integer('dias_credito');
            $table->text('comentarios')->nullable();
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
        Schema::dropIfExists('oportunidads');
    }
};
